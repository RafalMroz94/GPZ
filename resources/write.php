<?php
function writeAll($templateDir,$resultsDir,$data,$misc,$quantity,$filenameDate) { // write data to output files
	$pages=count($data);
	for ($i=0;$i<$pages;$i++) { // loop for all pages
		$file=file_get_contents($templateDir,'r'); // read template into memory
		for ($j=0;$j<10;$j++) { // loop for each instrument transformer on one page
			foreach ($data[$i][$j] as $id => $value) $file=str_replace($id,$value,$file); // write data from converted array
		}
		foreach ($misc as $id2 => $value2) $file=str_replace($id2,$value2,$file); // write additional data from form
		$file=str_replace('!QUAN!',$quantity,$file); // quantity of instrument transformers
		$file=str_replace('!PAGE!',$i+1,$file); // current page
		$file=str_replace('!PAGES!',$pages,$file); // number of pages
		file_put_contents($resultsDir.$filenameDate.'_'.($i+1).'.htm',$file); // write file contents from memory to file
	}
}
?>
