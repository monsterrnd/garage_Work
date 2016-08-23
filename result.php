<?
header('Content-type: application/json');
$i = 1;




$iterator = new FilesystemIterator("./tmp");
$filelist = array();
foreach($iterator as $entry) {

	if (strpos($entry->getFilename(), "json_") === 0) {
        $filelist[] = $entry->getFilename();
	}
}

///чтение
$jsonGet = array();
foreach ($filelist as $fileEl):
	$file = file_get_contents('./tmp/'.$fileEl, true);
	$jsonGet[] = json_decode($file);
	unlink('./tmp/'.$fileEl);
endforeach;

echo json_encode(array("status"=>"Ok","result"=>$jsonGet));
