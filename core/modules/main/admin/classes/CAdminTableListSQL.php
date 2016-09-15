<?
/**
* таблица для работы с базой
*/	
class CAdminTableListSQL 
{
	public $set_header_array = array();
	public $set_header_noarray = false;
	public $set_data_array = array();
	/**
	 * getlist Object 
	*/	
	public $get_list_object;
	public $get_list_object_table;
	
	/**
	 * Button
	*/	
	public $list_button;
	
	/**
	 * 
	*/
	function SetHeader($array)
	{
		if(is_array($array))
			$this->set_header_array = $array;
		//// показать все столбцы задать вместо массива "*";
		elseif($array == "*")
		{
			$this->set_header_noarray = true;
		}
	}
	
	/**
	 * 
	*/
	function buttonRender()
	{
		foreach($this->list_button as $buttonEl):?>
			<a href="<?=$buttonEl["LINK"]?>" class="<?=$buttonEl["CLASS"]?>"><i class="<?=$buttonEl["ICON"]?>"></i> <?=$buttonEl["NAME"]?></a>
		<?endforeach;
			
	}
	
	function AddButton($array)
	{
		$this->list_button = $array;
	}
	
	/**

	*/
	function HeaderSetName()
	{
		if($this->set_header_noarray == true){
			$set_data_array = $this->set_data_array;
			foreach (current($set_data_array) as $name=>$set_data_array_el)
			{
				$this->set_header_array[$name] = $name;
			}
		}
	}
	/**

	*/
	function SetData($object,$table)
	{
		$this->get_list_object = $object;
		$this->get_list_object_table = $table;
		$sort[CRequest::getRequest("by")]= CRequest::getRequest("sort");
		$data = $this->get_list_object->ParentGetList($table, $sort, array(), array("ELEMENT_TO_PAGE"=>30,"PAGE"=>1));
		$this->set_data_array = $data;
	}

	
	/**

	*/
	function Render()
	{
		$this->HeaderSetName();	

	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?$this->buttonRender()?>
			<a href="menu_table_edit.php?TABLE=<?=$this->get_list_object_table?>" class="btn btn-default btn-xl"><i class="fa fa-cog"></i></a>

		</div>
		<div class="panel-body">
			<?
			
			////Загрузка параметров на форму
			$tablesLoad = array();
			$TablesForEdit= new CAllMain;						
			$tablesLoad = $TablesForEdit->ParentGetList("ga_admin_name_param", array(), array("IS_TABLE"=>$this->get_list_object_table));
			////сортируем по ключу
			$tableResLoadSort = array();
			foreach ($tablesLoad as $tablesLoadEL)
			{
				$tableResLoadSort[$tablesLoadEL["FILD"]] = $tablesLoadEL;			
			}
			//echo "<pre>";
			//print_r($tableResLoadSort);
			//echo "</pre>";
			?>
			<div class="table-responsive">

				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>
							</th>
							<?foreach($this->set_header_array as $keyHeadName=>$hederEl):?>
							<th>
								
								
								<?$hederEl = ($tableResLoadSort[$keyHeadName]["NAME"]) ? $tableResLoadSort[$keyHeadName]["NAME"] : $hederEl;?>
								<?$sort =($keyHeadName == CRequest::getRequest("by") && CRequest::getRequest("sort") == "asc") ? "desc": "asc";?>
								<a href="<?=CRequest::GetPageParam(array("by"=>$keyHeadName,"sort"=>$sort))?>"><?=$hederEl?></a>



							</th>
							<?endforeach;?>
						</tr>
					</thead>
					<tbody>
						<?foreach($this->set_data_array as $dataEl):?>
							<tr>
								<td>
									<div class="dropdown">
										<a class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-cog"></i></a>
										<ul class="dropdown-menu dropdown-tasks">
											<li>
												<a href="user_edit.php?ID=<?=$dataEl["ID"]?>"><i class="glyphicon glyphicon-edit"></i> Изменить</a>
											</li>
											<li>
												<a href="#"><i class="glyphicon glyphicon-remove"></i> Удалить</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-copy"></i> Копировать</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-circle-thin"></i> Деактивировать</a>
											</li> 
										</ul>
									</div>
								</td>
								<?foreach($this->set_header_array as $nameRows=>$hederEl):?>
									<td><?=$dataEl[$nameRows]?></td>
								<?endforeach;?>									
							</tr>
						<?endforeach;?>                                         
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer">
			<?$this->get_list_object->PaginationRender();?>
		</div>
	</div>
						

	<?
	}
}