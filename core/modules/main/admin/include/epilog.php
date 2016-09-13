<?
require($_SERVER["DOCUMENT_ROOT"].ROOT."/modules/main/admin/include/epilog_before.php");
require($_SERVER["DOCUMENT_ROOT"].ROOT."/modules/main/admin/include/epilog_after.php");

$end_time = microtime();
$end_array = explode(" ",$end_time);
$end_time = $end_array[1] + $end_array[0];
$time = $end_time - $start_time;

printf("Страница сгенерирована за %f секунд",  $time);

?>