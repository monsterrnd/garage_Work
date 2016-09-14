<?
$arResult["NAME_MODULE"] = "";

global $DB;

$MTEdit =  new CAllMain;






$res = "";
foreach ($arParams["FILDS"] as $key => $arItem) 
{
	list($first,$last) = explode(":",$key);
	
	if ($arItem == "false")
		$arItem = "N";
	if ($arItem == "true")
		$arItem = "Y";
	
	$res[$first][$last] = $arItem;
}


foreach ($res as $resKey => $resEl) {
	
	$MTEditEl = $MTEdit->ParentGetList("ga_admin_name_param", array(), array("IS_TABLE"=>$resEl["IS_TABLE"],"FILD"=>$resEl["FILD"]));

	if(!$MTEditEl)
		$MTEdit->ParentAdd("ga_admin_name_param", $resEl);
	else
	{
		$forUpdate = array_shift($MTEditEl);
		$resEl["ID"] =	$forUpdate["ID"];
		$MTEdit->ParentUpdate("ga_admin_name_param", $resEl);
	}
}

ob_start();
/*
?>

<div class="container-fluid" >
	<div class="row" style="margin-top: 0px; margin-bottom: 20px;">
		<div class="col-xs-12">
			<pre>
				<?php// print_r($arParams) ?>
				<?php// print_r($ttt) ?>
				<?php// print_r($res) ?>
			</pre>
		</div>
	</div>
</div
<?
*/
$arResult["HTML"] = ob_get_contents();
ob_end_clean();
?>