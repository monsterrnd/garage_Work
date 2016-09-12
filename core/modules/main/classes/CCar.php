<?
/**
* Авто мира
*/	
class CCar extends CAllMain
{
	/**
	* @package Список марок авто
	* @uses CCar::$Error Для размещения Ошибок
	* @todo $CCAR->GetListMark();
	* @return array
	*/
	function GetListMark()
	{
		
		
		global $DB;
		$DB->Query("SELECT * FROM `car_mark`");			
		return $DB->DBprint();
	}
	
	/**
	* @package Список модель авто
	* @param integer $id Ключа в таблице
	* @uses CCar::$Error Для размещения Ошибок
	* @todo $CCAR->GetByIdModel("");
	* @return array
	*/
	function GetByIdModel($id)
	{
		global $DB;
		$DB->Query("SELECT * FROM `car_model` WHERE `id_car_mark` = (".$id.")");			
		return $res = $DB->DBprint(); 
	}
	
	/**
	* @package Список серия авто
	* @param integer $id Ключа в таблице
	* @uses CCar::$Error Для размещения Ошибок
	* @todo $CCAR->GetByIdSerie("");
	* @return array
	*/
	function GetByIdSerie($id)
	{
		global $DB;
		$DB->Query("SELECT * FROM `car_serie` WHERE `id_car_model` = (".$id.")");			
		return $res = $DB->DBprint(); 
	}	
	
	/**
	* @package Список поколение авто
	* @param integer $id Ключа в таблице
	* @uses CCar::$Error Для размещения Ошибок
	* @todo $CCAR->GetByIdGeneration("");
	* @return array
	*/
	function GetByIdGeneration($id)
	{
		global $DB;
		$DB->Query("SELECT * FROM `car_generation` WHERE `id_car_model` = (".$id.")");			
		return $res = $DB->DBprint(); 
	}
	
	/**
	* @package Список модификация авто
	* @param integer $id Ключа в таблице
	* @uses CCar::$Error Для размещения Ошибок
	* @todo $CCAR->GetByIdModification("");
	* @return array
	*/
	function GetByIdModification($id)
	{
		global $DB;
		$DB->Query("SELECT * FROM `car_modification` WHERE `id_car_model` = (".$id.")");			
		return $res = $DB->DBprint(); 
	}
	
	
	
	
	
	function GetListModification($arOrder,$arFilter,$pageNav)
	{
		return $this->ParentGetList("car_modification", $arOrder, $arFilter, $pageNav);	
	}
}
