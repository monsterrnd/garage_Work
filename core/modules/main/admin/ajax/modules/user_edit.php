<?
$arResult["NAME_MODULE"] = "Создание/редактирование пользователя";


foreach ($arParams["FILDS"] as &$fff)
{
	if ($fff == "false")
		$fff = "N";
	if ($fff == "true")
		$fff = "Y";	
}


$cuser = new CUser;
$res = $cuser->Add($arParams["FILDS"]);
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