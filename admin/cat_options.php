<?php
session_start();

$page=isset($_GET['page'])?$_GET['page']:'manage';



if($page=='Add'){

	echo "add page";

}

?>