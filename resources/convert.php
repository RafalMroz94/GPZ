<?php
function convertValue($string,$precision) {
	$value=str_replace(',','.',$string);
	if (is_numeric($value)) {
		$value=round($value,$precision);
		$value=number_format((float)$value,$precision,',','');;
		return $value;
	}
	else return $value;
}

function calculateUmFromUp($value) {
	switch ($value) {
		case '3': return '0,72';
		case '6': return '1,2';
		case '10': return '3,6';
		case '20': return '7,2';
		case '28': return '12';
		case '38': return '17,5';
		case '50': return '24';
		case '70': return '36';
		case '95': return '52';
		case '140': return '72,5';
		default: return '-';
	}
}

function convertUpn($string) {
	if (strpos($string,'/V3')) {
		$value=str_replace('/V3','',$string);
		$value=str_replace(',','.',$value);
		if (is_numeric($value)) {
			$value*=1000;
			return $value.'/&#8730;3';
		}
		else return $string;
	}
	else {
		$value=str_replace(',','.',$string);
		if (is_numeric($value)) {
			$value*=1000;
			return $value;
		}
		else return $string;
	}
}

function convertUsn($string) {
	$value=str_replace('/V3','/&#8730;3',$string);
	return $value;
}

function convertToTemplate($data,$parametersTemplate,$type,$precUI,$precA) {
	$converted=array();
	$quantity=count($data);
	$lp=0;
	if ($type===1) {
		for ($page=0;$lp<$quantity;$page++) {
			for ($j=0;$j<10;$j++) {
				if ($lp<$quantity) {
					$i=0;
					foreach ($data[$lp] as $value) {
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						if ($i>6&&$i<12) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precUI);
						elseif ($i>11&&$i<17) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precA);
						else $converted[$page][$j][$parameterTemplate]=$value;
						$i++;
					}
					$converted[$page][$j]['!UM'.$j.'!']=calculateUmFromUp($converted[$page][$j]['!UP'.$j.'!']);
					$converted[$page][$j]['!LP'.$j.'!']=$lp+1;
					$lp++;
				}
				else {
					$i=0;
					foreach ($data[0] as $value) {
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						$converted[$page][$j][$parameterTemplate]='-';
						$i++;
					}
					$converted[$page][$j]['!UM'.$j.'!']='-';
					$converted[$page][$j]['!LP'.$j.'!']='-';
				}
			}
		}
		return $converted;
	}
	elseif ($type===2) {
		for ($page=0;$lp<$quantity;$page++) {
			for ($j=0;$j<10;$j++) {
				if ($lp<$quantity) {
					$i=0;
					foreach ($data[$lp] as $value) {
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						if ($i==2) $converted[$page][$j][$parameterTemplate]=convertUpn($value);
						elseif ($i==4) $converted[$page][$j][$parameterTemplate]=convertUsn($value);
						elseif ($i>5&&$i<12) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precUI);
						elseif ($i>11&&$i<18) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precA);
						else $converted[$page][$j][$parameterTemplate]=$value;
						$i++;
					}
					$converted[$page][$j]['!LP'.$j.'!']=$lp+1;
					$lp++;
				}
				else {
					$i=0;
					foreach ($data[0] as $value) {
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						$converted[$page][$j][$parameterTemplate]='-';
						$i++;
					}
					$converted[$page][$j]['!LP'.$j.'!']='-';
				}
			}
		}
		return $converted;
	}
	else return false;
}
?>
