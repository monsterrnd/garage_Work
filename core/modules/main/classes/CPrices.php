<?
class CPrices
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_prices` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	
	/**
	* @package Список элементов
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_prices`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param string		[PRICE] Цена
	* @param string		[COMMENT] Доп комментарий
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_ALLSERVICES] Привязка к услуге
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->Add(array("PRICE"=>"","COMMENT"=>"","ID_ALLSERVICES"=>"","ID_CAR_MARK"=>"","ID_COMPANY"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		

		
		if( !$arFieldsProp["COMMENT"] && !$arFieldsProp["PRICE"])
			$this->Error["Add"][] = "Заполните цену или комментарий";	
		
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
		
		///запрос к услугам
		$DB->Query("SELECT * FROM `ga_allservices` WHERE `ID` = (".$arFieldsProp["ID_ALLSERVICES"].")");
		$cervices_exist = $DB->DBprint();
		
		if(!$cervices_exist)
			$this->Error["Add"][] = "Данная вид работ не существует";	
		
		
		//////проверка на существование
		
		$DB->Query(
			"SELECT * FROM `ga_prices` "
			."WHERE "
			."(`ID_CAR_MARK` = '".$arFieldsProp["ID_CAR_MARK"]."' AND `ID_ALLSERVICES` = '".$arFieldsProp["ID_ALLSERVICES"]."' AND `ID_COMPANY` = '".$arFieldsProp["ID_COMPANY"]."') "
		);
		
		$THIS_PRICES = $DB->DBprint();
		
		if($THIS_PRICES)
			$this->Error["Add"][] = "Цену уже назначена для данной услуги";		
		

		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_prices");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_prices",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_prices(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_prices`');
			$prices_id  = $DB->db_EXEC->fetchColumn();
			return $prices_id;
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
	* @param string		[PRICE] Цена
	* @param string		[COMMENT] Доп комментарий
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_ALLSERVICES] Привязка к услуге
	* @param integer	[ID_COMPANY] Привязка к компании
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->Update(array("PRICE"=>"","COMMENT"=>"","ID_ALLSERVICES"=>"","ID_CAR_MARK"=>"","ID_COMPANY"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
					
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_prices` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}

}