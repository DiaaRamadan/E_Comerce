<?php

ini_set('display_error','on');
error_reporting(E_ALL);

include 'connect.php';

$sessionuser='';
if(isset($_SESSION['user']))
{
	$sessionuser=$_SESSION['user'];
}
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
 


	





?>