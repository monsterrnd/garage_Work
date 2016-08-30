<?
class CUserCar
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
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
	
	ID_USER	integer(16)	  
	ID_CAR_MARK	integer(16)	  
	ID_CAR_MODEL	integer(16)	  
	ID_CAR_GENERATION	integer(16)	  
	ID_CAR_SERIE	integer(16)	  
	ID_CAR_MODIFICATION	integer(16)	
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