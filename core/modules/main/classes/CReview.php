<?
class CReview 
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CReview::$Error Для размещения Ошибок
	* @todo $CREVIEW->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_rewview` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	
	/**
	* @package Список элементов
	* @uses CReview::$Error Для размещения Ошибок
	* @todo $CREVIEW->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_rewview`");			
		return $DB->DBprint();
	}

	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[ACTIVE] Активность Элемента (Y/N)
	* @param char		[ANONIME] Анонимно (Y/N)
	* @param integer	[RATING] рейтинг от  1 до 5
	* @param string		[DESCRIPTION] текст отзыва
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CReview::$Error Для размещения Ошибок
	* @todo $CREVIEW->Add(array("ACTIVE"=>"Y","ANONIME"=>"N","RATING"=>"5","DESCRIPTION"=>"","ID_USER"=>"","ID_COMPANY"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		
		if($arFieldsProp["RATING"] < 1 || $arFieldsProp["RATING"] > 5)
			$this->Error["Add"][] = "Поставте отценку от 1 до 5";	
		
		if( strlen($arFieldsProp["DESCRIPTION"]) < 2)
			$this->Error["Add"][] = "Вы не написали отзыв";	
		
		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Add"][] = "Пользователь не существует";	

		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = (".$arFieldsProp["ID_COMPANY"].")");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Add"][] = "Компания не существует";	
		
		$DB->Query(
			"SELECT * FROM `ga_rewview` "
			."WHERE "
			."(`ID_COMPANY` = '".$arFieldsProp["ID_COMPANY"]."' AND `ID_USER` = '".$arFieldsProp["ID_USER"]."') "
		);
		$THIS_REVIEW = $DB->DBprint();
		
		if($THIS_REVIEW)
			$this->Error["Add"][] = "Вы уже оставляли отзыв для данной компании";		
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_rewview");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_rewview",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_rewview(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_rewview`');
			$review_id  = $DB->db_EXEC->fetchColumn();
			return $review_id;
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
	* @param char		[ANONIME] Анонимно (Y/N)
	* @param integer	[RATING] рейтинг от  1 до 5
	* @param string		[DESCRIPTION] текст отзыва
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CReview::$Error Для размещения Ошибок
	* @todo $CREVIEW->Update(array("ID"=>"","ACTIVE"=>"Y","ANONIME"=>"N","RATING"=>"5","DESCRIPTION"=>"","ID_USER"=>"","ID_COMPANY"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_rewview` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$REVIEW_THIS = $DB->DBprint();	
			if ($REVIEW_THIS)
			{
				$arFieldsProp = array_merge(
					$REVIEW_THIS[0],
					$arFieldsProp
				);	
			}
		}

			if($arFieldsProp["RATING"] < 1 || $arFieldsProp["RATING"] > 5)
			$this->Error["Update"][] = "Поставте отценку от 1 до 5";	
		
		if( strlen($arFieldsProp["DESCRIPTION"]) < 2)
			$this->Error["Update"][] = "Вы не написали отзыв";	
		
		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Update"][] = "Пользователь не существует";	

		///запрос к компаниям
		$DB->Query("SELECT * FROM `ga_company` WHERE `ID` = (".$arFieldsProp["ID_COMPANY"].")");
		$company_exist = $DB->DBprint();
		
		if(!$company_exist)
			$this->Error["Update"][] = "Компания не существует";	
		
		$DB->Query(
			"SELECT * FROM `ga_rewview` "
			."WHERE "
			."( "
			. "`ID_COMPANY` = '".$arFieldsProp["ID_COMPANY"]."' "
			. "AND `ID_USER` = '".$arFieldsProp["ID_USER"]."' "
			. " AND `ID` != '".$arFieldsProp["ID"]."' "
			. ")"
		);
		$THIS_REVIEW = $DB->DBprint();
		
		if($THIS_REVIEW)
			$this->Error["Update"][] = "Вы уже оставляли отзыв для данной компании";		
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_rewview");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_rewview",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_rewview(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);			
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CReview::$Error Для размещения Ошибок
	* @todo $CREVIEW->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_rewview` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}

}