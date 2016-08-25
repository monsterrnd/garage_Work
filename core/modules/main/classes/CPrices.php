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
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_ALLSERVICES] Привязка к услуге
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->Add(array("PRICE"=>"","COMMENT"=>"","ID_ALLSERVICES"=>"","ID_USER"=>"","ID_COMPANY"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		
	}
	

	/**
	* @package Обновить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID]* Ключа в таблице
	* @param string		[PRICE] Цена
	* @param string		[COMMENT] Доп комментарий
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_ALLSERVICES] Привязка к услуге
	* @param integer	[ID_COMPANY] Привязка к компании
	* @uses CPrices::$Error Для размещения Ошибок
	* @todo $CPRICES->Update(array("PRICE"=>"","COMMENT"=>"","ID_ALLSERVICES"=>"","ID_USER"=>"","ID_COMPANY"=>""));
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