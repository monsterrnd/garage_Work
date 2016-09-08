<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Пользователи</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<button type="button" class="btn btn-success btn-xl"><i class="fa fa-plus"></i> Добавить</button>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>Активность</th>
							<th>Имя</th>
							<th>Почта</th>
							<th>Авто по умолчанию</th>
							<th>Aватар</th>
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

					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer">
			<nav aria-label="Page navigation" class="clearfix">
			  <ul class="pagination pagination-sm navbar-right">
				<li>
				  <a href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				  </a>
				</li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li>
				  <a href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				  </a>
				</li>
			  </ul>
			</nav>
        </div>
	</div>
	
	
	<!-- /.table-responsive -->
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

