<?php

use Traits\TraitParseUrl;

header("Content-Type: text/html; charset=utf-8");
include("config/config.php");
include __DIR__."/lib/vendor/autoload.php";
include("helpers/variables.php");


$dispatch=new Classes\ClassDispatch;
include($dispatch->getInclusao());