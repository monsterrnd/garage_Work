<?
class CSpecifical
{
    /**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	/**
	* @package Элемент
	* @param integer $id Ключа в таблице
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->GetById("");
	* @return array
	*/
	function GetById($id)
	{
		global $DB;
		if (intval($id) || $id == 0)
		{		
			$DB->Query("SELECT * FROM `ga_specifical` WHERE `ID` = (".$id.")");
			$res = $DB->DBprint();
			return $res[0]; 
		}
	}
	

	/**
	* @package Список элементов
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->GetList();
	* @return array
	*/
	function GetList()
	{
		global $DB;
		$DB->Query("SELECT * FROM `ga_specifical`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Добавить элемент
	* @param array $arFieldsProp массив с параметрами таблицы 
	* @param char		[SERVICE_GUARANTEE] Авто на гарантии
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Add(array("SERVICE_GUARANTEE"=>"Y","ID_CAR_MARK"=>110,"ID_COMPANY"=>"9"));
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
	* @param char		[SERVICE_GUARANTEE] Авто на гарантии
	* @param integer	[ID_CAR_MARK] Привязка к марке авто
	* @param integer	[ID_COMPANY] Привязка к Компании
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Add(array("ID"=>"","SERVICE_GUARANTEE"=>"Y","ID_CAR_MARK"=>110,"ID_COMPANY"=>"9"));
	* @return array
	*/	
	function Update($arFieldsProp)
	{
		global $DB;
				
	}	
	
	/**
	* @package Удалить элемент
	* @param integer $id Ключа в таблице
	* @uses CSpecifical::$Error Для размещения Ошибок
	* @todo $CSPECIFICAL->Delete("");
	* @return array
	*/
	function Delete($id)
	{
		global $DB;
		
		if (intval($id))
		{		
			$DB->Query("DELETE FROM `ga_specifical` WHERE `ID` = (".$id.")");			
			return $DB->DBprint();
		}
	}
}