<?php

define('REPORTS_DIR','./reports/');
define('RESULTS_DIR','./results/');

define('TEMPLATECT_DIR','./templates/TemplateCT.htm');
define('TEMPLATEVT_DIR','./templates/TemplateVT.htm');

define('PARAMETERS_DIR','./resources/parameters.php');
define('READ_DIR','./resources/read.php');
define('CONVERT_DIR','./resources/convert.php');
define('WRITE_DIR','./resources/write.php');
define('MISC_DIR','./resources/misc.php');

define('STYLE_DIR','./resources/style.css');
define('FORM_DIR','./resources/form.php');
define('SUCCESS_DIR','./resources/success.php');
define('ERROR_DIR','./resources/error.php');

require(PARAMETERS_DIR);
require(READ_DIR);
require(CONVERT_DIR);
require(WRITE_DIR);
require(MISC_DIR);

date_default_timezone_set('Europe/Warsaw');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	clearFolder(REPORTS_DIR);
	clearFolder(RESULTS_DIR);
	
	$type=(int)$_POST["TYPE"];
	$precUI=(int)$_POST["PRECUI"];
	$precA=(int)$_POST["PRECA"];
	$misc=array(
	'!PLACE!' => $_POST["PLACE"],
	'!PROD!' => $_POST["PROD"],
	'!DATE!' => $_POST["DATE"],
	'!COMMENTS!' => $_POST["COMMENTS"]
	);
	
	foreach ($_FILES['files']['name'] as $id => $name) {
		if (strlen($_FILES['files']['name'][$id])>1) move_uploaded_file($_FILES['files']['tmp_name'][$id],REPORTS_DIR.$name);
    }
	
	if ($type===1) {
		$parameters=$parametersGPZ_CT;
		$parametersTemplate=$parametersTemplateCT;
		$templateDir=TEMPLATECT_DIR;
	}
	if ($type===2) {
		$parameters=$parametersGPZ_VT;
		$parametersTemplate=$parametersTemplateVT;
		$templateDir=TEMPLATEVT_DIR;
	}

	$data=readAll(REPORTS_DIR.'*.htm',$parameters,$type);
	if ($data!==false) {
		$quantity=count($data);
		$data=convertToTemplate($data,$parametersTemplate,$type,$precUI,$precA);
		$filenameDate='GPZ_'.date('Ymd_His');
		writeAll($templateDir,RESULTS_DIR,$data,$misc,$quantity,$filenameDate);
		zipResults($filenameDate,RESULTS_DIR);
		require(SUCCESS_DIR);
	}
	else require(ERROR_DIR);
	unset($data);
	
}

else require(FORM_DIR);
?>
