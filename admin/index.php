<?php

session_start();

$nonavbar='';
$pagetitle='login';
if(isset($_SESSION['username']))
{
	header('location: dashbord.php');

}
include 'init.php';


if($_SERVER['REQUEST_METHOD']=='POST')
{
	$user_name= $_POST['username'];

	$password= $_POST['pass'];

	$hashedpassword=sha1($password);

	//check if the user exist in the database

	$query="SELECT `userID`, `username` ,`password` FROM `users` WHERE `username`='$user_name' AND `password`='$hashedpassword' AND    `GroupID`=1";

	
      if($query_run=mysql_query($query))
      {
      	$num_rows=mysql_num_rows($query_run);
      	$result=mysql_fetch_array($query_run);

      	if($num_rows>0)
      	{
      		
      		$_SESSION['username']=$user_name;
      		$_SESSION['ID']=$result['userID'];

      		header('location: dashbord.php');
      		exit();
      	}

	  }
}


?>


	<form  class="login"  action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		<h2 class="text-center ">Admin Login</h2>
		<input class="form-control input-lg" type="text" name="username"  placeholder="Username" autocomplete="off"/>
		<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="off"/>
		<input class="btn btn-primary btn-block input-lg" type="submit" value="Log in">

	</form>


		


<?php

include $tpl.'footer.php';
?>
