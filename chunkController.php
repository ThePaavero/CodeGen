<?php

use ThePaavero\CodeGen as CodeGen;

$data = $_POST;

require 'vendor/autoload.php';

$data['characters'] = explode(',', $data['characters']);

foreach($data['characters'] as $key => $val)
{
	$data['characters'][$key] = trim($val);
}

$data['append'] = true;

$config = $data;

$codegen = new CodeGen\CodeGen($config);
$codegen->generateAndSave();

echo 'ok';