<?
/**
* Авто клиента
*/	
class CUserCar extends CAllMain
{	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CUserCar::$Error Для размещения Ошибок
	* @todo $CUSERCAR->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_user_car` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	

	/**
	* @package Список элементов
	* @uses CUserCar::$Error Для размещения Ошибок
	* @todo $CUSERCAR->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_user_car`");			
		return $DB->DBprint();
	}
	

	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param integer	[ID_USER] Привязка к Пользователю
	* @param integer	[ID_CAR_MARK] Привязка к марке 
	* @param integer	[ID_CAR_MODEL] Привязка к моделе
	* @param integer	[ID_CAR_GENERATION] Привязка к покалению
	* @param integer	[ID_CAR_SERIE] Привязка к серии
	* @param integer	[ID_CAR_MODIFICATION] Привязка к модификации
	* @uses CUserCar::$Error Для размещения Ошибок
	* @todo $CUSERCAR->Add(array("ID_USER"=>"","ID_CAR_MARK"=>"","ID_CAR_MODEL"=>"","ID_CAR_GENERATION"=>"","ID_CAR_SERIE"=>"","ID_CAR_MODIFICATION"=>""));
	* @return array
	*/
	function Add($arFieldsProp)
	{
		global $DB;
		unset($arFieldsProp["ID"]);
		
		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Add"][] = "Пользователь не существует";	
		
		///запрос к марке авто
		$DB->Query("SELECT * FROM `car_mark` WHERE `id_car_mark` = '".$arFieldsProp["ID_CAR_MARK"]."'");
		$car_mark_exist = $DB->DBprint();
	
		if(!$car_mark_exist)
			$this->Error["Add"][] = "Автомобиль не существует";	
		/**
		@TODO Возможно добавить потом
		* запрос к марке авто 
		* запрос к моделе авто
		* запрос к покалению авто
		* запрос к серии авто
		* запрос к модификации авто
		*/
		
		//////проверка на существование
		
		$DB->Query(
			"SELECT * FROM `ga_user_car` "
			."WHERE "
			."( "
			. "`ID_USER` = '".$arFieldsProp["ID_USER"]."' "
			. "AND `ID_CAR_MARK` = '".$arFieldsProp["ID_CAR_MARK"]."' "
			. "AND `ID_CAR_MODEL` = '".$arFieldsProp["ID_CAR_MODEL"]."' "
			. "AND `ID_CAR_GENERATION` = '".$arFieldsProp["ID_CAR_GENERATION"]."' "
			. "AND `ID_CAR_SERIE` = '".$arFieldsProp["ID_CAR_SERIE"]."' "
			. "AND `ID_CAR_MODIFICATION` = '".$arFieldsProp["ID_CAR_MODIFICATION"]."' "
			. ")"
		);
		
		$THIS_USERCAR = $DB->DBprint();
		
		if($THIS_USERCAR)
			$this->Error["Add"][] = "Данный авто есть у вас в списке";
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Add"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_user_car");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_user_car",$arFieldsProp,$strTableElName));
			$DB->Query("INSERT INTO ga_user_car(".$sqlElColum.") VALUES (".$sqlElValues.");");

			$DB->Query('SELECT MAX(ID) FROM `ga_user_car`');
			$user_car_id  = $DB->db_EXEC->fetchColumn();
			return $user_car_id;
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
	* @param integer	[ID_CAR_MARK] Привязка к марке 
	* @param integer	[ID_CAR_MODEL] Привязка к моделе
	* @param integer	[ID_CAR_GENERATION] Привязка к покалению
	* @param integer	[ID_CAR_SERIE] Привязка к серии
	* @param integer	[ID_CAR_MODIFICATION] Привязка к модификации
	* @uses CUserCar::$Error Для размещения Ошибок
	* @todo $CUSERCAR->Add(array("ID"=>"","ID_USER"=>"","ID_CAR_MARK"=>"","ID_CAR_MODEL"=>"","ID_CAR_GENERATION"=>"","ID_CAR_SERIE"=>"","ID_CAR_MODIFICATION"=>""));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
		
		if(!$arFieldsProp["ID"])
			$this->Error["Update"][] = "ID не указан";
		else
		{
			$DB->Query("SELECT * FROM `ga_user_car` WHERE `ID` = '".$arFieldsProp["ID"]."'");
			$USERCAR_THIS = $DB->DBprint();	
			if ($USERCAR_THIS)
			{
				$arFieldsProp = array_merge(
					$USERCAR_THIS[0],
					$arFieldsProp
				);	
			}
		}
		
		///запрос к пользователям
		$DB->Query("SELECT * FROM `ga_user` WHERE `ID` = '".$arFieldsProp["ID_USER"]."'");
		$user_exist = $DB->DBprint();
		
		if(!$user_exist)
			$this->Error["Update"][] = "Пользователь не существует";	
		
		///запрос к марке авто
		$DB->Query("SELECT * FROM `car_mark` WHERE `id_car_mark` = '".$arFieldsProp["ID_CAR_MARK"]."'");
		$car_mark_exist = $DB->DBprint();
	
		if(!$car_mark_exist)
			$this->Error["Update"][] = "Автомобиль не существует";	
		/**
		@TODO Возможно добавить потом
		* запрос к марке авто 
		* запрос к моделе авто
		* запрос к покалению авто
		* запрос к серии авто
		* запрос к модификации авто
		*/	
		
		//////проверка на существование
		
		$DB->Query(
			"SELECT * FROM `ga_user_car` "
			."WHERE "
			."( "
			. "`ID_USER` = '".$arFieldsProp["ID_USER"]."' "
			. "AND `ID_CAR_MARK` = '".$arFieldsProp["ID_CAR_MARK"]."' "
			. "AND `ID_CAR_MODEL` = '".$arFieldsProp["ID_CAR_MODEL"]."' "
			. "AND `ID_CAR_GENERATION` = '".$arFieldsProp["ID_CAR_GENERATION"]."' "
			. "AND `ID_CAR_SERIE` = '".$arFieldsProp["ID_CAR_SERIE"]."' "
			. "AND `ID_CAR_MODIFICATION` = '".$arFieldsProp["ID_CAR_MODIFICATION"]."' "
			. "AND `ID` != '".$arFieldsProp["ID"]."' "
			. ")"
		);
		
		$THIS_USERCAR = $DB->DBprint();
		if($THIS_USERCAR)
			$this->Error["Update"][] = "Данный авто есть у вас в списке";	
		
		if (is_array($arFieldsProp) && !is_array($this->Error["Update"]))
		{			
			$strTableElName = $DB->GetTableFields("ga_user_car");
			list($sqlElColum,$sqlElValues,$sqlElAll) = ($DB->PrepareInsert("ga_user_car",$arFieldsProp,$strTableElName));
			$DB->Query("REPLACE INTO ga_user_car(".$sqlElColum.") VALUES (".$sqlElValues.");");
		
			return $arFieldsProp["ID"];
		}
		else
			return array("ERROR" => $this->Error["Update"]);
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CUserCar::$Error Для размещения Ошибок
	* @todo $CUSERCAR->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_user_car` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}
}