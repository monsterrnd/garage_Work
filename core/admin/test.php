<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/header.php");?>

<?
//
//global $DB;						
//$DB->Query("SELECT ma.name, mo.name AS model_name, ma.id_car_mark, mo.id_car_mark "
//		. "FROM car_mark ma "
//		. "INNER JOIN  car_model mo "
//		. "ON mo.id_car_mark = ma.id_car_mark");			
//$res = $DB->DBprint();
$c = new CAllMain;
$res = $c->ParentGetList("ga_allservices", array("NAME"=>"desc"), array(), array("TOP_COUNT" =>5))
?>
<pre>
<?  print_r($res)?>
</pre>
<?require($_SERVER["DOCUMENT_ROOT"]."/core/admin/footer.php");?>

