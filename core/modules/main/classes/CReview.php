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
		///запрос к компаниям

		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_rewview");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_rewview",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_rewview(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_rewview`');
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