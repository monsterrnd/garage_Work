<?php

$start_time = microtime();
$start_array = explode(" ",$start_time);
$start_time = $start_array[1] + $start_array[0];



$root = "/core";
$images = "/images";
$first_load_db = false;

$site_id="/";
$template_admin_path = $root."/admin/templates";



define("ROOT", $root);
define("SITE_ID", $site_id);
define("TEMPLATE_ADMIN", $template_admin_path);












require_once($_SERVER["DOCUMENT_ROOT"].ROOT."/modules/main/database.php");

function __autoload($class_name) {
    require_once $_SERVER["DOCUMENT_ROOT"].ROOT."/modules/main/classes/" . $class_name . '.php';
}

//global $DB;
//global $APPLICATION;
//global $USER;
//global $MESSAGE;


$DB = new CDatabase;
$DB->Connect("127.0.0.1:31006", "mysql", "garage", "root", "");

if ($first_load_db != false)
	CInitTables::NewTableForPlatform();

$APPLICATION	=	new CAllMain;
$APPLICATION->SessionInit();

//$CSERVICE		=	new CService;
//$CUSER		=	new CUser;
//$CCOMPANY		=	new CCompany;
//$CREVIEW		=	new CReview;
//$CPRICES		=	new CPrices;
//$CSPECIFICAL	=	new CSpecifical;
//$CORDER		=	new COrder;
//$CUSERCAR		=	new CUserCar;
//$CAR			=	new CCar;
//$REST			=	new CRestMethod;
//$MESSAGE = new CMessage;


//echo "<pre>";

//print_r($USER->Get());
//print_r($USER->Add());
//print_r($USER->Update(
//	array(
//		"ID"=>21,
//      "ACTIVE" => "N",
//      "EMAIL" => "a@r2a3.ru",
//	)	
//));
//$USER->Delete(25);

//print_r($CSERVICE->Get(9));
//print_r($CSERVICE->Add(
//	array(
//        "ACTIVE" => "Y",
//        "ID_ALLSERVICES" => 55,
//        "NAME" => "ntcn"
//	)
//));
//$CSERVICE->Delete(111);





//$file = file_get_contents(__DIR__ . "/1.txt", true);
//$sss = json_decode($file);
//foreach($sss as $e_sss)
//{
//	echo $CSERVICE->AddService((array)$e_sss);
//}

//echo "</pre>";

/*?>
<select>
	<?foreach ($CSERVICE->Get(0) as $ellll):?>
		
		<option><?=$ellll["NAME"];?></option>
		<?foreach ($CSERVICE->Get($ellll["ID"]) as $ellll2):?>
			<option><?="----".$ellll2["NAME"];?></option>
			<?foreach ($CSERVICE->Get($ellll2["ID"]) as $ellll3):?>
				<option><?="--------".$ellll3["NAME"];?></option>
			<?endforeach;?>
		<?endforeach;?>

	<?endforeach;?>
</select>
 * 
 */
//echo "<pre>";
//print_r($CAR->GetByIdModification(11));







