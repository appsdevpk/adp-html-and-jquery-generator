<?php
include 'lib/jQuery.php';
include 'lib/HtmlCode.php';

$htm = new HtmlCode();

$jsonCode = json_decode(file_get_contents("lib/jsoncoderealm.json"),true);
$htm->parseJson($jsonCode);

echo $htm->output();