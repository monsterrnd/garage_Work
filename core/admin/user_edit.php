<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Добавить пользователя</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
	

	<div class="panel panel-default">
		<div class="panel-heading">
			
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Основные</a>
				</li>
				<li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Profile</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				
				<div class="tab-pane fade active in" id="home">
					<h4>Основные</h4>
					<div class="well well-lg">
						<form role="form">
							<?
								global $DB;

								
								$users = new CAllMain;
								$data = $users->ParentGetById("ga_user",CRequest::getRequest("ID"));
								
								
										
								$strTableElName = $DB->GetTableFields("ga_user");		
										//echo "<pre>";
										//print_r($strTableElName);
										//echo "</pre>";
								foreach ($strTableElName as $key => $arItem)
								{

										?>

										<div class="form-group">
											<div class="row">
												<div class="col-md-6 text-right">
													<span><?=$key?>:</span>
												</div>
												<div class="col-md-6">
													<input type="text" class="form-control" <?=($key == "ID")? 'disabled="disabled"' : ''?> id="<?=$key?>_input" value="<?=$data[$key]?>">	
												</div>
											</div>

										</div>

										<?
										//echo "<pre>";
										//print_r($key);
										//echo "</pre>";
								}


							?>				
						</form>
					</div>
				</div>
				
				<div class="tab-pane fade" id="profile">
					<h4>Profile Tab</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				
			</div>
		</div>
		<div class="panel-footer">
			<button type="button" class="btn btn-success">Сохранить</button>
			<button type="button" class="btn btn-default">Применить</button>
			<button type="button" class="btn btn-default">Отменить</button>
		</div>
		<!-- /.panel-body -->
	</div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

