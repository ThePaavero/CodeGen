<?php

use ThePaavero\CodeGen as CodeGen;

require 'vendor/autoload.php';

$codegen = new CodeGen\CodeGen();
$codegen->setCodeAmount(270);
$codegen->setCodeLength(10);
$codegen->setCharacters(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 1, 2, 3, 4, 5, 6, 7, 9]);
$codegen->setFile('270_pingviini_codes.txt');
$codegen->generateAndSave();

echo 'Done.';