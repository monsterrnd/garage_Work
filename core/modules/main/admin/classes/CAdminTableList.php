<?
/**
* таблица для работы с базой
*/	
class CAdminTableList 
{
	public $set_header_array = array();
	public $set_header_noarray = false;
	public $set_data_array = array();
	/**
	 * pagination
	*/	
	public $count_element_pagination = 5;		

			


	/**
	 * 
	*/
	
	function SetPagination()
	{
		
		$pagen = CRequest::getRequest("PAGEN");
	
	}
	/**
	 * 
	*/
	function Sort()
	{

		$sort = CRequest::getRequest("sort");
		
		if ($sort == "desc")
		{
			//DESC
			usort($this->set_data_array, function($a, $b){
				return ($a[CRequest::getRequest("by")] < $b[CRequest::getRequest("by")]);
			});	
		}
		
		if ($sort == "asc")
		{
			//ASC
			usort($this->set_data_array, function($a, $b){
				
				return ($a[CRequest::getRequest("by")] > $b[CRequest::getRequest("by")]);
			});	
		}
	}
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

	*/
	function Validation()
	{
		if($this->set_header_noarray == true){
			foreach (current($this->set_data_array) as $name=>$set_data_array_el)
			{
				
				$this->set_header_array[$name] = $name;
			}
		}
	}
	/**

	*/
	function SetData($array)
	{
		//$this->PaginationSet();
		$this->set_data_array = array_chunk($array , $this->count_element_pagination);
	}
	/**
	 * 
	*/
	function RenderPagination()
	{
		$pagination  = array();
		$pagination["PAGE"]		= CRequest::getRequest("PAGEN");
		$pagination["PAGES"]	= count($this->set_data_array);
		echo "<pre>";
		print_r($pagination);
		echo "</pre>";
		
	?>	
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
	
	<?
	}	
	/**

	*/
	function Render()
	{
		//$this->Init();
		$this->Validation();
		$this->Sort();	
		

	?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<button type="button" class="btn btn-success btn-xl"><i class="fa fa-plus"></i> Добавить</button>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<?foreach($this->set_header_array as $keyHeadName=>$hederEl):?>
								<th>
									<a href="?by=<?=$keyHeadName?>&sort=<?=($keyHeadName == CRequest::getRequest("by") && CRequest::getRequest("sort") == "asc") ? "desc": "asc";?>"><?=$hederEl?></a>
								</th>
								<?endforeach;?>
							</tr>
						</thead>
						<tbody>
							<?foreach($this->set_data_array as $dataEl):?>
								<tr>
									<?foreach($this->set_header_array as $nameRows=>$hederEl):?>
										<th><?=$dataEl[$nameRows]?></th>
									<?endforeach;?>									
								</tr>
							<?endforeach;?>                                         
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel-footer">
				<?$this->RenderPagination()?>
			</div>
		</div>


	<?
		echo "<pre>";
		echo "</pre>";
	}
}