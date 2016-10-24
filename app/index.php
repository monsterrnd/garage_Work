<?require($_SERVER["DOCUMENT_ROOT"]."/core/modules/main/root.php");?>
<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, PUT");
header('Content-type: application/json');
$REST = new CRestMethod;	
$CAllMain = new CAllMain;	


global $USER;
$user = "asdfasdfasdf";
$USER  = $CAllMain->ParentGetList("ga_user", array("SORT"=>"asc"), array("SESSION"=>$user), array());
$USER = reset($USER);


$filelist = array();


if ($get = $REST->method("get","/services/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"), array("ID_ALLSERVICES"=>0), array());
	
	foreach ($res as $key => $arItem) {
		$result[$key]["ID"] = $arItem["ID"];
		$result[$key]["NAME"] = $arItem["NAME"];
		
	}	
	if (count($result))
		$filelist["LIST"] = $result;
}

if ($get = $REST->method("get","/services/{%}/"))
{
	
	$result = array();
	
	$res = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"),array("ID_ALLSERVICES"=>$get["REQUEST"][1]), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["ID"] = $arItem["ID"];
		$result[$key]["NAME"] = $arItem["NAME"];
		
	}
	
	if (count($result))
		$filelist["LIST"] = $result;
	
	if (!count($res))
	{
		////проверка существует услуга в бд если существует берем эту услугу для выборки
		$exist_service = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"),array("ID"=>$get["REQUEST"][1]), array());
		if (count($exist_service))
		{
			$exist_service = reset($exist_service);
			
			////Подгружаем данные пользователя
			if ($USER)
			{			
				////Подгружаем авто пользователя
				$auto = $CAllMain->ParentGetList("ga_user_car", array("SORT"=>"asc"), array("ID_USER"=>$USER["ID"],"ID"=>$USER["MAIN_AUTO"]), array());
				if (count($auto))
				{
					$auto = reset($auto);
					
					////Показываем цены по выбранной услуге
					$price = $CAllMain->ParentGetList("ga_prices", array("SORT"=>"asc"), array("ID_CAR_MARK"=>$auto["ID_CAR_MARK"],"ID_ALLSERVICES"=>$exist_service["ID"]), array());
					if (count($price))
					{		
						
						$companySelect = array();
						$priceSortId = array();
						////Собераем масив с прайсами для выборки компаний
						foreach ($price as $priceKey => $priceItem) 
						{
							$companySelect[] =  $priceItem["ID_COMPANY"];
							$priceSortId[$priceItem["ID_COMPANY"]] = $priceItem;
						}
						if (count($companySelect))
						{
							///Запрос к компаниям по ID полученого из $companySelect;
							$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ACTIVE"=>"Y","ID"=>$companySelect), array());
							
							if (count($company))
							{
								////собераем ответ роутора
								foreach ($company as $companyKey => $companyItem) 
								{
									$logo = $CAllMain->ParentGetList("ga_media_link", array(), array("GROUP_FOTO_ID"=>$companyItem["LOGO"],"SIZE"=>150));
									$logo = reset($logo);
									$result[$companyKey]["ID"]				= $companyItem["ID"];
									$result[$companyKey]["PRICE"]			= $priceSortId[$companyItem["ID"]]["PRICE"];
									$result[$companyKey]["COMMENT"]			= $priceSortId[$companyItem["ID"]]["COMMENT"];
									$result[$companyKey]["NAME"]			= $companyItem["NAME"];
									$result[$companyKey]["LOGO"]			= $logo["PATH"];
									$result[$companyKey]["ADDRESS"]			= $companyItem["ADDRESS"];
									$result[$companyKey]["DESCRIPTION"]		= $companyItem["DESCRIPTION"];
								}
								$filelist["LIST_BLOCK"] = $result;
							}
						}
					}
					
				}

			}
		}
	}

	
}

if ($get = $REST->method("get","/services/{%}/{%}/"))
{
	$result = array();
	$date = array();
	///// добавляем дату на 2 недели
	for ($i = 0; $i <= 13; $i++) 
	{
		$thisdate = date("d")+$i.".".date("m").".".date("Y");
		$date[$i]["value"] = $thisdate;
		if ($i == 0) 
			$date[$i]["name"]  = "сегодня";
		else
			$date[$i]["name"]  = $thisdate;
	}
	  
	////проверка существует услуга в бд если существует берем эту услугу для выборки
	$exist_service = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"),array("ID"=>$get["REQUEST"][1]), array());
	if (count($exist_service))
	{
		$exist_service = reset($exist_service);

		////Подгружаем данные пользователя
		if ($USER)
		{

			////Подгружаем авто пользователя
			$auto = $CAllMain->ParentGetList("ga_user_car", array("SORT"=>"asc"), array("ID_USER"=>$USER["ID"],"ID"=>$USER["MAIN_AUTO"]), array());
			if (count($auto))
			{
				$auto = reset($auto);
				
				///Запрос к компаниям по ID полученого из $get["REQUEST"][1];
				$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ACTIVE"=>"Y","ID"=>$get["REQUEST"][2]), array());
				
				if (count($company))
				{
					$company = reset($company);
					$price = $CAllMain->ParentGetList("ga_prices", array("SORT"=>"asc"), array("ID_CAR_MARK"=>$auto["ID_CAR_MARK"],"ID_ALLSERVICES"=>$exist_service["ID"],"ID_COMPANY"=>$company["ID"]), array());
					
					$review = $CAllMain->ParentGetList("ga_rewview", array("SORT"=>"asc"), array("ID_COMPANY"=>$company["ID"],"ID_USER"=>$USER["ID"]), array());
					$result["REVIEW_LIST"] = $review;
					
					$result["USER"]["PHONE"] = $USER["PHONE"];
					$result["USER"]["FIRST_NAME"] = $USER["FIRST_NAME"];
					
					if (count($price))
					{
						$price = reset($price);
						$logo = $CAllMain->ParentGetList("ga_media_link", array(), array("GROUP_FOTO_ID"=>$company["LOGO"],"SIZE"=>150));
						$logo = reset($logo);
						$result["ID"]				= $company["ID"];
						$result["DATE"]				= $date;
						$result["PRICE"]			= $price["PRICE"];
						$result["SERVICE_NAME"]		= $exist_service["NAME"];
						$result["COMMENT"]			= $price["COMMENT"];
						$result["NAME"]				= $company["NAME"];
						$result["LOGO"]				= $logo["PATH"];
						$result["ADDRESS"]			= $company["ADDRESS"];
						$result["ADDRESS_MAP"]		= $company["ADDRESS_MAP"];
						$result["DESCRIPTION"]		= $company["DESCRIPTION"];	
						
						$result["COUNT_REVIEW"]		= 100;	
						
						$filelist["DETAIL"] = $result;
					}
				}
			}

		}
	}
	

	
}


///список авто пользователя
if ($get = $REST->method("get","/car_user/"))
{

	$result = array();
	$params = array();
	

	$res = $CAllMain->ParentGetList("ga_user_car", array("SORT"=>"asc"),array("ID_USER"=>$USER["ID"]), array()); 
	
	foreach ($res as $key => $arItem) {
		$result[$key]["ID"]	  = $arItem["ID"];	
		$result[$key]["NAME"] = $arItem["FULL_NAME_CAR"];
		$result[$key]["DEF"]  = ($USER["MAIN_AUTO"] == $arItem["ID"]) ? "Y" : "";
	}	
	
	$filelist["LIST_AUTO"] = $result;
}

/// построить список для добавления авто
if ($get = $REST->method("get","/car_user/{%}/"))
{
	$result = array(1,2);
	$filelist["CARS_ADD"] = $result;
	
}

if ($post = $REST->method("post","/set_main_auto/"))
{
	$res = $CAllMain->ParentUpdate("ga_user", array("ID"=>52,"MAIN_AUTO"=>$post["PARAMS"]["ID"])); ////@TODO добавить пользователя
	
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
if ($get = $REST->method("get","/auto/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("car_mark", array(), array(), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["id"] = $arItem["id_car_mark"];
		$result[$key]["name"] = CAllMain::QuotesRemove($arItem["name"]);
	}
	
	$filelist["MARK_LIST"] = $result;
}

if ($get = $REST->method("get","/auto/{%}/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("car_model", array(), array("id_car_mark"=>$get["REQUEST"][1]), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["id"] = $arItem["id_car_model"];
		$result[$key]["name"] = CAllMain::QuotesRemove($arItem["name"]);
	}
	$filelist["MODEL_LIST"] = $result;
}

if ($get = $REST->method("get","/auto/{%}/{%}/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("car_generation", array(), array("id_car_model"=>$get["REQUEST"][2]), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["id"] = $arItem["id_car_generation"];
		$result[$key]["name"] = CAllMain::QuotesRemove($arItem["name"]);
	}
	$filelist["GENERATION_LIST"] = $result;
}

if ($get = $REST->method("get","/auto/{%}/{%}/{%}/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("car_serie", array(), array("id_car_generation"=>$get["REQUEST"][3]), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["id"] = $arItem["id_car_serie"];
		$result[$key]["name"] = CAllMain::QuotesRemove($arItem["name"]);
	}
	$filelist["SERIE_LIST"] = $result;
}

if ($get = $REST->method("get","/auto/{%}/{%}/{%}/{%}/"))
{
	$result = array();	
	$res = $CAllMain->ParentGetList("car_modification", array(), array("id_car_serie"=>$get["REQUEST"][4]), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["id"] = $arItem["id_car_modification"];
		$result[$key]["name"] = CAllMain::QuotesRemove($arItem["name"]);
	}
	$filelist["MODIFICATION_LIST"] = $result;
}

////добавляем авто
if ($post = $REST->method("post","/auto/"))
{
	$result = array();
	
	$name_auto = "";
	///@TODO исправить на ParentGetById
	$CAR_MARK = $CAllMain->ParentGetList("car_mark", array(), array("id_car_mark"=>$post["PARAMS"]["ID_CAR_MARK"]), array());
	$CAR_MARK = reset($CAR_MARK);
	$name_auto .= (($CAR_MARK["name"]) ? $CAR_MARK["name"] : "");

	///@TODO исправить на ParentGetById
	$CAR_MODEL = $CAllMain->ParentGetList("car_model", array(), array("id_car_model"=>$post["PARAMS"]["ID_CAR_MODEL"]), array());
	$CAR_MODEL = reset($CAR_MODEL);
	$name_auto .= (($CAR_MODEL["name"]) ? (", ".$CAR_MODEL["name"]) : "");
	
	///@TODO исправить на ParentGetById
	$CAR_GENERATION = $CAllMain->ParentGetList("car_generation", array(), array("id_car_generation"=>$post["PARAMS"]["ID_CAR_GENERATION"]), array());
	$CAR_GENERATION = reset($CAR_GENERATION);
	$name_auto .= (($CAR_GENERATION["name"]) ? (", ".$CAR_GENERATION["name"]) : "");

	///@TODO исправить на ParentGetById
	$ID_CAR_SERIE = $CAllMain->ParentGetList("car_serie", array(), array("id_car_serie"=>$post["PARAMS"]["ID_CAR_SERIE"]), array());
	$ID_CAR_SERIE = reset($ID_CAR_SERIE);
	$name_auto .= (($ID_CAR_SERIE["name"]) ? (", ".$ID_CAR_SERIE["name"]) : "");
	
	///@TODO исправить на ParentGetById
	$ID_CAR_MODIFICATION = $CAllMain->ParentGetList("car_modification", array(), array("id_car_modification"=>$post["PARAMS"]["ID_CAR_MODIFICATION"]), array());
	$ID_CAR_MODIFICATION = reset($ID_CAR_MODIFICATION);	
	$name_auto .= (($ID_CAR_MODIFICATION["name"]) ? (", ".$ID_CAR_MODIFICATION["name"]) : "");
	
	$result["ID_USER"]				= $USER["ID"]; 
	$result["ID_CAR_MARK"]			= $post["PARAMS"]["ID_CAR_MARK"];		
	$result["ID_CAR_MODEL"]			= $post["PARAMS"]["ID_CAR_MODEL"];		
	$result["ID_CAR_GENERATION"]	= $post["PARAMS"]["ID_CAR_GENERATION"];
	$result["ID_CAR_SERIE"]			= $post["PARAMS"]["ID_CAR_SERIE"];		
	$result["ID_CAR_MODIFICATION"]	= $post["PARAMS"]["ID_CAR_MODIFICATION"];
	$result["FULL_NAME_CAR"]		= $name_auto;

	$res = $CAllMain->ParentAdd("ga_user_car", $result);

	
	$filelist["ADD_CAR"] = $res;
}

///удалить авто
if ($delete = $REST->method("DELETE","/auto/{%}/"))
{
	$result = array();
	$res = $CAllMain->ParentDelete("ga_user_car", $delete["REQUEST"][1]);
	$filelist["ADD_DELETE"] = $res;
}
//
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////





///список заявок
if ($get = $REST->method("get","/order/"))
{
	$res = $CAllMain->ParentGetList("ga_order", array("SORT"=>"asc"),array("ID_USER"=>$USER["ID"]), array()); 
	foreach ($res as $keyOrder => &$arItemOrder) {
		$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ID"=>$arItemOrder["ID_COMPANY"]), array());
		$company = reset($company);
		$arItemOrder["COMPANY_NAME"] = $company["NAME"];
	}
	
	
	$filelist["LIST_ORDER"] = $res;
}
//заявка детально
if ($get = $REST->method("get","/order/{%}/"))
{
	$order = $CAllMain->ParentGetList("ga_order", array("SORT"=>"asc"),array("ID"=>$get["REQUEST"][1],"ID_USER"=>$USER["ID"]), array());
	$order = reset($order);

	$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ID"=>$order["ID_COMPANY"]), array());
	$company = reset($company);
	
	$logo = $CAllMain->ParentGetList("ga_media_link", array(), array("GROUP_FOTO_ID"=>$company["LOGO"],"SIZE"=>150));
	$logo= reset($logo);
	$company["LOGO"]  = $logo["PATH"];
	$order["COMPANY"] = $company;
	
	$review = $CAllMain->ParentGetList("ga_rewview", array("SORT"=>"asc"), array("ID_COMPANY"=>$company["ID"],"ID_USER"=>$USER["ID"]), array());
	$order["REVIEW_LIST"] = $review;	
	
	$filelist["DETAIL_ORDER"] = $order;
}

///добавить заявку
if ($post = $REST->method("post","/order/"))
{
	$result = array();					
	$user_new_info = array();					
				
	$user_new_info["ID"]			= $USER["ID"];
	$user_new_info["FIRST_NAME"]	= $post["PARAMS"]["NAME"]; 
	$user_new_info["PHONE"]			= $post["PARAMS"]["PHONE"]; 
	$user_res = $CAllMain->ParentUpdate("ga_user", $user_new_info);
	
	//ID_PRICES	
	$result["ID_USER"]				= $USER["ID"];
	$result["ID_COMPANY"]			= $post["PARAMS"]["ID"];		
	$result["FIRST_NAME"]			= $post["PARAMS"]["NAME"];		
	$result["PHONE"]				= $post["PARAMS"]["PHONE"];
	$result["DATE"]					= $post["PARAMS"]["DATE"];
	///$result["ITS_PARTS"]			= $post["PARAMS"]["REPAIR"];	@TODO исправить
	$result["SERVICE_NAME"]			= $post["PARAMS"]["SERVICE_NAME"];		
	$result["COMMENT"]				= $post["PARAMS"]["COMMENT"];
	$res = $CAllMain->ParentAdd("ga_order", $result);
	

	$filelist["ADD_ORDER"] = $res;
}

///список отзывов пользователя
if ($get = $REST->method("get","/reviews/"))
{
	$review = $CAllMain->ParentGetList("ga_rewview", array("SORT"=>"asc"),array("ID_USER"=>$USER["ID"]), array());
	
	foreach ($review as $keyOrder => &$arItemOrder) {
		$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ID"=>$arItemOrder["ID_COMPANY"]), array());
		$company = reset($company);
		$arItemOrder["COMPANY"] = $company;
	}	
	
	$filelist["LIST_REWIEV"] = $review;
}

///запись
if(count($filelist) == 0)
	$filelist["NOT_QUERE"] = "Y";
if ($filelist)
{
	echo json_encode($filelist);
	//echo "<pre>";
	///print_r($filelist);
	//echo "</pre>";
}
?>