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
	public $count_element_pagination = 30;		
	public $this_page_pagination = 1;		
	public $count_array_element_pagination = "";
	public $max_button_pagination = 3;
			


	/**
	 * 
	*/
	
	function SetPagination()
	{
		
		$pagen = CRequest::getRequest("PAGEN");
		if ($pagen && $pagen <= count($this->set_data_array) && $pagen > 0)
			$this->this_page_pagination = $pagen;
	
	}
	/**
	 * 
	*/
	function Sort($array)
	{

		$sort = CRequest::getRequest("sort");
		
		if ($sort == "desc")
		{
			//DESC
			usort($array, function($a, $b){
				return ($a[CRequest::getRequest("by")] < $b[CRequest::getRequest("by")]);
			});	
		}
		
		if ($sort == "asc")
		{
			//ASC
			usort($array, function($a, $b){
				
				return ($a[CRequest::getRequest("by")] > $b[CRequest::getRequest("by")]);
			});	
		}
		return $array;
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
			foreach (current(current($this->set_data_array)) as $name=>$set_data_array_el)
			{
				
				$this->set_header_array[$name] = $name;
			}
		}
	}
	/**

	*/
	function SetData($array)
	{

		$array = $this->Sort($array);
		$this->count_array_element_pagination = count($array);
		$this->set_data_array = array_chunk($array, $this->count_element_pagination);
	}
	/**
	 * 
	*/
	function RenderPagination()
	{
		$this->count_element_pagination = ($this->count_element_pagination > $this->count_array_element_pagination) ? $this->count_array_element_pagination : $this->count_element_pagination;
		
		$pagination  = array();
		$pagination["PAGE"]				= $this->this_page_pagination;
		$pagination["PAGES"]			= count($this->set_data_array);
		$pagination["ELEMENTS"]			= $this->count_array_element_pagination;
		$pagination["MAX_BUTTON"]		= $this->max_button_pagination;
		$pagination["COUNTS_ELEMENT"]	= $this->count_element_pagination;
		//$pagination["NEXT_PAGE"]		= $this->this_page_pagination + 1;
		//$pagination["PREV_PAGE"]		= $this->this_page_pagination - 1;
		
	?>	
			<nav aria-label="Page navigation" class="clearfix">
			<?=($pagination["PAGE"] * $pagination["COUNTS_ELEMENT"]) - $pagination["COUNTS_ELEMENT"] + 1?> - <?=$pagination["PAGE"] * $pagination["COUNTS_ELEMENT"]?> из <?=$pagination["ELEMENTS"]?>
				<ul class="pagination pagination-sm navbar-right">
					<!--li>
					  <a href="?PAGEN=<?=$pagination["PREV_PAGE"]?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li-->
					
						<? for ($el=1; $el <= $pagination["MAX_BUTTON"]; $el++):?>
							<?if(($lowwer = $pagination["PAGE"]-$pagination["MAX_BUTTON"]+$el-1) > 0):?>
								<li><a href="?PAGEN=<?=$lowwer?>"><?=$lowwer?></a></li>
							<?endif?>
						<?endfor;?>
								
						<li class="active"><a href="?PAGEN=<?=$pagination["PAGE"]?>"><?=$pagination["PAGE"]?></a></li>
						
						<? for ($el=1; $el <= $pagination["MAX_BUTTON"]; $el++):?>
							<?if(($upper = $pagination["PAGE"]+$el) < $pagination["PAGES"]):?>
								<li><a href="?PAGEN=<?=$upper?>"><?=$upper?></a></li>
							<?endif?>
						<?endfor;?>
								
						<?if($pagination["PAGE"] != $pagination["PAGES"]):?>
							<li><span>...</span></li>
							<li><a  href="?PAGEN=<?=$pagination["PAGES"]?>"><?=$pagination["PAGES"]?></a></li>
						<?endif?>
					<!--li>
					  <a href="?PAGEN=<?=$pagination["NEXT_PAGE"]?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li-->
				</ul>
			</nav>		
	
	<?
	}	
	/**

	*/
	function Render()
	{
		$this->Validation();	
		$this->SetPagination()

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
								<th>
								</th>
								<?foreach($this->set_header_array as $keyHeadName=>$hederEl):?>
								<th>
									<a href="?by=<?=$keyHeadName?>&sort=<?=($keyHeadName == CRequest::getRequest("by") && CRequest::getRequest("sort") == "asc") ? "desc": "asc";?>"><?=$hederEl?></a>
								</th>
								<?endforeach;?>
							</tr>
						</thead>
						<tbody>
							<?foreach($this->set_data_array[$this->this_page_pagination - 1] as $dataEl):?>
								<tr>
									<td>
										<button type="button" class="btn btn-default"><i class="fa fa-cog"></i></button>
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
				<?$this->RenderPagination()?>
			</div>
		</div>


	<?
		echo "<pre>";
		echo "</pre>";
	}
}