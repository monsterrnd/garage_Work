<?
/**
* Ремонт, шиномонтаж, диагностика
*/	
class CService extends CAllMain 
{
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID` = '".$id."'");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	
	/**
	* @package Список дочерних элементов
	* @param integer $id Ключа в таблице
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->GetList("");
	* @return array
	*/
	function GetParent($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID_ALLSERVICES` = '".$id."'");			
			return $DB->DBprint();
		}
	}
	/**
	* @package Список элементов
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_allservices`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param integer	[SORT] Сортировка
	* @param string		[MAINPATH] Символьный код основной категории
	* @param string		[NAME]* Название
	* @param integer	[ID_ALLSERVICES] Привязка к родителю
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->Add(array("ACTIVE"=>"Y","SORT"=>500,"MAINPATH"=>"","NAME"=>"","ID_ALLSERVICES"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		$arFieldsProp["DEPTH"] = 0;
		
		if(strlen($arFieldsProp["NAME"]) < 2)
			$this->Error["Add"][] = "Название меньше 3 символов";	
		
		if ($arFieldsProp["ID_ALLSERVICES"] != 0 || intval($arFieldsProp["ID_ALLSERVICES"]))
		{
			$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID` = '".$arFieldsProp["ID_ALLSERVICES"]."'");
			$PARENT_ID = $DB->DBprint();
			
			if (!$PARENT_ID) 
				$this->Error["Add"][] = "ID не существует";
			
			$arFieldsProp["DEPTH"] = $PARENT_ID[0]["DEPTH"] + 1;
		}
 
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{		
			$strTableElName = $DB->GetTableFields("ga_allservices");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_allservices",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_allservices(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			$DB->Query('SELECT MAX(ID) FROM `ga_allservices`');
			$service_id  = $DB->db_EXEC->fetchColumn();
		
			return $service_id;
		}
		else
			return array("ERROR" => $this->Error["Add"]);
	}
	

	/**
	* @package Обновить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID]* Ключа в таблице
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param integer	[SORT] Сортировка
	* @param string		[MAINPATH] Символьный код основной категории
	* @param string		[NAME]* Название
	* @param integer	[ID_ALLSERVICES] Привязка к родителю
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->Add(array("ID"=>"","ACTIVE"=>"Y","SORT"=>500,"MAINPATH"=>"","NAME"=>"","ID_ALLSERVICES"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
		$arFieldsProp["DEPTH"] = 0;
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$SERVICE_THIS = $DB->DBprint();	
			if ($SERVICE_THIS)
			{
				$arFieldsProp = array_merge(
					$SERVICE_THIS[0],
					$arFieldsProp
				);	
			}
		}
		
		if(strlen($arFieldsProp["NAME"]) < 2)
			$this->Error["Update"][] = "Название меньше 3 символов";	
		
		if ($arFieldsProp["ID_ALLSERVICES"] != 0 || intval($arFieldsProp["ID_ALLSERVICES"]))
		{
			$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID` = '".$arFieldsProp["ID_ALLSERVICES"]."'");
			$PARENT_ID = $DB->DBprint();
			
			if (!$PARENT_ID) 
				$this->Error["Update"][] = "ID не существует";
			
			$arFieldsProp["DEPTH"] = $PARENT_ID[0]["DEPTH"] + 1;
		}

		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]) && $SERVICE_THIS)
		{		
			$strTableElName = $DB->GetTableFields("ga_allservices");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_allservices",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_allservices(".$sqlElColum.") VALUES (".$sqlElValues.");");
		

		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);		
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CService::$Error Для размещения Ошибок
	* @todo $CSERVICE->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_allservices` WHERE `ID` = '".$id."'");			
			return $DB->DBprint();
		}
	}
}