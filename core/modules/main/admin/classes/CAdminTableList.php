CAdminTableList
<?
/**
* таблица для работы с базой
*/	
class CAdminTableList 
{
	/**
	* @package Элементов
	* @param integer $id Ключа в таблице
	* @uses CUser::$Error Для размещения Ошибок
	* @todo $CUSER->GetById("");
	* @return array
	*/
	function GetById($id)
	{
