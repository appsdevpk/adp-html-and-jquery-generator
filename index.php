<?php
include 'lib/jQuery.php';
include 'lib/HtmlCode.php';

$jq = new jQuery("document");
$htm = new HtmlCode();

$htm->head_start();
$htm->title_start()->contents('Web Page Title')->title_end();
$htm->script_start(array('src'=>'https://code.jquery.com/jquery-3.4.1.min.js'))->script_end();
$htm->head_end();
$htm->body_start();
$htm->div_start(array('class'=>'testDivClass','id'=>'testDiv','styleSelector'=>'.testDivClass','style'=>array(
	'width'=>'500px',
	'padding'=>'20px',
	'border'=>'1px solid #000',
	'margin'=>'50px auto'
)));
$htm->p_start();
$htm->contents('Some paragraph content here');
$htm->p_end();
$htm->div_end();
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
$htm->body_end();
echo $htm->output();