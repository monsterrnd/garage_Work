<?
class CUser 
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элементов
	* @param integer $id Ключа в таблице
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;

		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = (".$id.")");			
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	
	/**
	* @package Список элементов
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_user`");			
		return $DB->DBprint();
	}	

	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param string		[PHONE] Телефон
	* @param string		[FIRST_NAME] Имя
	* @param string		[EMAIL] Почта
	* @param string		[MAIN_AUTO] Авто по умолчанию
	* @param string		[AVATAR] Путь к аватарке
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->Add(array("ACTIVE"=>"Y","PHONE"=>"","FIRST_NAME"=>"","MAIN_AUTO"=>"","EMAIL"=>"","AVATAR"=>""));
	* @return array
	*/	
	function Add($arFieldsProp)
	{	
		global $DB;
		unset($arFieldsProp["ID"]);
		unset($arFieldsProp['SESSION']);
		
		if(strlen($arFieldsProp["FIRST_NAME"]) < 1)
			$this->Error["Add"][] = "Имя меньше 2 символов";	
		
		if($arFieldsProp["PHONE"] && strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Add"][] = "Телефон меньше 10 символов";	
		
		if($arFieldsProp["EMAIL"] && strlen($arFieldsProp["EMAIL"]) < 3)
			$this->Error["Add"][] = "Email меньше 4 символов";	
		
		$DB->Query(
			"SELECT * FROM `ga_user` "
			."WHERE "
			."(`EMAIL` = '".$arFieldsProp["EMAIL"]."' OR `PHONE` = '".$arFieldsProp["PHONE"]."') "
		);
		
		$user_exist = $DB->DBprint(); 
		if ($user_exist)
			$this->Error["Add"][] = "Email или Телефон уже зарегистрированы";
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{
			$SESSION = md5(microtime());

			$arFieldsProp = array_merge(
				$arFieldsProp,
				array(
					"SESSION" => $SESSION
				)
			);				

			$strTableElName = $DB->GetTableFields("ga_user");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_user",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_user(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_user`');
			$user_id  = $DB->db_EXEC->fetchColumn();
			return $user_id;
		}
		else 
		{
			return array("ERROR" =>$this->Error["Add"]);
		}
		
	}
	
	/**
	* @package Обновить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID] Ключа в таблице
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param string		[PHONE] Телефон
	* @param string		[FIRST_NAME] Имя
	* @param string		[EMAIL] Почта
	* @param string		[MAIN_AUTO] Авто по умолчанию
	* @param string		[AVATAR] Путь к аватарке
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->Update(array("ACTIVE"=>"Y","PHONE"=>"","FIRST_NAME"=>"","MAIN_AUTO"=>"","EMAIL"=>"","AVATAR"=>""));
	* @return array
	*/		
	function Update($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp['SESSION']);
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";		
		
		if(strlen($arFieldsProp["FIRST_NAME"]) < 1)
			$this->Error["Update"][] = "Имя меньше 2 символов";	
		
		if($arFieldsProp["PHONE"] && strlen($arFieldsProp["PHONE"]) < 9)
			$this->Error["Update"][] = "Телефон меньше 10 символов";	
		
		if($arFieldsProp["EMAIL"] && strlen($arFieldsProp["EMAIL"]) < 3)
			$this->Error["Update"][] = "Email меньше 4 символов";	
		
		$DB->Query(
			"SELECT * FROM `ga_user` "
			."WHERE "
			."(`EMAIL` = '".$arFieldsProp["EMAIL"]."' OR `PHONE` = '".$arFieldsProp["PHONE"]."' AND `ID` != '".$arFieldsProp["ID"]."') "
		);
		
		$user_exist = $DB->DBprint();   
		
		if ($user_exist)
			$this->Error["Update"][] = "Email или Телефон уже зарегистрированы";	
		
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID"]."'");
		$USER_THIS = $DB->DBprint();	
		
		if (is_array($arFieldsProp) && $USER_THIS  && !is_array($this->Error["Update"]))
		{
			
			$arFieldsProp = array_merge(
				$USER_THIS[0],
				$arFieldsProp
			);				
			$strTableElName = $DB->GetTableFields("ga_user");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_user",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_user(".$sqlElColum.") VALUES (".$sqlElValues.");");	

			return $arFieldsProp["ID"];
		}
		else 
		{
			return array("ERROR" =>$this->Error["Update"]);
		}		
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->Delete("");
	* @return array
	*/	
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_user` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}	
		
	
	function AuthUser($arFieldsProp)
	{	
		global $DB;
		
		$strTableElName = $DB->GetTableFields("po_user");
		list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("po_user",$arFieldsProp,$strTableElName));
	}	
}
?>