<?php
include 'lib/jQuery.php';
include 'lib/HtmlCode.php';

$jq = new jQuery("document");
$htm = new HtmlCode();

$jsonCode = json_decode(file_get_contents("lib/jsoncode.json"),true);
$htm->parseJson($jsonCode);

$documentReady = function(){
	$jq1 = new jQuery("'#testDiv'");
	$jq1->find('p');
	$jq1->css('color','blue');
	$clickHandle = function(){
		$jq2 = new jQuery("this");
		return $jq2->css('color','red')->output();
	};
	$jq1->on('click',$clickHandle);
	return $jq1->output();
};
$scriptOutput = $jq->ready($documentReady)->output();
$htm->script_start()->contents($scriptOutput)->script_end();
echo $htm->output();