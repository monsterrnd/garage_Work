<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Таблица</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
	
<?
	

	$CAllMain = new CAllMain;		
	$tableList = new CAdminTableListSQL;

	//// формеруем названия для шапки
	
	$tableList->SetHeader("*");
	
	
	///добавляем кнопки 
	$button =array(
		array(
			"NAME"=>"Добавить",
			"TYPE"=>"",
			"LINK"=>"table_edit.php?TABLE=".CRequest::getRequest("TABLE"),
			"CLASS"=>"btn btn-success btn-xl",
			"ICON"=>"fa fa-plus"
		),		
	);
	$tableList->AddButton($button);
	///запрос к пользователям
	$tableList->SetData($CAllMain,CRequest::getRequest("TABLE"));
	
	// выводим таблицу
	$tableList->Render();	
?>
	
	



</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

