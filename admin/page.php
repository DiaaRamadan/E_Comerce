<?php

$do='';

if(isset($_GET['do']))
{
	$do= $_GET['do'];
}else
{
	$do='manage';
}

if($do=='Manage')
{
	echo 'You are in manage page';
}

elseif($do=='Add')
{
	echo 'You are in manage page';
}
?>