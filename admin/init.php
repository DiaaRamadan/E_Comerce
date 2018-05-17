<?php

include 'connect.php';
//Routes

$tpl='include/templates/';

$func='include/functions/';

$css='layout/css/';

$js='layout/js/';

$lang='include/languages/';

//include important filles

include $lang.'english.php';
include $func.'functions.php';
include $tpl.'header.php';

//include navbar in all pages excpect the pages that have $nonavbar variable. 

if(!isset($nonavbar))
{
	include $tpl.'navbar.php';
}




?>