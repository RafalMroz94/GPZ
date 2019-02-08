<?php
function clearFolder($dir) {
	$files=glob($dir.'*.*');
	if (count($files)!=0) {
		foreach ($files as $file) unlink($file);
	}
}

function zipResults($filenameDate,$resultsDir) {
	$zip=new ZipArchive();
	$zip->open($resultsDir.$filenameDate.'.zip',ZipArchive::CREATE);
	foreach (glob($resultsDir.'*.htm') as $file) {
		$zip->addFile($file,str_replace($resultsDir,'',$file));
	}
	$zip->close();
}
?>
