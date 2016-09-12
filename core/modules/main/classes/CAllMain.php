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

					$sOrderBy .= "`".$arOrderKey."` ".$arOrderEl." ";
				}
			}
		}
		
		//////////filter
		
		
		
		$typeWhere= array("!","<","<=",">",">=");
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
					$arrayNotWhere[$noTypeTag] = $arFilterKey;
					
					$newFilterKey = $noTypeTag;
					
					echo "<pre>";
					print_r($pos."-".$typeWhereEl."-".$arFilterKey."-".$bodytag);
					echo "</pre>";					
				}

			}
			
			$arFilterCorrect[$newFilterKey] = $arFilterEl;
		}
		
		echo "<pre>";
		print_r($arFilter);
		print_r($arFilterCorrect);
		print_r($arrayNotWhere);
		echo "</pre>";	
		
		
		
		
		//$strTableElNamefilter = $DB->GetTableFields($table);
		//list(,,$arFilter) = ($DB->PrepareInsert($table,$arFilter,$strTableElNamefilter));	
		
		
		
		
		
		
		

		

		//ORDER BY `id_car_model` DESC, `name` DESC  
		//WHERE `id_car_model` IN ('350','353') AND `name` IN ('1.4 HDi AT (68 л. с.)')
		//LIMIT 49100,20
		//echo $sOrderBy;
		
		$DB->Query("SELECT * FROM `".$table."`".$sOrderBy."LIMIT 20");			
		return $res = $DB->DBprint(); 
	}
	
}