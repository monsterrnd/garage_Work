<?
class CAllMain
{
	/**
    * Хранит ошибки
    * @var array
    */
	var $Error = array();
	
	function SessionInit(){
		session_start();
		if (!isset($_SESSION['PRIVATE_KEY']))
		{
			$_SESSION['PRIVATE_KEY'] = hash_hmac('sha1', microtime(), mt_rand());
		}		
	}
	
}