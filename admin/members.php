<?php
session_start();

$pagetitle='Members';

if(isset($_SESSION['username']))
{
	
	include 'init.php';


	$do=isset($_GET['do']) ? $_GET['do'] :'Manage';

	if($do=='Manage'){//manage page
		$query1='';

		if(isset($_GET['page'])&&isset($_GET['page'])=='Pending')
		{
			$query1="AND Regstatus=0";
		}

		$query="SELECT * from `users` WHERE `GroupID`!=1 $query1 ORDER BY userID DESC";

		$query_run=mysql_query($query);
		

		?>

		
		<h1 class="text-center">Manage Members</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>Username</td>
						<td>Email</td>
						<td>Full Name</td>
						<td>Registerd Date</td>
						<td>Control</td>
					</tr>

					<?php
						


							 while($query_row=mysql_fetch_assoc($query_run))
						        {
						        	echo '<tr>';
										echo '<td>'.$query_row['userID'].'</td>';
										echo '<td>'.$query_row['username'].'</td>';
										echo '<td>'.$query_row['Email'].'</td>';
										echo '<td>'.$query_row['FullName'].'</td>';
										echo '<td>'.$query_row['Date'].'</td>';
										echo "<td>
												<a href='members.php?do=Edit&userid=".$query_row['userID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='members.php?do=Delete&userid=".$query_row['userID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
												if($query_row['Regstatus']==0)
													{
														echo  "<a href='members.php?do=Activate&userid=".$query_row['userID']. "' class='btn btn-info activate'><i class='fa fa-check'></i> Activate</a>";
													}


											  echo "</td>";



									echo '</tr>';
									 
								}

							
						

					?>
					

				</table>

			</div>
			<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Members</a>
		</div>
		<?php
	}

	elseif($do=='Add'){ //Add new members?>

	<h1 class="text-center">Add New Members</h1>

	<div class="container">
		
		<form class="form-horizontal" action="members.php?do=Insert" method="POST">

			<!--Start username-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">UserName</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="username" class="form-control" autocomplete="off" required="required"  placeholder="Username to loggin into shop" />
				</div>
			</div>
			<!--end username-->

			<!--Start Password-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Password</label>
				<div class="col col-sm-10 col-md-6">
				<input type="password" name="password" class="password form-control" autocomplete="off" required="required" placeholder="Password must be hard & complex" />
				<i class="show-pass fa fa-eye fa-2x"></i>
				</div>
			</div>
			<!--end username-->

			<!--Start Email-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Email</label>
				<div class="col col-sm-10 col-md-6">
				<input type="email" name="email" class="form-control" autocomplete="off" required="required" placeholder="Email must be valid" />
				</div>
			</div>
			<!--end Email-->

			<!--Start full name-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Full Name</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="fullname" class="form-control" autocomplete="off" required="required" placeholder="Fullname appear on your profile" />
				</div>
			</div>
			<!--end full name-->

			<!-- Start btn add-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Member" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!-- End btn add-->

		</form>

	</div>
		
    <?php


	}

	//insert page

	elseif ($do=='Insert') {



		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			echo "<div class='container'>";

			echo "<h1 class='text-center'> Insert Member</h1>";
		

			 
			 $user=$_POST['username'];
			 $pass=$_POST['password'];
			 $useremail=$_POST['email'];
			 $fullname=$_POST['fullname'];

			 $hashpass=sha1($pass);

			

			 $form_error=array();

			 if(strlen($user)<4)
			 {
			 	$form_error[]='User Name Can Not be Less Then<strong> 4 Characters</strong>  ';
			 }

			if(empty($user))
			{
				$form_error[]='User Name Can Not be<strong> Empty</strong>';
			}

			 if(strlen($user)>20)
			 {
			 	$form_error[]='User Name Can Not be More Then <strong>20 Characters</strong> ';
			 }

			 if(empty($pass))
			{
				$form_error[]='Password Can Not be <strong> Empty</strong>';
			}

			if(empty($useremail))
			{
				$form_error[]='Email Can Not be<strong> Empty</strong>';
			}
			if(empty($fullname))
			{
				$form_error[]='Full Name Can Not be <strong> Empty</strong>';
			}

			foreach ($form_error as $error) {

				$theMsg = '<div class="alert alert-danger">'. $error.'</div>'; 
				redirecthome($theMsg,'back');
			}

			if(empty($form_error))
			{
				$query="SELECT `username` FROM `users` WHERE `username`='$user'";
				if($query_run=mysql_query($query)){
					$num_row=mysql_num_rows($query_run);

					 if($num_row==1)
					 {
					 	$theMsg= "<div class='alert alert-danger'>Sorry This User Exist</div>";
					 	redirecthome($theMsg,'back');
					 }else{
							//insert user information into databases
							$query="INSERT INTO `users`(`username`, `password`, `Email`, `FullName`,`Regstatus`,`Date`) VALUES ('$user',' $hashpass','$useremail','$fullname',1,now())";
							if($query_run=mysql_query($query))
							{
								$theMsg= '<div class="alert alert-success">1 Record inserted </div>'; 
							}else
							{
								$theMsg= '<div class="alert alert-success">0 Record inserted </div>'; 

							}
							
								redirecthome($theMsg,'back');

					 }
				}
				
			}
		}else
		{
			echo '<div class="container">';
			$theMsg= '<div class="alert alert-danger"> You Can not Browse This Page Directly</div>';
			redirecthome($theMsg);
			echo '</div>';
		}
		echo '</div>';

	}

	
    

	elseif($do=='Edit'){//Edit page 

         $userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			$query="SELECT * FROM `users` WHERE `userID`='$userid' LIMIT 1";
			$query_run=mysql_query($query);
			$num_rows=mysql_num_rows($query_run);
			$result=mysql_fetch_array($query_run);

			if($num_rows>0){?> 

				<h1 class="text-center"> Edit Member</h1>

				<div  class="container">
					
					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="hidden" name="userid" value="<?php echo $userid ?>" />
						<!-- Start username-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable"> UserName</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="username" class="form-control" value="<?php echo $result['username']?>" autocomplete="off" required="required"/>
							</div>

						</div>
						<!-- End username-->

						<!-- Start password-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable"> Password</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="password" name="newpassword" class="password form-control " autocomplete="off" placeholder="Leave Blank If You Don't Want To Change"/>
								<i class="show-pass fa fa-eye fa-2x"></i>

								<input type="hidden" name="oldpassword" class="form-control " value="<?php echo $result['password']; ?>" autocomplete="off"/>

							</div>

						</div>
						<!-- End password-->

						<!-- Start email-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2  control-lable"> Email</label>

							<div class="col-sm-10 col-md-6" >
								
								<input type="email" name="email"  class="form-control" value="<?php echo $result['Email']?>"  required="required"/>
							</div>

						</div>
						<!-- End email-->

						<!-- Start fullname-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable"> Fullname</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="fullname" class="form-control" value="<?php echo $result['FullName']?>"  required="required"/>
							</div>

						</div>
						<!-- End fullname-->

						<!-- Start btn save-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!-- End btn save-->
					
					</form>
				</div>
		<?php
	}else
		{
			echo "<div class='container'>";
				$theMsg= '<div class="alert alert-danger">There no such user</div>';
				redirecthome($theMsg);
			echo "</div>";	
		}
	} elseif ($do=='Update') {


		echo "<h1 class='text-center'> Update Member</h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD']=='POST')
		{

			 $id=$_POST['userid'];
			 $user=$_POST['username'];
			 $useremail=$_POST['email'];
			 $fullname=$_POST['fullname'];

			 $pass=!empty('newpassword')? sha1($_POST['newpassword']):sha1($_POST['oldpassword']);

			 $form_error=array();

			 if(strlen($user)<4)
			 {
			 	$form_error[]='<div class="alert alert-danger">User Name Can Not be Less Then<strong> 4 Characters</strong> </div> ';
			 }

			if(empty($user))
			{
				$form_error[]='<div class="alert alert-danger">User Name Can Not be<strong> Empty</strong> </div>';
			}

			 if(strlen($user)>20)
			 {
			 	$form_error[]='<div class="alert alert-danger">User Name Can Not be More Then <strong>20 Characters</strong></div> ';
			 }

			if(empty($useremail))
			{
				$form_error[]='<div class="alert alert-danger">Email Can Not be<strong> Empty</strong></div>';
			}
			if(empty($fullname))
			{
				$form_error[]='<div class="alert alert-danger">Full Name Can Not be <strong> Empty</strong></div>';
			}

			foreach ($form_error as $error) {

				echo $error; 
			}

			if(empty($form_error))
			{
				$query="UPDATE `users` SET `username`='$user',`Email`='$useremail',`FullName`='$fullname',`password`='$pass' WHERE     `userID`='$id' ";
				if($query_run=mysql_query($query))
				{

					
					$theMsg= '<div class="alert alert-success">1 Record Updated </div>'; 
					redirecthome($theMsg,'back');
				}else
				{
					$theMsg= '<div class="alert alert-success">0 Record Updated </div>';
					redirecthome($theMsg,'back');

				}
			}
		}else
		{
			$errormsg='<div class="alert alert-danger">You Can Browse This Page Directly</div>';
			redirecthome($errormsg,'back');
		}
		echo '</div>';

	}elseif ($do=='Delete') {//delete page

		echo "<h1 class='text-center'> Update Member</h1>";
		echo "<div class='container'>";

		$userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		

		$query="SELECT * FROM `users`WHERE `userID`='$userid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="DELETE FROM `users` WHERE `userID`='$userid'";

					$query_run=mysql_query($query);
					$theMsg='<div class="alert alert-success">'.$num_rows.' Row deleted</div>';
					redirecthome($theMsg,'back');

			}else{

				echo '<div class="container">';
					$theMsg= '<div class="alert alert-success"> ID Not Exist</div>';

					redirecthome($theMsg,'back');
				echo "</div>";

			}
		}
		
		echo "</div>";
	
	} else if($do=='Activate'){
		//activate page

		echo "<h1 class='text-center'> Activate Member</h1>";
		echo "<div class='container'>";

		$userid=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		

		$query="SELECT * FROM `users`WHERE `userID`='$userid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="UPDATE `users` SET `Regstatus`=1 WHERE `userID`='$userid'";

					$query_run=mysql_query($query);
					$theMsg='<div class="alert alert-success">'.$num_rows.' Record Updated</div>';
					redirecthome($theMsg,'back');

			}else{

				echo '<div class="container">';
					$theMsg= '<div class="alert alert-success"> ID Not Exist</div>';

					redirecthome($theMsg,'back');
				echo "</div>";

			}
		}
		
		echo "</div>";
	}

    include $tpl.'footer.php';

}
else
{
	header('location: index.php');
	exit();
}
