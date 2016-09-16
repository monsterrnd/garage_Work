<?
$arResult["NAME_MODULE"] = "Удаление таблицы";

$thiss = new CAllMain;

$res = $thiss->ParentDelete($arParams["FILDS"]["TABLE"], $arParams["FILDS"]["ID"]);


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