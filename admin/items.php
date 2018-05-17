<?php
ob_start();

session_start();

$pagetitle='Items';

if(isset($_SESSION['username']))
{
	include 'init.php';

	$do=isset($_GET['do']) ? $_GET['do']:'Manage';

	if($do=='Manage'){


		$query="SELECT items.*,catagories.name AS Catagory_name,users.username 
				FROM items
				INNER JOIN catagories ON catagories.ID=items.cat_ID

				INNER JOIN users ON users.userID=items.member_ID ORDER BY `item_ID` DESC";

		$query_run=mysql_query($query);
		
		?>

		
		<h1 class="text-center">Manage Items</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>Name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Country</td>
						<td>Add Date</td>
						<td>Catagory</td>
						<td>Username</td>
						<td>Control</td>
					</tr>

					<?php
						


							 while($query_row=mysql_fetch_assoc($query_run))
						        {
						        	echo '<tr>';
										echo '<td>'.$query_row['item_ID'].'</td>';
										echo '<td>'.$query_row['Name'].'</td>';
										echo '<td>'.$query_row['description'].'</td>';
										echo '<td>'.$query_row['price'].'</td>';
										echo '<td>'.$query_row['country_made'].'</td>';
										echo '<td>'.$query_row['item_date'].'</td>';
										echo '<td>'.$query_row['Catagory_name'].'</td>';
										echo '<td>'.$query_row['username'].'</td>';
										echo "<td>
												<a href='items.php?do=Edit&itemid=".$query_row['item_ID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>

												<a href='items.php?do=Show_C&itemid=".$query_row['item_ID']."' class='btn btn-info'><i class='fa fa-edit'></i>Show Comments</a>

												<a href='items.php?do=Delete&itemid=".$query_row['item_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
												if($query_row['approve']==0)
													{
														echo  "<a href='items.php?do=Approve&itemid=".$query_row['item_ID']. "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
													}


											  echo "</td>";



									echo '</tr>';
									 
								}

							
						

					?>
					

				</table>

			</div>
			<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Items</a>
		</div>
		<?php

	}



	else  if ($do=='Add') {?>
		<h1 class="text-center">Add New Item</h1>
		<div class="container">
			<form class="form-horizontal" action="items.php?do=Insert" method="POST">
				<!--Start item name-->
					<div class="form-group form-group-lg">
						<label class="col col-sm-2 control-lable">Item Name</label>
						<div class="col col-sm-10 col-md-6">
						<input type="text" name="item_name" class="form-control" required="required" placeholder="Name of the item" />
						</div>
					</div>
			<!--end item name-->

			<!--start item description-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Description</label>
					<div class="col-md-6 col-sm-2">
						<input type="text" name="description" class="form-control" required="required" placeholder="Description of the item">
					</div>
				</div>
			<!--end item description-->
			<!--start item price-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Price</label>
					<div class="col-md-6 col-sm-2">
						<input type="text" name="price" class="form-control" required="required" placeholder="Price of the item">
					</div>
				</div>
			<!--end item price-->

			<!--start item country-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Country</label>
					<div class="col-md-6 col-sm-2">
						<input type="text" name="country" class="form-control" required="required" placeholder="Country of made">
					</div>
				</div>
			<!--end item country-->

			<!--start item status-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Status</label>
					<div class="col-md-6 col-sm-2">
						<select name="status" required="required">
							<option value="0">...</option>
							<option value="1">New</option>
							<option value="2">Like New</option>
							<option value="3">Used</option>
							<option value="4">Very Old</option>
						</select>
					</div>
				</div>

			<!--end item status-->

			<!--start item member-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Member</label>
					<div class="col-md-6 col-sm-2">
						<select name="member" required="required">
							<option value="0">...</option>
							<?php
								$query="SELECT * from `users`";
								$query_run=mysql_query($query);
								//$result=mysql_fetch_array($query_run);

								 while($row=mysql_fetch_assoc($query_run)){
								 	echo "<option value=".$row['userID'].">".$row['username']."</option>";

								 }
							?>
						</select>
					</div>
				</div>

			<!--end item member-->

			<!--start item catagory-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Catagory</label>
					<div class="col-md-6 col-sm-2">
						<select name="cat" required="required">
							<option value="0">...</option>
							<?php
								$query2="SELECT * FROM `catagories`";
								$query_run2=mysql_query($query2);
								//$result2=mysql_fetch_assoc($query_run2);

								 while($row2=mysql_fetch_assoc($query_run2)){
								 	echo "<option value=".$row2['ID'].">".$row2['name']."</option>";

								 }
							?>
						</select>
					</div>
				</div>

			<!--end item catagory-->


			<!-- Start btn add-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Item" class="btn btn-primary btn-lg">
							</div>
						</div>
			<!-- End btn add-->
			</form>
		</div>

		<?php


	}



elseif ($do=='Update') {


		echo "<h1 class='text-center'> Update Member</h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD']=='POST')
		{

			 $id=$_POST['itemid'];
			 $item_name=$_POST['item_name'];
			 $description=$_POST['description'];
			 $price=$_POST['price'];
			 $country=$_POST['country'];
			 $status=$_POST['status'];
			 $member=$_POST['member'];
			 $catagory=$_POST['cat'];


			 $form_error=array();

			
			if(empty($item_name))
			{
				$form_error[]='Name Can Not be<strong> Empty</strong>';
			}

			 if(empty($price))
			{
				$form_error[]='Price Can Not be <strong> Empty</strong>';
			}

			if(empty($country))
			{
				$form_error[]='Country Can Not be<strong> Empty</strong>';
			}
			
			if($status==0)
			{
				$form_error[]='PLZ choose the <strong>Status</strong>';
			}

			if($member==0)
			{
				$form_error[]='PLZ choose the <strong>Member</strong>';
			}

			if($catagory==0)
			{
				$form_error[]='PLZ choose the <strong>Catagory</strong>';
			}

			if(empty($form_error))
			{
				$query="UPDATE `items` SET `Name`='$item_name',`description`='$description',`price`='$price',`country_made`='$country',`status`='$status',`cat_ID`='$catagory',`member_ID`='$member' WHERE `item_ID`='$id'";
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

		echo "<h1 class='text-center'> Delete Item</h1>";
		echo "<div class='container'>";

		$itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
		

		$query="SELECT * FROM `items` WHERE `item_ID`='$itemid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="DELETE FROM `items` WHERE `item_ID`='$itemid'";

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
	
	}
	else if($do=='Edit'){

					//Edit page 

         $itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			$query="SELECT * FROM `items` WHERE `item_ID`='$itemid' LIMIT 1";
			$query_run=mysql_query($query);
			$num_rows=mysql_num_rows($query_run);
			$result=mysql_fetch_array($query_run);

			if($num_rows>0){?> 

				<h1 class="text-center"> Edit Item</h1>

				<div  class="container">
					
					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start item name-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable"> Item Name</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="item_name" class="form-control" value="<?php echo $result['Name']?>" autocomplete="off" required="required"/>
							</div>

						</div>
						<!-- End item name-->

						<!-- Start description-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable">Description</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="description" class="password form-control " autocomplete="off" placeholder="Leave Blank If You Don't Want To Change"/>

							</div>

						</div>
						<!-- End description-->

						<!-- Start price-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2  control-lable">Price</label>

							<div class="col-sm-10 col-md-6" >
								
								<input type="text" name="price"  class="form-control" value="<?php echo $result['price']?>"  required="required"/>
							</div>

						</div>
						<!-- End price-->

						<!-- Start start-->
						<div class="form-group form-group-lg">
							<label class="col col-sm-2 control-lable">Country</label>

							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="country" class="form-control" value="<?php echo $result['country_made']?>"  required="required"/>
							</div>

						</div>
						<!-- End country-->


			<!--start item status-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Status</label>
					<div class="col-md-6 col-sm-2">
						<select name="status" required="required">
							<option value="0">...</option>
							<option value="1" <?php if($result['status']==1){echo "selected";} ?> >New</option>
							<option value="2" <?php if($result['status']==2){echo "selected";} ?>>Like New</option>
							<option value="3" <?php if($result['status']==3){echo "selected";} ?>>Used</option>
							<option value="4" <?php if($result['status']==4){echo "selected";} ?>>Very Old</option>
						</select>
					</div>
				</div>

			<!--end item status-->

			<!--start item member-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Member</label>
					<div class="col-md-6 col-sm-2">
						<select name="member" required="required">
							<option value="0">...</option>
							<?php
								$query="SELECT * from `users`";
								$query_run=mysql_query($query);
								//$result=mysql_fetch_array($query_run);

								 while($row=mysql_fetch_assoc($query_run)){
								 	echo "<option value='".$row['userID']."'";

								 		if($result['member_ID']==$row['userID']){

								 			echo "selected";
								 		}

								 	echo">".$row['username']."</option>";

								 }
							?>
						</select>
					</div>
				</div>

			<!--end item member-->

			<!--start item catagory-->

				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-lable">Catagory</label>
					<div class="col-md-6 col-sm-2">
						<select name="cat" required="required">
							<option value="0">...</option>
							<?php
								$query2="SELECT * FROM `catagories`";
								$query_run2=mysql_query($query2);
								//$result2=mysql_fetch_assoc($query_run2);

								 while($row2=mysql_fetch_assoc($query_run2)){
								 	echo "<option value='".$row2['ID']."'";

								 		if($result['cat_ID']==$row2['ID']){echo "selected";}
								 	echo ">".$row2['name']."</option>";

								 }
							?>
						</select>
					</div>
				</div>

			<!--end item catagory-->

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
	
	}else if($do=='Insert'){

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			echo "<div class='container'>";

			echo "<h1 class='text-center'> Insert Item</h1>";
		

			 
			 $item_name=$_POST['item_name'];
			 $description=$_POST['description'];
			 $price=$_POST['price'];
			 $country=$_POST['country'];
			 $status=$_POST['status'];
			 $member=$_POST['member'];
			 $catagory=$_POST['cat'];

			 $form_error=array();

			
			if(empty($item_name))
			{
				$form_error[]='Name Can Not be<strong> Empty</strong>';
			}

			 if(empty($price))
			{
				$form_error[]='Price Can Not be <strong> Empty</strong>';
			}

			if(empty($country))
			{
				$form_error[]='Country Can Not be<strong> Empty</strong>';
			}
			
			if($status==0)
			{
				$form_error[]='PLZ choose the <strong>Status</strong>';
			}

			if($member==0)
			{
				$form_error[]='PLZ choose the <strong>Member</strong>';
			}

			if($catagory==0)
			{
				$form_error[]='PLZ choose the <strong>Catagory</strong>';
			}

			foreach ($form_error as $error) {

				$theMsg = '<div class="alert alert-danger">'. $error.'</div>'; 
				redirecthome($theMsg,'back');
			}

			if(empty($form_error))
			{
				$query="SELECT `name` FROM `items` WHERE `name`='$item_name'";
				if($query_run=mysql_query($query)){
					$num_row=mysql_num_rows($query_run);

					 
							//insert user information into databases
							$query="INSERT INTO `items`(`Name`, `description`, `price`, `country_made`, `status`,`item_date`,`member_ID`,`cat_ID`) VALUES ('$item_name','$description','$price','$country','$status',now(),'$member','$catagory')";
							
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
		}else
		{
			echo '<div class="container">';
			$theMsg= '<div class="alert alert-danger"> You Can not Browse This Page Directly</div>';
			redirecthome($theMsg);
			echo '</div>';
		}
		echo '</div>';

	}else if($do=='Approve'){
		//activate page

		echo "<h1 class='text-center'> Approve Items</h1>";
		echo "<div class='container'>";

		$itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
		

		$query="SELECT * FROM `items`WHERE `item_ID`='$itemid'";

		  if($query_run=mysql_query($query))
	      {
	      	$num_rows=mysql_num_rows($query_run);
	      	$result=mysql_fetch_array($query_run);

	      	

	      	if($num_rows>0)
	      	{
				
					$query="UPDATE `items` SET `approve`=1 WHERE `item_ID`='$itemid'";

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
	}else if($do=='Show_C')
	{
		$itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0 ;

		
			$query="SELECT comments.* ,users.username FROM comments
					INNER JOIN users ON users.userID=comments.user_id
					WHERE comments.item_id='$itemid'";

		$query_run=mysql_query($query);
		

		?>

		
		<h1 class="text-center">Items Comment</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="main-table text-center table table-bordered">
					<tr>
						<td>Comment</td>
						<td>User Name</td>
						<td>Add Date</td>
						<td>Control</td>
					</tr>

					<?php
						


							 while($query_row=mysql_fetch_assoc($query_run))
						        {
						        	echo '<tr>';
										
										echo '<td>'.$query_row['comment'].'</td>';
										
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

	}


  include $tpl.'footer.php';

}
else
{
	header('location: index.php');
	exit();
}

?>