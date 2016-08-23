<?require $_SERVER['DOCUMENT_ROOT'] . '/core/modules/main/include/prolog_before.php';

require_once(__DIR__ . '/classes/ajax.php');

$PoAjax = new PoAjax;


header('Content-type: application/json');

/*
 * Проверка на существования ajax;
*/
if (PoRequest::getRequest('method') != "ajax")
{
	$PoAjax->ErrorAjaxSet("ajax_routing","Не является ajax запросом",true);
}

/*
 * Проверка присутствия модуля;
*/
if (count(PoRequest::getRequest('modules')) < 1 )
{
	$PoAjax->ErrorAjaxSet("ajax_routing","В запросе нет обращения к модулю",true);
}

/*
 * Проверка присутствия модуля;
*/
$post_modules = PoRequest::getRequest('modules');

/*
 * Проверка сессии;
*/
$sesid = PoRequest::getRequest('PHPSESSION');

/*
 * Сортировка запросов;
*/
uasort($post_modules, function ($a, $b)
{
	if ($a["SORT"] == $b["SORT"]) {
		return 0;
	}
	return ($a["SORT"] < $b["SORT"]) ? -1 : 1;
});

/*
 * Перебор запросов
*/
foreach ($post_modules as $name_module => $params_module)
{	
	$PoAjax->IncludeModule($name_module, $params_module, $sesid);
}
	
/*
 * Ответ роутера
*/	
echo json_encode($PoAjax->ModulesAjaxGet());
