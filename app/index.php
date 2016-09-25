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
	
	foreach ($res as $key => $arItem) {
		$result[$key]["ID"] = $arItem["ID"];
		$result[$key]["NAME"] = $arItem["NAME"];
		
	}	
	if (count($result))
		$filelist["LIST"] = $result;
}

if ($get = $REST->method("get","/services/{%}/"))
{
	$user = "asdfasdfasdf";
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
			$user = $CAllMain->ParentGetList("ga_user", array("SORT"=>"asc"), array("SESSION"=>$user), array());
			if (count($user))
			{
				$user = reset($user);
				
				////Подгружаем авто пользователя
				$auto = $CAllMain->ParentGetList("ga_user_car", array("SORT"=>"asc"), array("ID_USER"=>$user["ID"],"ID"=>$user["MAIN_AUTO"]), array());
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
									$result[$companyKey]["ID"]				= $companyItem["ID"];
									$result[$companyKey]["PRICE"]			= $priceSortId[$companyItem["ID"]]["PRICE"];
									$result[$companyKey]["COMMENT"]			= $priceSortId[$companyItem["ID"]]["COMMENT"];
									$result[$companyKey]["NAME"]			= $companyItem["NAME"];
									$result[$companyKey]["LOGO"]			= $companyItem["LOGO"];
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
	$user = "asdfasdfasdf";
	$result = array();
	
	////проверка существует услуга в бд если существует берем эту услугу для выборки
	$exist_service = $CAllMain->ParentGetList("ga_allservices", array("SORT"=>"asc"),array("ID"=>$get["REQUEST"][1]), array());
	if (count($exist_service))
	{
		$exist_service = reset($exist_service);

		////Подгружаем данные пользователя
		$user = $CAllMain->ParentGetList("ga_user", array("SORT"=>"asc"), array("SESSION"=>$user), array());
		if (count($user))
		{
			$user = reset($user);

			////Подгружаем авто пользователя
			$auto = $CAllMain->ParentGetList("ga_user_car", array("SORT"=>"asc"), array("ID_USER"=>$user["ID"],"ID"=>$user["MAIN_AUTO"]), array());
			if (count($auto))
			{
				$auto = reset($auto);
				
				///Запрос к компаниям по ID полученого из $get["REQUEST"][1];
				$company = $CAllMain->ParentGetList("ga_company", array("SORT"=>"asc"), array("ACTIVE"=>"Y","ID"=>$get["REQUEST"][2]), array());
				
				if (count($company))
				{
					$company = reset($company);
					$price = $CAllMain->ParentGetList("ga_prices", array("SORT"=>"asc"), array("ID_CAR_MARK"=>$auto["ID_CAR_MARK"],"ID_ALLSERVICES"=>$exist_service["ID"],"ID_COMPANY"=>$company["ID"]), array());
					if (count($price))
					{
						$price = reset($price);
						
						$result["ID"]				= $company["ID"];
						$result["PRICE"]			= $price["PRICE"];
						$result["COMMENT"]			= $price["COMMENT"];
						$result["NAME"]				= $company["NAME"];
						$result["LOGO"]				= $company["LOGO"];
						$result["ADDRESS"]			= $company["ADDRESS"];
						$result["ADDRESS_MAP"]		= $company["ADDRESS_MAP"];
						$result["DESCRIPTION"]		= $company["DESCRIPTION"];	
						
						$filelist["DETAIL"] = $result;
					}
				}
			}

		}
	}
	

	
}







if ($get = $REST->method("get","/auto/"))
{
	$result = array();
	$res = $CAllMain->ParentGetList("car_mark", array(), array(), array());
	foreach ($res as $key => $arItem) {
		$result[$key]["ID"] = $arItem["id_car_mark"];
		$result[$key]["NAME"] = $arItem["name"];
	}
	
	$filelist[] = $result;
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