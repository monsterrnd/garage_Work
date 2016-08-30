<?
class CSpecifical
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_specifical` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	

	/**
	* @package Список элементов
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_specifical`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[SERVICE_GUARANTEE] Авто на гарантии
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Add(array("SERVICE_GUARANTEE"=>"","ID_CAR_MARK"=>"","ID_COMPANY"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		
		///запрос к марке авто
		$DB->Query("SELECT * FROM `car_mark` WHERE `id_car_mark` = '".$arFieldsProp["ID_CAR_MARK"]."'");
		$car_mark_exist = $DB->DBprint();
		
		if(!$car_mark_exist)
			$this->Error["Add"][] = "Автомобиль не существует";	

		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = (".$arFieldsProp["ID_COMPANY"].")");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Add"][] = "Компания не существует";	
		
		//////проверка на существование
		
		$DB->Query(
			"SELECT * FROM `ga_specifical` "
			."WHERE "
			."(`ID_CAR_MARK` = '".$arFieldsProp["ID_CAR_MARK"]."' AND `ID_COMPANY` = '".$arFieldsProp["ID_COMPANY"]."') "
		);
		
		$THIS_SPECIFICAL = $DB->DBprint();
		
		if($THIS_SPECIFICAL)
			$this->Error["Add"][] = "Значение уже установленно";	
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_specifical");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_specifical",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_specifical(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_specifical`');
			$specifical_id  = $DB->db_EXEC->fetchColumn();
			return $specifical_id;
		}
		else 
		{
			return array("ERROR" =>$this->Error["Add"]);
		}
	}
	

	/**
	* @package Обновить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID]* Ключа в таблице
	* @param char		[SERVICE_GUARANTEE] Авто на гарантии
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Add(array("ID"=>"","SERVICE_GUARANTEE"=>"","ID_CAR_MARK"=>"","ID_COMPANY"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_specifical` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$SPECIFICAL_THIS = $DB->DBprint();	
			if ($SPECIFICAL_THIS)
			{
				$arFieldsProp = array_merge(
					$SPECIFICAL_THIS[0],
					$arFieldsProp
				);	
			}
		}	
		
		///запрос к марке авто
		$DB->Query("SELECT * FROM `car_mark` WHERE `id_car_mark` = '".$arFieldsProp["ID_CAR_MARK"]."'");
		$car_mark_exist = $DB->DBprint();
		
		if(!$car_mark_exist)
			$this->Error["Update"][] = "Автомобиль не существует";	

		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = (".$arFieldsProp["ID_COMPANY"].")");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Update"][] = "Компания не существует";	
		
		$DB->Query(
			"SELECT * FROM `ga_specifical` "
			."WHERE "
			."(`ID_CAR_MARK` = '".$arFieldsProp["ID_CAR_MARK"]."' AND `ID_COMPANY` = '".$arFieldsProp["ID_COMPANY"]."' AND `ID` != '".$arFieldsProp["ID"]."') "
		);
		
		
		$THIS_SPECIFICAL = $DB->DBprint();
		
		if($THIS_SPECIFICAL)
			$this->Error["Update"][] = "Значение уже установленно";	
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_specifical");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_specifical",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_specifical(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_specifical` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}
}