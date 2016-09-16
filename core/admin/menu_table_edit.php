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
							"IS_TABLE"=>"",
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
							"TEXT"=>"Поле",
							"SELECT"=>"Список",
							"TEXTAREA"=>"Текст",
							"YN"=>"Вкл/выкл",
							"HIDDEN"=>"Скрытое ",
						);


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

						/////список таблиц
						$tablesSQLList = array();
						$DB->Query("SHOW TABLES FROM ".$DB->DBName);
						foreach ($DB->DBprint() as $tableNamesEl)
						{
							$tablesSQLList[]= current($tableNamesEl);
						}
						
						$tablesList = "";
						$tablesList .= "<option></option>";
						foreach ($tablesSQLList as $tablesSQLListEl)
						{
							$tablesList .= "<option value=\"$tablesSQLListEl\">".$tablesSQLListEl."</option>";
						}

						

						
						$table_fild = array();
						foreach ($strTableElName as $KeyTableElName => $ElTableElName) 
						{

							foreach ($header as $keyHeader => $ElHeader) 
							{
								
								
								switch ($keyHeader)
								{
									case "IS_TABLE":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"HIDDEN",
											$KeyTableElName.":".$keyHeader,
											CRequest::getRequest("TABLE")
										);
									break;
									case "FILD":
										$table_fild[$KeyTableElName][$keyHeader] = $KeyTableElName.CForms::TypeFilds(
											"HIDDEN",
											$KeyTableElName.":".$keyHeader,
											$KeyTableElName
										);
									break;
									case "NAME":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"TEXT",
											$KeyTableElName.":".$keyHeader,
											(($tableResLoadSort[$KeyTableElName][$keyHeader])? $tableResLoadSort[$KeyTableElName][$keyHeader]: "" )
										);										
									break;
									case "TYPE":
										$typesList = "";	
										foreach ($typs as $typsKey=>$typsEl)
										{
											$typesList .= "<option "
											. "".(($tableResLoadSort[$KeyTableElName][$keyHeader] == $typsKey)? " selected ": "" ).""
											. "value=\"$typsKey\">".$typsEl."</option>";
										}
										
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"SELECT",
											$KeyTableElName.":".$keyHeader,
											$typesList
										);		
										
									break;
									case "TO_TABLE":
										$tablesList = "";
										$tablesList .= "<option></option>";
										foreach ($tablesSQLList as $tablesSQLListEl)
										{
											$tablesList .= "<option "
											. "".(($tableResLoadSort[$KeyTableElName][$keyHeader] == $tablesSQLListEl)? " selected ": "" ).""
											. "value=\"$tablesSQLListEl\">".$tablesSQLListEl."</option>";
										}
										
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"SELECT",
											$KeyTableElName.":".$keyHeader,
											$tablesList
										);			
									break;
									case "REQ":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"YN",
											$KeyTableElName.":".$keyHeader,
											$tableResLoadSort[$KeyTableElName][$keyHeader]
										);										
									break;
									case "HIDDEN":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"YN",
											$KeyTableElName.":".$keyHeader,
											$tableResLoadSort[$KeyTableElName][$keyHeader]
										);	
									break;
									case "INDEX":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"YN",
											$KeyTableElName.":".$keyHeader,
											$tableResLoadSort[$KeyTableElName][$keyHeader]
										);	
									break;
									case "NAME_FILD":
										$table_fild[$KeyTableElName][$keyHeader] = CForms::TypeFilds(
											"YN",
											$KeyTableElName.":".$keyHeader,
											$tableResLoadSort[$KeyTableElName][$keyHeader]
										);	
									break;
								}										
							}
						}
						
						

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
			<a href="javascript:void(0)"  class="btn btn-success" onclick="ExFormated.getModule('#menu_table_edit','menu_table_edit','','','','','history.back()');">Сохранить</a>
			<a href="javascript:void(0)"  class="btn btn-default" onclick="ExFormated.getModule('#menu_table_edit','menu_table_edit','','','','','');">Применить</a>
			<a href="javascript:void(0)"  class="btn btn-default" onclick="history.back()">Отменить</a>
		</div>
		<!-- /.panel-body -->
	</div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

