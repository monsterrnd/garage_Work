<?
/**
* Данные о компании
*/	
class CCompany extends CAllMain 
{
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CCompany::$Error Для размещения Ошибок
	* @todo $CCOMPANY->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_company` WHERE `ID` =  '".$id."'");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	
	/**
	* @package Список элементов
	* @uses CCompany::$Error Для размещения Ошибок
	* @todo $CCOMPANY->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_company`");			
		return $DB->DBprint();
	}

	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param string		[NAME]* Название компании
	* @param string		[PHONE]* Телефон
	* @param string		[ADDRESS]* Адресс
	* @param string		[ADDRESS_MAP] Адресс MAP
	* @param string		[EMAIL]* Почта
	* @param string		[LOGO] Путь к аватарке
	* @param string		[DESCRIPTION] Описание компании
	* @uses CCompany::$Error Для размещения Ошибок
	* @todo $CCOMPANY->Add(array("NAME"=>"","ACTIVE"=>"Y","PHONE"=>"","ADDRESS"=>"","ADDRESS_MAP"=>"","EMAIL"=>"","LOGO"=>"","DESCRIPTION"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		
		if(strlen($arFieldsProp["NAME"]) < 2)
			$this->Error["Add"][] = "Название компании меньше 3 символов";	
		
		if( strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Add"][] = "Телефон меньше 10 символов";	
		
		if(strlen($arFieldsProp["ADDRESS"]) < 9)
			$this->Error["Add"][] = "Адресс не может быть таким";	
		
		if(strlen($arFieldsProp["EMAIL"]) < 3)
			$this->Error["Add"][] = "Email меньше 4 символов";	
		
		$DB->Query(
			"SELECT * FROM `ga_company` "
			."WHERE "
			."(`NAME` = '".$arFieldsProp["NAME"]."' AND `PHONE` = '".$arFieldsProp["PHONE"]."') "
		);
		
		$company_exist = $DB->DBprint();
		if ($company_exist)
			$this->Error["Add"][] = "Название компании и Телефон уже зарегистрированы";	
		
		if (is_array($arFieldsProp) && !$company_exist && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_company");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_company",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_company(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_company`');
			$company_id  = $DB->db_EXEC->fetchColumn();
			return $company_id;
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
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param string		[NAME]* Название компании
	* @param string		[PHONE]* Телефон
	* @param string		[ADDRESS]* Адресс
	* @param string		[ADDRESS_MAP] Адресс MAP
	* @param string		[EMAIL]* Почта
	* @param string		[LOGO] Путь к аватарке
	* @param string		[DESCRIPTION] Описание компании
	* @uses CCompany::$Error Для размещения Ошибок
	* @todo $CCOMPANY->Add(array("ID"=>"","NAME"=>"Y","ACTIVE"=>"Y","PHONE"=>"","ADDRESS"=>"","ADDRESS_MAP"=>"","EMAIL"=>"","LOGO"=>"","DESCRIPTION"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;

		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$COMPANY_THIS = $DB->DBprint();	
			if ($COMPANY_THIS)
			{
				$arFieldsProp = array_merge(
					$COMPANY_THIS[0],
					$arFieldsProp
				);	
			}
		}
		
		if(strlen($arFieldsProp["NAME"]) < 2)
			$this->Error["Update"][] = "Название компании меньше 3 символов";	
		
		if( strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Update"][] = "Телефон меньше 10 символов";	
		
		if(strlen($arFieldsProp["ADDRESS"]) < 9)
			$this->Error["Update"][] = "Адресс не может быть таким";	
		
		if(strlen($arFieldsProp["EMAIL"]) < 3)
			$this->Error["Update"][] = "Email меньше 4 символов";	
		
		$DB->Query(
			"SELECT * FROM `ga_company`"
			."WHERE "
			."(`NAME` = '".$arFieldsProp["NAME"]."' AND `PHONE` = '".$arFieldsProp["PHONE"]."' AND `ID` != '".$arFieldsProp["ID"]."') "
		);
		
		$company_exist = $DB->DBprint();

		if ($company_exist)
			$this->Error["Update"][] = "Название компании и Телефон уже зарегистрированы";	
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]) && $COMPANY_THIS)
		{		
			$strTableElName = $DB->GetTableFields("ga_company");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_company",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_company(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);			
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CCompany::$Error Для размещения Ошибок
	* @todo $CCOMPANY->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_company` WHERE `ID` =  '".$id."'");		
			return $DB->DBprint();
		}
	}
}