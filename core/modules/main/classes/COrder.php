<?
class COrder
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses COrder::$Error Для размещения Ошибок
	* @todo $CORDER->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_order` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	

	/**
	* @package Список элементов
	* @uses COrder::$Error Для размещения Ошибок
	* @todo $CORDER->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_order`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_PRICES] Привязка к Цене
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @param string		[FIRST_NAME] Имя клиента
	* @param string		[PHONE] Телефон
	* @param string		[DATE] На какую дату заказ
	* @param string		[COMMENT] Комментарий к заказу
	* @uses COrder::$Error Для размещения Ошибок
	* @todo $CORDER->Add(array("ID_USER"=>"","ID_PRICES"=>"","ID_COMPANY"=>"","FIRST_NAME"=>"","PHONE"=>"","DATE"=>"","COMMENT"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		
	}
	

	/**
	* @package Обновить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID]* Ключа в таблице
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_PRICES] Привязка к Цене
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @param string		[FIRST_NAME] Имя клиента
	* @param string		[PHONE] Телефон
	* @param string		[DATE] На какую дату заказ
	* @param string		[COMMENT] Комментарий к заказу
	* @uses COrder::$Error Для размещения Ошибок
	* @todo $CORDER->Add(array("ID"=>"","ID_USER"=>"","ID_PRICES"=>"","ID_COMPANY"=>"","FIRST_NAME"=>"","PHONE"=>"","DATE"=>"","COMMENT"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
		
		
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses COrder::$Error Для размещения Ошибок
	* @todo $CORDER->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_order` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}
}