<?
class PoAjax
{
	public $ajax_error = array(); 
	public $ajax_module_output = array();
	
	public function ErrorAjaxSet($module,$error,$stop = false)
	{
		$this->ajax_error[$module][] = $error;
		
		if ($stop == true)
		{
			echo json_encode(array("error_ajax"=>$this->ajax_error));
			die();
		}
	}
	
	public function ErrorAjaxGet()
	{
		return array("error_ajax"=>$this->ajax_error);
	}
	
	public function ModulesAjaxSet($module,$params_module)
	{
		$this->ajax_module_output[$module] = $params_module;
	}
	
	public function ModulesAjaxGet()
	{
		return array("modules_return"=>$this->ajax_module_output);
	}
	
	
	public function IncludeModule($name_module,$arParams,$phpsession)
	{
		$arResult = array();

		$module_path_include = dirname(__DIR__) . "/modules/".$name_module.".php";
		if (file_exists($module_path_include))
		{
			include ($module_path_include);
			$arResult["RETURN_PARAMS"] = $arParams;
			$this->ModulesAjaxSet($name_module, $arResult);
		}
		else
		{
			$arResult["RETURN_PARAMS"] = $arParams;
			$arResult["ANSWER"] = "Модуль не найден";
			$this->ModulesAjaxSet($name_module, $arResult);
		}
	}
	
	public function IncludeModuleNoAjax($name_module)
	{
		$module_path_include = dirname(__DIR__) . "/modules/".$name_module.".php";
		if (file_exists($module_path_include))
		{
			$arResult = array();

			include ($module_path_include);

			echo $arResult["HTML"];
		}
	}	

}




