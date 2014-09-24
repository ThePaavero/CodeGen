<?php

// This is a usage example of CodeGen

use ThePaavero\CodeGen as CodeGen;

require 'vendor/autoload.php';

$config = [
	'amount' => 350,
	'codeLength' => 10,
	'characters' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 1, 2, 3, 4, 5, 6, 7, 9],
	'file' => 'codes.txt',
	'append' => true
];

$codegen = new CodeGen\CodeGen($config);
$codegen->generateAndSave();

echo 'Done.';
