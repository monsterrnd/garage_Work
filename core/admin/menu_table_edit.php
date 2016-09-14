<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Редактировать пункты меню</h1>
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
				<form role="form" id="menu_table_edit">
					<?
						global $DB;


		
						
						$strTableElName = $DB->GetTableFields(CRequest::getRequest("TABLE"));	


						///заголовки таблицы
						$header = array(
							"FILD"=>"Поле",
							"NAME"=>"Имя",
							"TYPE"=>"Тип поля",
							"TO_TABLE"=>"Привязано к таблице",
							"REQ"=>"Объезательное для заполнения",
							"HIDDEN"=>"Скрыть поле",
							"INDEX"=>"Является индексным",
							"NAME_FILD"=>"Является Названием",
						);

						
						
						//////список типов полей
						$typs = array(
							"INPUT"=>"Поле",
							"LIST"=>"Список",
							"TEXTAREA"=>"Текст",
						);

						$typesList = "";	
						foreach ($typs as $typsEl)
						{
							$typesList .= "<option>".$typsEl."</option>";
						}
						$typesList = "<select class=\"form-control\">".$typesList."</select>";

						

						/////список таблиц
						$tablesSQLList = array();
						$DB->Query("SHOW TABLES FROM ".$DB->DBName);
						foreach ($DB->DBprint() as $tableNamesEl)
						{
							$tablesSQLList[]= current($tableNamesEl);
						}
						$tablesList = "";
						$tablesList .= "<option>НЕТ</option>";
						foreach ($tablesSQLList as $tablesSQLListEl)
						{
							$tablesList .= "<option>".$tablesSQLListEl."</option>";
						}
						$tablesList = "<select class=\"form-control\">".$tablesList."</select>";
						
						
						
						$table_fild = array();
						foreach ($strTableElName as $KeyTableElName => $ElTableElName) 
						{
							foreach ($header as $keyHeader => $ElHeader) 
							{

								switch ($keyHeader)
								{
									case "FILD":
										$table_fild[$KeyTableElName][$keyHeader] = $KeyTableElName;
									break;
									case "NAME":
										$table_fild[$KeyTableElName][$keyHeader] = "<input c-data-needed=\"0\" c-data-name=\"\" name=\"".$KeyTableElName."[".$keyHeader."]\" size=\"30\" class=\"form-control\" type=\"text\">";
									break;
									case "TYPE":
										$table_fild[$KeyTableElName][$keyHeader] = $typesList;
									break;
									case "TO_TABLE":
										$table_fild[$KeyTableElName][$keyHeader] = $tablesList;
									break;
									case "REQ":
										$table_fild[$KeyTableElName][$keyHeader] = "<input c-data-needed=\"0\" c-data-name=\"\" name=\"".$KeyTableElName."[".$keyHeader."]\" type=\"checkbox\">";
									break;
									case "HIDDEN":
										$table_fild[$KeyTableElName][$keyHeader] = "<input c-data-needed=\"0\" c-data-name=\"\" name=\"".$KeyTableElName."[".$keyHeader."]\" type=\"checkbox\">";
									break;
									case "INDEX":
										$table_fild[$KeyTableElName][$keyHeader] = "<input c-data-needed=\"0\" c-data-name=\"\" name=\"".$KeyTableElName."[".$keyHeader."]\" type=\"checkbox\">";
									break;
									case "NAME_FILD":
										$table_fild[$KeyTableElName][$keyHeader] = "<input c-data-needed=\"0\" c-data-name=\"\" name=\"".$KeyTableElName."[".$keyHeader."]\" type=\"checkbox\">";
									break;
								}										
							}
						}
						


						echo "<pre>";
						//print_r($tablesSQLList);
						echo "</pre>";
						/*
						foreach ($strTableElName as $key => $arItem)
						{

								?>

								<div class="form-group ">
									<div class="row">
										<div class="col-md-6 text-right">
											<span><?=$key?>:</span>
										</div>
										<div class="col-md-6">
											<input type="text" c-data-needed="1" c-data-name="Ваше <?=$key?>" name="<?=$key?>" class="form-control " <?=($key == "ID")? 'disabled="disabled"' : ''?> id="<?=$key?>_input" value="<?=$data[$key]?>">	
										</div>
									</div>

								</div>

								<?
								//echo "<pre>";
								//print_r($key);
								//echo "</pre>";
						}
						*/

					?>

					<div class="table-responsive">

						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<?foreach($header as $keyHeadName=>$hederEl):?>
									<th>
										<?=$hederEl?>
									</th>
									<?endforeach;?>
								</tr>
							</thead>
							<tbody>
								<?foreach($table_fild as $ElTable_fild):?>
									<tr>
										<?foreach($header as $keyHeadName=>$hederEl):?>
											<td><?=$ElTable_fild[$keyHeadName]?></td>
										<?endforeach;?>									
									</tr>
								<?endforeach;?>                                         
							</tbody>
						</table>
					</div>	

				</form>
			</div>
				
				
		
		</div>
		<div class="panel-footer">
			<a href="javascript:void(0)"  class="btn btn-success" onclick="ExFormated.getModule('#user_edit','user_edit','','','.reeee',true);">Отправить</a>
			<button type="button" class="btn btn-default">Применить</button>
			<button type="button" class="btn btn-default">Отменить</button>
		</div>
		<!-- /.panel-body -->
	</div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

