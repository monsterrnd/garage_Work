<?
$arResult["NAME_MODULE"] = "Создание/редактирование таблицы";


foreach ($arParams["FILDS"] as &$fff)
{
	if ($fff == "false")
		$fff = "N";
	if ($fff == "true")
		$fff = "Y";	
}

$thiss = new CAllMain;

if (!empty($arParams["FILDS"]["ID"]))
	$MTEditEl = $thiss->ParentGetList($arParams["FILDS"]["TABLE"], array(), array("ID"=>$arParams["FILDS"]["ID"]));	

if(!$MTEditEl)
{
	$res = $thiss->ParentAdd($arParams["FILDS"]["TABLE"], $arParams["FILDS"]);
}
else
{
	$forUpdate = array_shift($MTEditEl);
	$arParams["FILDS"]["ID"] =	$forUpdate["ID"];
	$res = $thiss->ParentUpdate($arParams["FILDS"]["TABLE"], $arParams["FILDS"]);
}

if (is_array($res["ERROR"]))
	$arResult["ERROR"] = $res["ERROR"];	

ob_start();
/*
?>

<div class="container-fluid" >
	<div class="row" style="margin-top: 0px; margin-bottom: 20px;">
		<div class="col-xs-12">
			<pre>
				<?php print_r($arParams["FILDS"]) ?>
				<?php print_r($arResult) ?>
			</pre>
		</div>
	</div>
</div
<?
 * 
 */
$arResult["HTML"] = ob_get_contents();
ob_end_clean();
?>