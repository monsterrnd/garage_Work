<?require($_SERVER["DOCUMENT_ROOT"]."/core/modules/main/root.php");?>
<?
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
$REST = new CRestMethod;	
$CAllMain = new CAllMain;	
	


$filelist = array();

if ($get = $REST->method("get","/services/"))
{
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"), array("ID_ALLSERVICES"=>0), array());
	$filelist[] = $res;
}
if ($get = $REST->method("get","/services/{%}/"))
{
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"),array("ID_ALLSERVICES"=>$get["REQUEST"][1]), array());
	$filelist[] = $res;
}

if ($get = $REST->method("get","/services/{%}/{%}/"))
{
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"), array("ID_ALLSERVICES"=>$get["REQUEST"][2]), array());
	$filelist[] = $res;
}

if ($get = $REST->method("get","/services/{%}/{%}/{%}/"))
{
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"), array("ID_ALLSERVICES"=>$get["REQUEST"][3]), array());
	$filelist[] = $res;
}

if ($get = $REST->method("get","/auto/"))
{
	$res = $CAllMain->ParentGetList("car_mark", array(), array(), array());
	$filelist[] = $res;
}

if ($get = $REST->method("get","/auto/{%}/"))
{
	$res = $CAllMain->ParentGetList("car_model", array(), array("id_car_mark"=>$get["REQUEST"][1]), array());
	$filelist[] = $res;
}
if ($get = $REST->method("get","/auto/{%}/{%}/"))
{
	$res = $CAllMain->ParentGetList("car_generation", array(), array("id_car_model"=>$get["REQUEST"][2]), array());
	$filelist[] = $res;
}
if ($get = $REST->method("get","/auto/{%}/{%}/{%}/"))
{
	$res = $CAllMain->ParentGetList("car_serie", array(), array("id_car_generation"=>$get["REQUEST"][3]), array());
	$filelist[] = $res;
}
if ($get = $REST->method("get","/auto/{%}/{%}/{%}/{%}/"))
{
	$res = $CAllMain->ParentGetList("car_modification", array(), array("id_car_serie"=>$get["REQUEST"][4]), array());
	$filelist[] = $res;
}

if ($get = $REST->method("get","/company/"))
{
	$res = $CAllMain->ParentGetList("ga_company", array(), array(), array());
	$filelist[] = $res;
}

///запись
if ($filelist)
{
	echo json_encode($filelist);
	//echo "<pre>";
	//print_r($filelist);
	//echo "</pre>";
}
?>