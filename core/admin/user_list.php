<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Пользователи</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
<?
/*
	///запрос к пользователям
	$users = new CUser;
	$uers_list = $users->GetList();
	
	
	$user_list = new CAdminTableList;

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
	$user_list->SetHeader($header);
	/// записываем массив из результата в таблицу 
	$user_list->SetData($uers_list);
	// выводим таблицу
	$user_list->Render();
*/	
	
	///запрос к пользователям
	$users = new CCar;
	$uers_list = $users->GetListModification();
	
	
	$user_list = new CAdminTableList;

	//// формеруем названия для шапки
	$header = "*";
	$user_list->SetHeader($header);
	/// записываем массив из результата в таблицу 
	$user_list->SetData($uers_list);
	// выводим таблицу
	$user_list->Render();	
	
	

?>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

