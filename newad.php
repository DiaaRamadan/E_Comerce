<?php

session_start();

$pagetitle="New Ad";

include 'init.php';

if(isset($_SESSION['user'])&&isset($_SESSION['uid'])){

	$useraddid=$_SESSION['uid'];

	$query="SELECT * FROM `users` WHERE `username`='$sessionuser'";

	$query_run=mysql_query($query);

	$info=mysql_fetch_array($query_run);

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$formError=array();

		$name=filter_var($_POST['ad-name'],FILTER_SANITIZE_STRING);
		$desc=filter_var($_POST['ad-descr'],FILTER_SANITIZE_STRING);
		$price=filter_var($_POST['ad-price'],FILTER_SANITIZE_NUMBER_INT);
		$status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
		$country=filter_var($_POST['ad-country'],FILTER_SANITIZE_STRING);
		$catagory=filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
		
		if(strlen($name)<4){
			$formError[]= "Your name must be at least than 4 char";
		}

		if(strlen($country) <2){
			$formError[]="Your name must be at least than 3 char";
		}

		if(strlen($desc) <10){
			$formError[]="Your Description must be at least than 10 char";
		}

		if(empty($price)){
			$formError[]="Your name must choose the price";
		}

		if(empty($status)){
			$formError[]="Your name must choose the status";
		}

		if(empty($catagory)){
			$formError[]="Your name must choose the catagory";
		}

		if(empty($formError)){

		$query="INSERT INTO `items`(`Name`, `description`, `price`, `item_date`, `country_made`, `status`,`cat_ID`, `member_ID`) VALUES ('$name','$desc','$price',now(),'$country','$status','$catagory','$useraddid')";

		if($query_run=mysql_query($query)){
			echo "<div class='alert alert-success container'>Item added</div>";
		}
	}

	}




?>

<h1 class="text-center">Add new Ad</h1>

<div class="ad-information ">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Ad</div>
			<div class="panel-body">
				<div class="row">
					<div class="col col-md-8">
						<form class="ads-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col col-md-3">Name: </label>
								<div class="col-sm-10 col-md-9">
									<input 
									type="text" 
									name="ad-name"  
									class="form-control live-name" 
									required="required" 
									placeholder="Name of the item" />
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label class="col-sm-2 col col-md-3">Description: </label>
								<div class="col-sm-10 col-md-9">
									<input 
									type="text" 
									name="ad-descr"  
									class="form-control live-desc" 
									required="required" 
									placeholder="Description of the item" />
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label class="col-sm-2 col col-md-3">Price: </label>
								<div class="col-sm-10 col-md-9">
									<input 
									type="text" 
									name="ad-price"  
									class="form-control live-price" 
									required="required" 
									placeholder="Price of the item" />
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label class="col-sm-2 col col-md-3">Country: </label>
								<div class="col-sm-10 col-md-9">
									<input 
									type="text" 
									name="ad-country"  
									class="form-control" 
									required="required" 
									placeholder="Country of the item made" />
								</div>
							</div>
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col col-md-3 control-lable">Status</label>
								<div class="col-md-9 col-sm-10">
									<select name="status" required="required">
										<option value="0">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>

							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-md-3 control-lable">Catagory</label>
								<div class="col-md-9 col-sm-10">
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

					<div class="form-group form-group-lg">
							<div class="col-sm-offset-3 col-sm-10">
								<input type="submit" value="Add Item" class="btn btn-primary btn-lg">
							</div>
						</div>

						</form>
					</div>
					<div class="col col-md-4">
								<div class='thumbnail item-box live-preview'>
									<span class='item-price'>$0</span>
									<img class='img-responsive' src='man2.png' alet='not found'/>
									<div class='caption'>
										<h3>Ad Name</h3>
										<p>Ad Description</p>
								   </div>
							</div>
						
					</div>
				</div>
				<?php
					if(!empty($formError)){
						foreach ($formError as  $error) {
							echo "<div class='alert alert-danger'>".$error."</div>";
						}
					}

				?>
			</div>
		</div>
	</div>
</div>



<?php

	}else{
		header('location:login.php');
	}
include $tpl.'footer.php';

?>
