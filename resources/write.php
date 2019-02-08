<?php
function writeAll($templateDir,$resultsDir,$data,$misc,$quantity,$filenameDate) {
	$pages=count($data);
	for ($i=0;$i<$pages;$i++) {
		$file=file_get_contents($templateDir,'r');
		for ($j=0;$j<10;$j++) {
			foreach ($data[$i][$j] as $id => $value) $file=str_replace($id,$value,$file);
		}
		foreach ($misc as $id2 => $value2) $file=str_replace($id2,$value2,$file);
		$file=str_replace('!QUAN!',$quantity,$file);
		$file=str_replace('!PAGE!',$i+1,$file);
		$file=str_replace('!PAGES!',$pages,$file);
		file_put_contents($resultsDir.$filenameDate.'_'.($i+1).'.htm',$file);
	}
}
?>
