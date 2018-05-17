<?php
session_start();

$pagetitle='Comments';

if(isset($_SESSION['username']))
{
	
	include 'init.php';


	$do=isset($_GET['do']) ? $_GET['do'] :'Manage';

	if($do=='Manage'){//manage page

		
			$query="SELECT comments.* ,users.username,items.Name AS Item_Name FROM comments
					INNER JOIN users ON users.userID=comments.user_id
					INNER JOIN items ON items.item_ID=comments.item_id ORDER BY c_ID DESC";

		$query_run=mysql_query($query);
		

		?>

		
		<h1 class="text-center">Manage Comment</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>ID</td>
						<td>Comment</td>
						<td>Item Name</td>
						<td>User Name</td>
						<td>Add Date</td>
						<td>Control</td>
					</tr>

					<?php
						


							 while($query_row=mysql_fetch_assoc($query_run))
						        {
						        	echo '<tr>';
										echo '<td>'.$query_row['c_ID'].'</td>';
										echo '<td>'.$query_row['comment'].'</td>';
										echo '<td>'.$query_row['Item_Name'].'</td>';
										echo '<td>'.$query_row['username'].'</td>';
										echo '<td>'.$query_row['c_date'].'</td>';
										echo "<td>
												<a href='comments.php?do=Edit&comid=".$query_row['c_ID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='comments.php?do=Delete&comid=".$query_row['c_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
												if($query_row['status']==0)
													{
														echo  "<a href='comments.php?do=Approve&comid=".$query_row['c_ID']. "' class='btn btn-info activate'><i class='fa fa-check'></i> Activate</a>";
													}


											  echo "</td>";



									echo '</tr>';
									 
								}

							
						

					?>
					

				</table>

			</div>
		</div>
		<?php
	}elseif($do=='Edit'){//Edit page 

         $comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			$query="SELECT * FROM `comments` WHERE `c_id`='$comid'";
			$query_run=mysql_query($query);
			$num_rows=mysql_num_rows($query_run);
			$result=mysql_fetch_array($query_run);

			if($num_rows>0){?> 

				<h1 class="text-center"> Edit Comment</h1>

				<div  class="container">
					
					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="hidden" name="comid" value="<?php echo $comid ?>" />
						<!-- Start comment-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable"> Comment</label>

							<div class="col-sm-10 col-md-6">
								
								<textarea type="text" name="comment" class="form-control" required="required"><?php echo $result['comment']?></textarea>
							</div>

						</div>
						<!-- End comment-->
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


		echo "<h1 class='text-center'> Update Comment</h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD']=='POST')
		{

			 $id=$_POST['comid'];
			 $comment=$_POST['comment'];

			 $form_error=array();

			if(empty($comment))
			{
				$form_error[]='<div class="alert alert-danger">Comment Field Can Not be<strong> Empty</strong> </div>';
			}

			foreach ($form_error as $error) {

				echo $error; 
			}

			if(empty($form_error))
			{
				$query="UPDATE `comments` SET `comment`='$comment' WHERE `c_ID`='$id' ";
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

		echo "<h1 class='text-center'> Delete Comment</h1>";
		echo "<div class='container'>";

		$comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
		

		$query="SELECT * FROM `comments`WHERE `c_ID`='$comid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="DELETE FROM `comments` WHERE `c_ID`='$comid'";

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
	
	} else if($do=='Approve'){
		//approve page

		echo "<h1 class='text-center'> Activate Comment</h1>";
		echo "<div class='container'>";

		$comid=isset($_GET['comid'])&& is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
		

		$query="SELECT * FROM `comments`WHERE `c_ID`='$comid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="UPDATE `comments` SET `status`=1 WHERE `c_ID`='$comid'";

					$query_run=mysql_query($query);
					$theMsg='<div class="alert alert-success">'.$num_rows.' Record Approve</div>';
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
