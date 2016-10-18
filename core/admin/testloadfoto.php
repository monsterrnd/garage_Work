<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Загрузка фото</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>



<div class="col-lg-12">
	
	<form action=""  enctype="multipart/form-data" method="POST">
		<input type="file" name="file" />
		<br>
		<br>
		<input type="submit" />
	</form>

<?php

/////////////////////////////////////////////////////////////////////////////
if (intval($_FILES["file"]) )
{
	$CFoto = new CFoto;
	$pathFoto = "/media";
	if($CFoto->AddPhotoFile($pathFoto,$_FILES["file"],$newpath))
	{
		$array_foto = array(
			array (
				"width"			=>150,
				"height"		=>150,
				"out"			=>$pathFoto."/".md5(microtime(false)).".jpg",
				"resize_type"	=>"exact"
			),
			array (
				"width"			=>90,
				"height"		=>90,
				"out"			=>$pathFoto."/".md5(microtime(false)).".jpg",
				"resize_type"	=>"exact"
			),
			array (
				"width"			=>800,
				"height"		=>800,
				"out"			=>$pathFoto."/".md5(microtime(false)).".jpg",
				"resize_type"	=>"exact"
			),
		);
		
		$CFoto->fotoResize(
			$newpath, 
			$array_foto
		);
		global $DB;
		$DB->Query('SELECT MAX(GROUP_FOTO_ID) FROM `ga_media_link`');
		$group = $DB->db_EXEC->fetchColumn() +1;
		if(is_array($array_foto))
		{
			foreach ($array_foto as $array_fotoEl)
			{
				$arFieldsProp = array(
					"PATH"			=>		$array_fotoEl["out"],
					"SIZE"			=>		$array_fotoEl["width"],
					"GROUP_FOTO_ID"	=>		$group,
				);
				
				$res = CAllMain::ParentAdd("ga_media_link", $arFieldsProp);
			}
		}
	
		echo $group."<br>";
		echo $CFoto->status;
	}
}
echo '</pre>';

?>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>




