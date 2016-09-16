<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Редактирование</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
	<div class="reeee">

	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
					<div class="well well-lg">
						<form role="form" id="table_edit">
							<?
								global $DB;

								
								$users = new CAllMain;
								$data = $users->ParentGetById(CRequest::getRequest("TABLE"),CRequest::getRequest("ID"));
								
								
										
								$strTableElName = $DB->GetTableFields(CRequest::getRequest("TABLE"));		

								
								
								////Загрузка параметров на форму
								$tablesLoad = array();
								$TablesForEdit= new CAllMain;						
								$tablesLoad = $TablesForEdit->ParentGetList("ga_admin_name_param", array(), array("IS_TABLE"=>CRequest::getRequest("TABLE")));
								////сортируем по ключу
								$tableResLoadSort = array();
								foreach ($tablesLoad as $tablesLoadEL)
								{
									$tableResLoadSort[$tablesLoadEL["FILD"]] = $tablesLoadEL;			
								}
								
								//echo "<pre>";
								//print_r($tableResLoadSort);
								//echo "</pre>";	
								echo CForms::TypeFilds("HIDDEN",
									"TABLE",
									CRequest::getRequest("TABLE")
								);
								foreach ($strTableElName as $key => $arItem)
								{

										?>
										<?$hederName = ($tableResLoadSort[$key]["NAME"]) ? $tableResLoadSort[$key]["NAME"] : $key;?>
										<?//if($tableResLoadSort[$key]["TYPE"] != "HIDDEN"):?>
											<div class="form-group ">
												<div class="row">
													<div class="col-md-6 text-right">
														<span><?=$hederName?>:</span>
													</div>
													<div class="col-md-6">


														<?=CForms::TypeFilds($tableResLoadSort[$key]["TYPE"],
															$key,
															$data[$key],
															($key == "ID")? "Y" : "",
															$tableResLoadSort[$key]["REQ"],
															$hederName
														)?>


													</div>
												</div>

											</div>
										<?//endif;?>

										<?
										//echo "<pre>";
										//print_r($key);
										//echo "</pre>";
								}


							?>				
						</form>
					</div>
				

		</div>
		<div class="panel-footer">
			<a href="javascript:void(0)"  class="btn btn-success" onclick="ExFormated.getModule('#table_edit','table_edit','','','',true,'history.back()');">Отправить</a>
			<?
			//@TODO пока убрал вызывает ошибку 
			//<a href="javascript:void(0)"  class="btn btn-default" onclick="ExFormated.getModule('#table_edit','table_edit','','','',true);">Применить</a>
			?>
			<a href="javascript:void(0)"  class="btn btn-default" onclick="history.back()">Отменить</a>
		</div>
		<!-- /.panel-body -->
	</div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

