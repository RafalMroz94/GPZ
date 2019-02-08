<?php
function hasParameters($file) {
	if (strpos($file,'GPZ_CURRENT')!==false) return 1;
	if (strpos($file,'GPZ_VOLTAGE')!==false) return 2;
	else return 0;
}

function readValue($file,$parameter) {
	if (preg_match('/'.$parameter.' (.*?) #/', $file, $match)==1) {
		if (strlen($match[1])>0&&strlen($match[1])<21&&$match[1]!="&nbsp") return $match[1];
		else return false;
	}
	else return false;
}

function readOne($parameters,$report,$type) {
	if (hasParameters($report)==$type) {
		$one=array();
		$i=0;
		foreach ($parameters as $parameter) {
			$value=readValue($report,$parameter);
			if ($value!==false) $one[$i]=$value;
			else $one[$i]='-';
			$i++;
		}
		return $one;
	}
	else return false;
}

function readAll($dir,$parameters,$type) {
	$files=glob($dir);
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
