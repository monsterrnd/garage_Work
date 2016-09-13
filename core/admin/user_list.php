<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Пользователи</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
	
<?
	

	$users = new CAllMain;		
	$tableList = new CAdminTableListSQL;

	//// формеруем названия для шапки
	
	$header = array(
		"ID"=>"ID",
		"ACTIVE"=>"Активность",
		"PHONE"=>"Телефон",
		"FIRST_NAME"=>"Имя",
		"EMAIL"=>"Почта",
		"MAIN_AUTO"=>"Авто по умолчанию",
		"AVATAR"=>"Путь к аватарке",
	);
	$tableList->SetHeader($header);
	
	
	///добавляем кнопки 
	$button =array(
		array(
			"NAME"=>"Добавить",
			"TYPE"=>"",
			"LINK"=>"user_edit.php",
			"CLASS"=>"btn btn-success btn-xl",
			"ICON"=>"fa fa-plus"
		),	
		array(
			"NAME"=>"ИНФО",
			"TYPE"=>"",
			"LINK"=>"",
			"CLASS"=>"btn btn-success btn-xl",
			"ICON"=>""
		),	
	);
	$tableList->AddButton($button);
	///запрос к пользователям
	$tableList->SetData($users,"ga_user");
	
	// выводим таблицу
	$tableList->Render();	
?>
	
	



</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

