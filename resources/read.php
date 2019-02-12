<?php
function hasParameters($file) { // check if file is valid report
	if (strpos($file,'GPZ_CURRENT')!==false) return 1;
	if (strpos($file,'GPZ_VOLTAGE')!==false) return 2;
	else return 0;
}

function readValue($file,$parameter) {
	if (preg_match('/'.$parameter.' (.*?) #/', $file, $match)==1) { // regex, non-greedy (lazy) match
		if (strlen($match[1])>0&&strlen($match[1])<21&&$match[1]!="&nbsp") return $match[1]; // input files sometimes have &nbsp when empty parameter
		else return false;
	}
	else return false;
}

function readOne($parameters,$report,$type) { // read data from one file (one instrument transformer)
	if (hasParameters($report)==$type) { // check if valid file
		$one=array();
		$i=0; // array indexes in 'int' for now, will convert later
		foreach ($parameters as $parameter) {
			$value=readValue($report,$parameter); // read specified parameter from file
			if ($value!==false) $one[$i]=$value;
			else $one[$i]='-'; // when parameter is empty put '-'
			$i++;
		}
		return $one;
	}
	else return false;
}

function readAll($dir,$parameters,$type) { // read data from all reports in folder
	$files=glob($dir); // list all files in folder
	$all=array();
	$i=0;
	foreach ($files as $file) {
		$one=readOne($parameters,file_get_contents($file,'r'),$type);
		if ($one!==false) {
			$all[$i]=$one;
			$i++;
		}
	}
	if ($i==0) return false;
	else return $all;
}
?>
