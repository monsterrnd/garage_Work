<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Рабочий стол</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-comment fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge">13</div>
							<div>Отзывов</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Перейти</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-users fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge">26</div>
							<div>Компаний</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Перейти</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-user fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge">12</div>
							<div>Пользователей</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Перейти</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-files-o fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge">124</div>
							<div>Заявки</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">Перейти</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> Статистика регистрации пользователей и компаний

				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div id="morris-area-chart"></div>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> Статистика заявок
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Дата/время</th>
											<th>Тип услуги</th>
											<th>Авто</th>
											<th>Компания</th>
											<th>Стоимость</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>12.09.2016 23:00</td>
											<td>Замена масла</td>
											<td>BMW X5 2016</td>
											<td>VirbacAuto</td>
											<td>1300Р</td>
										</tr>                                                
										<tr>
											<td>2</td>
											<td>12.09.2016 22:00</td>
											<td>Замена масла</td>
											<td>BMW X3 2012</td>
											<td>VirbacAuto</td>
											<td>1300Р</td>
										</tr>                                                
										<tr>
											<td>3</td>
											<td>12.09.2016 21:00</td>
											<td>Замена масла</td>
											<td>BMW X6 2016</td>
											<td>VirbacAuto</td>
											<td>1500Р</td>
										</tr>                                                
										<tr>
											<td>4</td>
											<td>12.09.2016 20:00</td>
											<td>Замена масла</td>
											<td>BMW X1 2016</td>
											<td>VirbacAuto</td>
											<td>1300Р</td>
										</tr>                                                
										<tr>
											<td>5</td>
											<td>12.09.2016 19:45</td>
											<td>Замена масла</td>
											<td>BMW X5 2016</td>
											<td>VirbacAuto</td>
											<td>1300Р</td>
										</tr>                                                
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>

					</div>
					<!-- /.row -->
				</div>
				<!-- /.panel-body -->
			</div>
		</div>
		<!-- /.col-lg-8 -->
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bell fa-fw"></i> История событий
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="list-group">
						<a href="#" class="list-group-item">
							<i class="fa fa-comment fa-fw"></i> Новый отзыв
							<span class="pull-right text-muted small"><em>04.08.2016 23:00</em>
							</span>
						</a>
						<a href="#" class="list-group-item">
							<i class="fa fa-user fa-fw"></i> Новый пользователь
							<span class="pull-right text-muted small"><em>04.08.2016 23:13</em>
							</span>
						</a>
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:34</em>
							</span>
						</a>                                
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:35</em>
							</span>
						</a>								
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:55</em>
							</span>
						</a>								
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:55</em>
							</span>
						</a>
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:34</em>
							</span>
						</a>                                
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:35</em>
							</span>
						</a>								
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:55</em>
							</span>
						</a>
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:34</em>
							</span>
						</a>                                
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:35</em>
							</span>
						</a>								
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:55</em>
							</span>
						</a>
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:34</em>
							</span>
						</a>                                
						<a href="#" class="list-group-item">
							<i class="fa fa-files-o fa-fw"></i> Новая заявка
							<span class="pull-right text-muted small"><em>04.08.2016 23:35</em>
							</span>
						</a>								

					</div>
					<!-- /.list-group -->
					<a href="#" class="btn btn-default btn-block">Вся история</a>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->

			<!-- /.panel -->

			<!-- /.panel .chat-panel -->
		</div>
		<!-- /.col-lg-4 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

