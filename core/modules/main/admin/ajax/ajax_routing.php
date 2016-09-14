<?require $_SERVER['DOCUMENT_ROOT'] . '/core/modules/main/admin/include/prolog_before.php';

require_once(__DIR__ . '/classes/ajax.php');

$AdminAjax = new AdminAjax;


header('Content-type: application/json');

/*
 * Проверка на существования ajax;
*/
if (CRequest::getRequest('method') != "ajax")
{
	$AdminAjax->ErrorAjaxSet("ajax_routing","Не является ajax запросом",true);
}

/*
 * Проверка присутствия модуля;
*/
if (count(CRequest::getRequest('modules')) < 1 )
{
	$AdminAjax->ErrorAjaxSet("ajax_routing","В запросе нет обращения к модулю",true);
}

/*
 * Проверка присутствия модуля;
*/
$post_modules = CRequest::getRequest('modules');

/*
 * Проверка сессии;
*/
$sesid = CRequest::getRequest('PHPSESSION');

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
	$AdminAjax->IncludeModule($name_module, $params_module, $sesid);
}
	
/*
 * Ответ роутера
*/	
echo json_encode($AdminAjax->ModulesAjaxGet());
