<?
class CAllMain
{
	public $include_template_file = "";
	public $arResult = array();
	function IncludeComponentTemplate()
	{
		$arResult = $this->arResult;
		include($this->include_template_file);	
	}
	
	function IncludeComponent($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array())
	{
		$Pinc = "";
		
		if(file_exists($Pinc = $_SERVER["DOCUMENT_ROOT"].TEMPLATE_PATH."/components/".$componentName."/".$componentTemplate."/template.php"))
			$this->include_template_file = $Pinc;
		elseif(file_exists($Pinc = $_SERVER["DOCUMENT_ROOT"].ROOT."/components/".$componentName."/templates/".$componentTemplate."/template.php"))
			$this->include_template_file = $Pinc;
		else
		{
			$Pinc = $_SERVER["DOCUMENT_ROOT"].ROOT."/components/".$componentName."/templates/.default/template.php";
			$this->include_template_file = $Pinc;
		}
		
		include ($_SERVER["DOCUMENT_ROOT"].ROOT."/components/".$componentName."/component.php");
		
		
	}	
	
	function SessionInit(){
		session_start();
		if (!isset($_SESSION['PRIVATE_KEY']))
		{
			$_SESSION['PRIVATE_KEY'] = hash_hmac('sha1', microtime(), mt_rand());
		}		
	}
	
}