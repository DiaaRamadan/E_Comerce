<?php 
ob_start();
session_start();

$pagetitle='login';
if(isset($_SESSION['user']))
{
	header('location: index.php');

}

include 'init.php';

$formerrors=array();


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['login'])){

		$user=$_POST['username'];
		$pass=$_POST['password'];
		$hashedpass=sha1($pass);

		$query="SELECT `userID`, `username` ,`password` FROM `users` WHERE `username`='$user' AND `password`='$hashedpass'";

		if($query_run=mysql_query($query)){

			$num_rows=mysql_num_rows($query_run);
			$result=mysql_fetch_array($query_run);
			if($num_rows>0){

				$_SESSION['user']=$user;
				$_SESSION['uid']=$result['userID'];

				header("location:index.php");
				exit();
			}
		}
		else
		{
			$forme= "Invalid username or password";
		}


	}else{

			if(isset($_POST['username'])){

				$filterusername=filter_var($_POST['username'],FILTER_SANITIZE_STRING);

				if(strlen($filterusername)<4)
				{
					$formerrors[]='$User name should be more than 4 characters';
				}

				if(strlen($filterusername)>30)
				{
					$formerrors[]='$User name should be less than 30 characters';
				}
			}



		if(isset($_POST['password']) && isset($_POST['password2'])){

			if(empty($_POST['password'])){

				$formerrors[]='Sorry password can not be <strong>Empty</strong>';

			}
		 

			$shapass1=sha1($_POST['password']);
			$shapass2=sha1($_POST['password2']);

			if($shapass1!=$shapass2){

				$formerrors[]='Sorry password not <strong>Matchs</strong>';

			}
		}


		if(isset($_POST['email'])){

			
			$filteremail=filter_var($_POST['username'],FILTER_SANITIZE_EMAIL);

			if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){

				$formerrors[]='This Email not <strong>Vaild</strong>';

			}
		}


			

			if($password==$password2){

				$query="SELECT * FROM `users` WHERE `username`='$username' ";
				$query_run=mysql_query($query);
				$num_rows=mysql_num_rows($query_run);

				if($num_rows>0){
					$userexist= "This username already exist";
				}else{
					$query="INSERT INTO `users` ( `username`, `password`, `Email`, `FullName`,`Date`) VALUES('$username','$hashpass','$email','$fullname',now())";
					if($query_run=mysql_query($query))
					{
						$signcomplete='Congratulation <i class="fa fa-smile-o></i>';

					}else{
						$formerrors[]='Sorry, Try again';
					}

				}
			}
		}

}




?>



<div class="container login-page">
	<h1 class="text-center"><span data-class="login" class="lchoose">Log in</span> | <span data-class="signup">Sign up</span></h1>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		<div class="input-astr">

			
			
			<input 
		    class="form-control" 
		    type="text" 
		    name="username" 
		    required 
		    autocomplete="off" 
		    placeholder="Type your username ">
		</div>	
		<div class="input-astr">
			<input 
			class="form-control" 
			type="password" 
			name="password" 
			required 
			autocomplete="off" 
			placeholder="Type your password ">
		</div>

			<input class="btn btn-primary btn-block" type="submit" name="login" value="Log in" />
		
	</form>

	<form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		<div class="input-astr">
			<input
			pattern="{4,30}" 
		    title="User name must be between 4 & 30"  
			 class="form-control" 
			 type="text" 
			 name="username" 
			 autocomplete="off" 
			 placeholder="Type your username ">
		</div>
		<div class="input-astr">
			<input
			 class="form-control" 
			 type="text" 
			 name="fullname" 
			 autocomplete="off" 
			 placeholder="Type your fullname">
		</div>

		<div class="input-astr">
			<input 
			class="form-control signpass" 
			 type="password" 
			 name="password" 
			 autocomplete="off" 
			 placeholder="Type your password ">

			<i class="show-signpass fa fa-eye"></i>
		</div>
		<div class="input-astr">
			<input 

			class="form-control" 
			type="password" 
			name="password2" 
			autocomplete="off" 
			placeholder="Type your password again ">

		</div>
		<div class="input-astr">
			<input 
			class="form-control" 
			type="email" 
			name="email"  
			placeholder="Type a valid email ">
		</div>
		<div>
			<input class="btn btn-success btn-block" type="submit" value="Sign up" />
		</div>
	</form>
	<div class="the-msgs alter alter-info text-center">
		<?php 
			foreach ($formerrors as $error) {
				echo $error.'<br>';
			}

		?>
	</div>
</div>


<?php include $tpl.'footer.php';?>