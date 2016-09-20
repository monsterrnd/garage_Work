<?require($_SERVER["DOCUMENT_ROOT"]."/core/modules/main/root.php");?>
<?
$CAllMain = new CAllMain;	

list($sec)  = explode(".",microtime(true));
$endsec = $sec + 60;// за минуту

$count = 0;
while ($this_sec < $endsec) 
{
	list($this_sec)  = explode(".",microtime(true));
	$res = $CAllMain->ParentGetList("ga_company", array(), array(), array());
	$count++;
}
echo $count;


?>