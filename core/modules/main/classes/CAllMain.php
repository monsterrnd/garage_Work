<?
class CAllMain
{
	/**
    * Хранит ошибки
    * @var array
    */
	public $Error = array();
	public $pagination_list = array();

	function SessionInit(){
		session_start();
		if (!isset($_SESSION['PRIVATE_KEY']))
		{
			$_SESSION['PRIVATE_KEY'] = hash_hmac('sha1', microtime(), mt_rand());
		}		
	}
	
	/**
    * 
    */
	function deBugTimer(){
		
	}
	/**
    * 
    */
	function PaginationRender(){
		
	}
	
	/**
    * Формерует фильтер для GetList
    * @var $filter массив либо значение
    * @var $dif ОПЕРАТОР
    */	
	function filterArray($filter,$dif = "=")
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
	
	function ParentGetList($table,$arOrder = array("ID"=>"ASC"),$arFilter = array(),$pageNav = array())
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
		
		if(count($arFilter))
		{
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
			
		}
		
	
			
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

		$limit = "";
		///Формирование постраничной навигации
		if (count($pageNav))
		{
			if ($pageNav["TOP_COUNT"])
				$limit = " LIMIT ".$pageNav["TOP_COUNT"];
			else
			{
				$DB->Query("SELECT COUNT(*) FROM `".$table."`".$sqlWhere);

				$pageNav["COUNTS_ELEMENT"]		= $DB->db_EXEC->fetchColumn();
				$pageNav["ELEMENT_TO_PAGE"]		= ($pageNav["ELEMENT_TO_PAGE"] > $pageNav["COUNTS_ELEMENT"]) ? $pageNav["COUNTS_ELEMENT"] : $pageNav["ELEMENT_TO_PAGE"];
				$pageNav["PAGES"]				= ceil($pageNav["COUNTS_ELEMENT"] / $pageNav["ELEMENT_TO_PAGE"]);
				$pageNav["END_PAGE_LIMIT"]		= $pageNav["PAGE"] * $pageNav["ELEMENT_TO_PAGE"];
				$pageNav["START_PAGE_LIMIT"]	= $pageNav["END_PAGE_LIMIT"] - $pageNav["ELEMENT_TO_PAGE"];
				$this->pagination_list			= $pageNav;
				
				$limit = " LIMIT ".$pageNav["START_PAGE_LIMIT"].",".$pageNav["ELEMENT_TO_PAGE"];
			}
		}

		$DB->Query("SELECT * FROM `".$table."`".$sqlWhere.$sOrderBy.$limit);
		$res = $DB->DBprint();
			
		//echo "<pre>";
		//print_r($countElementTable);
		//echo "</pre>";
		return  $res;
	}
	
}