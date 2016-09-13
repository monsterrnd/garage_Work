<?
class CAllMain
{
	/**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	function SessionInit(){
		session_start();
		if (!isset($_SESSION['PRIVATE_KEY']))
		{
			$_SESSION['PRIVATE_KEY'] = hash_hmac('sha1', microtime(), mt_rand());
		}		
	}
	
	function filterArray($filter,$dif = " = ")
	{
		$sql = "";
		if (is_array($filter))
		{
			foreach ($filter as $filterEl)
			{
				if($sql=="")
				{
					if ($dif == "!=")
						$sql = " NOT";
					$sql .= " IN( ";
				}
					
				else
					$sql .= ", ";
				$sql .= "'".$filterEl."'";
			}
			$sql .= ") ";
		}
		else 
		{
			$sql = " ".$dif." '".$filter."'";
		}
		
		return $sql;
	}
	
	function ParentGetList($table,$arOrder = array("ID"=>"ASC"),$arFilter = array(),$pageNav = false)
	{
		global $DB;
		
		///////////order
		$strTableElNameOrder = $DB->GetTableFields($table);
		list(,,$arOrder) = ($DB->PrepareInsert($table,$arOrder,$strTableElNameOrder));
		
		$sOrderBy = "";
		if ($arOrder)
		{
			foreach($arOrder as $arOrderKey=>$arOrderEl)
			{
				if(strlen($arOrderEl))
				{
					if($sOrderBy=="")
						$sOrderBy = " ORDER BY ";
					else
						$sOrderBy .= ", ";

					$sOrderBy .= "`".$arOrderKey."` ".$arOrderEl;
				}
			}
		}
		
		//////////filter
		$typeWhere= array("<=",">=","!!","<<",">>");
		$arrayNotWhere = array();
		
		foreach ($arFilter as $arFilterKey=>$arFilterEl)
		{
			$newFilterKey = $arFilterKey;
			foreach ($typeWhere as $typeWhereEl)
			{
				$pos = stripos($arFilterKey, $typeWhereEl);
				if($pos !== false)
				{
					$noTypeTag = str_replace($typeWhereEl, "", $arFilterKey);
					$arrayNotWhere[$noTypeTag] = $typeWhereEl;	
					$newFilterKey = $noTypeTag;			
				}

			}
			
			$arFilterCorrect[$newFilterKey] = $arFilterEl;
		}
		
		$strTableElNameOrder = $DB->GetTableFields($table);
		list(,,$arFilterCorrect) = ($DB->PrepareInsert($table,$arFilterCorrect,$strTableElNameOrder));	
			
		$sqlWhere ="";
		$logic = " AND ";
		if ($arFilterCorrect)
		{
			foreach ($arFilterCorrect as $arFilterCorrectKey=>$arFilterCorrectEl)
			{

				if($sqlWhere=="")
					$sqlWhere .=" WHERE "; 
				else
					$sqlWhere .= $logic;

				switch ($arrayNotWhere[$arFilterCorrectKey]) 
				{
					case "<<":
						//меньше
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,"<");
					break;
					case "<=":
						//меньше либо равно
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,"<=");
					break;
					case ">>":
						//больше
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,">");
					break;

					case ">=":
						//больше либо равно
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,">=");
					break;
					case "!!":
						//не равно
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,"!=");
					break;
					default:
						//без условия
						$sqlWhere .= "`".$arFilterCorrectKey."`".$this->filterArray($arFilterCorrectEl,"=");
					break;
				}
			}
		}

		
		
		
		echo "SELECT * FROM `".$table."`".$sqlWhere.$sOrderBy." LIMIT 30";

		

		//ORDER BY `id_car_model` DESC, `name` DESC  
		//WHERE `id_car_model` IN ('350','353') AND `name` IN ('1.4 HDi AT (68 л. с.)')
		//LIMIT 49100,20
		//echo $sOrderBy;
		
		$DB->Query("SELECT * FROM `".$table."`".$sqlWhere.$sOrderBy." LIMIT 30");			
		return $res = $DB->DBprint(); 
	}
	
}