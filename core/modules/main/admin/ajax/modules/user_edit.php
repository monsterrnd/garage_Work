<?
$arResult["NAME_MODULE"] = "Создание/редактирование пользователя";





$cuser = new CUser;
$res = $cuser->Add($arParams["FILDS"]);;
$arResult["DONE"] = $res;
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