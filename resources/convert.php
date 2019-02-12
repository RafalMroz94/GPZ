<?php
function convertValue($string,$precision) { // round value and set constant decimal places
	$value=str_replace(',','.',$string);
	if (is_numeric($value)) {
		$value=round($value,$precision);
		$value=number_format((float)$value,$precision,',',''); // constant decimal places, ',' instead of '.'
		return $value;
	}
	else return $value;
}

function calculateUmFromUp($value) { // calculate nominal voltage from test voltage, based on IEC 61869-1
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

function convertUpn($string) { // convert kilovolts to volts and convert "V3" to sqrt(3)
	if (strpos($string,'/V3')) { // case when "V3" is present
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

function convertUsn($string) { // in secondary voltage convert only "V3"
	$value=str_replace('/V3','/&#8730;3',$string);
	return $value;
}

function convertToTemplate($data,$parametersTemplate,$type,$precUI,$precA) {
	$converted=array();
	$quantity=count($data);
	$lp=0; //ordinal number of instrument transformer in table
	if ($type===1) { // current transformer
		for ($page=0;$lp<$quantity;$page++) { // loop for page number
			for ($j=0;$j<10;$j++) { // loop for 10 instrument transformers on single page
				if ($lp<$quantity) { // until last instrument transformer
					$i=0; // number of current parameter (tag), order of parameters in parameters.php
					foreach ($data[$lp] as $value) { // for each parameter in current instrument transformer
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]); // replace "$X" with number from 0 to 9 (row in output template)
						if ($i>6&&$i<12) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precUI); // parameters 7-11 need conversion (current error values)
						elseif ($i>11&&$i<17) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precA); // parameters 12-16 need conversion (angle error values)
						else $converted[$page][$j][$parameterTemplate]=$value; // for the rest of parameters, just put value in new, formatted array
						$i++;
					} // below special parameters not present in input report, so not present in parameters.php, need individual aproach
					$converted[$page][$j]['!UM'.$j.'!']=calculateUmFromUp($converted[$page][$j]['!UP'.$j.'!']);
					$converted[$page][$j]['!LP'.$j.'!']=$lp+1;
					$lp++;
				}
				else { // when all instrument transformers converted, fill rest of the page with '-'
					$i=0;
					foreach ($data[0] as $value) { // take parameters from first element in array (could be anything)
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						$converted[$page][$j][$parameterTemplate]='-';
						$i++;
					}
					$converted[$page][$j]['!UM'.$j.'!']='-';
					$converted[$page][$j]['!LP'.$j.'!']='-';
				}
			}
		}
		return $converted; // return converted array, ready to write
	}
	elseif ($type===2) { // voltage transformer, this case works similar to current transformer
		for ($page=0;$lp<$quantity;$page++) {
			for ($j=0;$j<10;$j++) {
				if ($lp<$quantity) {
					$i=0;
					foreach ($data[$lp] as $value) {
						$parameterTemplate=str_replace('$X',$j,$parametersTemplate[$i]);
						if ($i==2) $converted[$page][$j][$parameterTemplate]=convertUpn($value); // parameter 2 needs conversion (primary voltage)
						elseif ($i==4) $converted[$page][$j][$parameterTemplate]=convertUsn($value); // parameter 4 needs conversion (secondary voltage)
						elseif ($i>5&&$i<12) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precUI); // voltage error values
						elseif ($i>11&&$i<18) $converted[$page][$j][$parameterTemplate]=convertValue($value,$precA); // angle error values
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
