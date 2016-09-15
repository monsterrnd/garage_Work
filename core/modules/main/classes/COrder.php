<?
/**
* Заказ в компанию от клиента
*/	
class COrder extends CAllMain
{
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
			$DB->Query("SELECT * FROM `ga_order` WHERE `ID` =  '".$id."'");
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
		
		if(strlen($arFieldsProp["FIRST_NAME"]) < 2)
			$this->Error["Add"][] = "Укажите имя";	
		
		if( strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Add"][] = "Телефон меньше 10 символов";	
		
		if(!$arFieldsProp["DATE"])
			$this->Error["Add"][] = "Укажите дату";	
		
		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = '".$arFieldsProp["ID_COMPANY"]."'");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Add"][] = "Компания не существует";	

		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Add"][] = "Пользователь не существует";	

		///запрос к ценам не обяз
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_order");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_order",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_order(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_order`');
			$order_id  = $DB->db_EXEC->fetchColumn();
			return $order_id;
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
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_order` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$ORDER_THIS = $DB->DBprint();	
			if ($ORDER_THIS)
			{
				$arFieldsProp = array_merge(
					$ORDER_THIS[0],
					$arFieldsProp
				);	
			}
		}	
		
		if(strlen($arFieldsProp["FIRST_NAME"]) < 2)
			$this->Error["Update"][] = "Укажите имя";	
		
		if( strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Update"][] = "Телефон меньше 10 символов";	
		
		if(!$arFieldsProp["DATE"])
			$this->Error["Update"][] = "Укажите дату";	
		
		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = '".$arFieldsProp["ID_COMPANY"]."'");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Update"][] = "Компания не существует";	

		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Update"][] = "Пользователь не существует";	

		///запрос к ценам не обяз	
		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_order");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_order",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_order(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);
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
			$DB->Query("DELETE FROM `ga_order` WHERE `ID` =  '".$id."'");			
			return $DB->DBprint();
		}
	}
}