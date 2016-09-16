<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Редактировать название таблиц</h1>
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
				<form role="form" id="table_name_edit">
					<?
						global $DB;



						///заголовки таблицы
						$header = array(
							"TABLE"=>"Таблица",
							"NAME_RUS"=>"Название таблицы",
							"HIDDEN"=>"Скрыть таблицу",
						);
		
						

						////Загрузка параметров на форму
						$tablesLoad = array();
						$TablesForEdit= new CAllMain;						
						$tablesLoad = $TablesForEdit->ParentGetList("ga_name_table", array(), array());
						
						////сортируем по ключу
						$tableResLoadSort = array();
						foreach ($tablesLoad as $tablesLoadEL)
						{
							$tableResLoadSort[$tablesLoadEL["TABLE"]] = $tablesLoadEL;			
						}								

						/////список таблиц
						$tablesSQLList = array();
						$DB->Query("SHOW TABLES FROM ".$DB->DBName);
						foreach ($DB->DBprint() as $tableNamesEl)
						{
							$tablesSQLList[]= current($tableNamesEl);
						}
						

						

						
//						echo "<pre>";
//						print_r($tablesSQLList);
//						echo "</pre>";
						
						$table_fild = array();
						foreach ($tablesSQLList as $KeyTableElName => $ElTableElName) 
						{

							foreach ($header as $keyHeader => $ElHeader) 
							{

								switch ($keyHeader)
								{
									case "TABLE":
										$table_fild[$ElTableElName][$keyHeader] = $ElTableElName.CForms::TypeFilds(
											"HIDDEN",
											$ElTableElName.":".$keyHeader,
											$ElTableElName
										);
									break;
									case "NAME_RUS":
										$table_fild[$ElTableElName][$keyHeader] = CForms::TypeFilds(
											"TEXT",
											$ElTableElName.":".$keyHeader,
											(($tableResLoadSort[$ElTableElName][$keyHeader])? $tableResLoadSort[$ElTableElName][$keyHeader]: "" )
										);
									break;
									case "HIDDEN":
										$table_fild[$ElTableElName][$keyHeader] = CForms::TypeFilds(
											"YN",
											$ElTableElName.":".$keyHeader,
											$tableResLoadSort[$ElTableElName][$keyHeader]
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
			<a href="javascript:void(0)"  class="btn btn-success" onclick="ExFormated.getModule('#table_name_edit','table_name_edit','','','','','history.back()');">Сохранить</a>
			<a href="javascript:void(0)"  class="btn btn-default" onclick="ExFormated.getModule('#table_name_edit','table_name_edit','','','','','');">Применить</a>
			<a href="javascript:void(0)"  class="btn btn-default" onclick="history.back()">Отменить</a>
		</div>
		<!-- /.panel-body -->
	</div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

