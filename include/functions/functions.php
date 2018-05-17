
<?php

/*
**function to echo page title

*/ 
function getCat(){
	global $con;
	
    $query="SELECT * FROM `catagories` ORDER BY `ID` ASC";
	$query_run=mysql_query($query);
     while($result=mysql_fetch_array($query_run))
 		{
 			$catagoriesarray[]=$result;
 		}
 		 return $catagoriesarray;
 		

}

function getItems($where,$value,$approve=null){

	
	$sql='approve'==null ? 'AND approve=1':'';
	
	$query="SELECT * FROM `items` WHERE $where = $value $sql ORDER BY `item_ID` DESC ";
	$query_run=mysql_query($query);
     while($result=mysql_fetch_array($query_run))
 		{
 			$catagoriesarray[]=$result;
 		}
 		if(!empty($catagoriesarray)) {
 		 return $catagoriesarray;
 		}
}

function getusercomment($where,$value)
{
	$query="SELECT * FROM `comments` WHERE $where = $value ORDER BY `c_ID` DESC ";
	$query_run=mysql_query($query);
     while($result=mysql_fetch_array($query_run))
 		{
 			$catagoriesarray[]=$result;
 		}
 		if(!empty($catagoriesarray)) {
 		 return $catagoriesarray;
 		}
}


function ckeckuserstatus($user){

	$query="SELECT `username` , `Regstatus` FROM `users` WHERE `username`='$user' AND `Regstatus`=0";

	$query_run=mysql_query($query);

	$num_rows=mysql_num_rows($query_run);

	return $num_rows;
}



function getTitle()
{

	global $pagetitle;

	if(isset($pagetitle))
	{
		echo $pagetitle;
	}else
	{
		echo 'Default';
	}
}


/*

home redirect function 

*/
function redirecthome($errormassage,$url=null,$second=3)
{
	if($url==null)
	{
		$url='index.php';
		$link='Home Page';
	}else
	{
		if(isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER']))
		{
			$url=$_SERVER['HTTP_REFERER'];
			$link='Privous Page';
		}else
		{
			$url='index.php';
			$link='Home Page';
		}
		
	}
	echo $errormassage;
	echo "<div class='alert alert-info'>You Will Redirect To " .$link." In $second Seconds</div>";
	header("refresh:$second;url=$url");
	exit();
}

/*
**ckeck item

*/

function check_item($sele,$from,$value)

{
	global $con;
	$query="SELECT $sele FROM $from WHERE $sele='$value'";
	if($query_run=mysql_query($query)){

		 $num=mysql_num_rows($query_run);
		 return $num;
		
	}	
}

/*count item numbers*/

function countItems($field,$table)
{
	global $con;
	$query="SELECT COUNT($field) FROM $table";

	if($query_run=mysql_query($query))
	{
		
		 while($row = mysql_fetch_array($query_run)){
    	  return $row['COUNT('.$field.')'];
		}
	
	}
}

/*
 function ckeck latest any thing

*/
 function checkLatest($select , $table,$order , $limit=5)
 {
 	$query="SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit"	;

 	if($query_run=mysql_query($query))
 	{

 		while($query_row=mysql_fetch_assoc($query_run))
 		{
 			$storeArray[] =  $query_row;
 		}
 		return $storeArray;
 		
 	}
 }