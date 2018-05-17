<?php
 $localhost='localhost';

 $root='root';

 $pass='';

 $db_name='shop';
 $con=mysql_connect($localhost,$root,$pass);

 if(!$con||!mysql_select_db($db_name))
 {
 	die(mysql_error());
 }
 

?>