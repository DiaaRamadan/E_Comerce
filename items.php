<?php
ob_start();

session_start();
$pagetitle='Show item';

include 'init.php';

$itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

$query="SELECT items.*,catagories.name ,users.username 
		FROM `items` 
		INNER JOIN catagories
		ON items.cat_ID=catagories.ID
		INNER JOIN users
		ON users.userID=items.member_ID
		WHERE `item_ID`='$itemid' AND `approve`=1";

  $query_run=mysql_query($query);
  $num_rows=mysql_num_rows($query_run);
  $result=mysql_fetch_array($query_run);

  if($num_rows>0){
  	

?>
<h1 class="text-center"><?php 	echo $result['Name']; ?></h1>
<div class="container infos">
	<div class="row">
		<div class="col col-md-3 ">
			<img src="man.png" class="img-responsive img-thumbnail center-block">
		</div>
		<div class="col col-md-9">
			<h2><?php echo $result['Name']; ?></h2>
			<p class="item-infos-par"><?php echo $result['description']; ?></p>
			<div class="item-infos"><i class="fa fa-money"></i> Price: <?php echo $result['price']; ?></div>
			<div class="item-infos"><i class="fa fa-calendar"></i> Add date: <?php echo $result['item_date']; ?></div>
			<div class="item-infos"><i class="fa fa-building"></i> Made in: <?php echo $result['country_made']; ?></div>
			<div class="item-infos"><i class="fa fa-tag"></i> Catagories: <a href="catagiores.php?pageid=10&pagename=Hand-made"><?php echo $result['name']; ?></a></div>
			<div class="item-infos"><i class="fa fa-user"></i> Added By: <a href="#"><?php echo $result['username']; ?></a> </div>

		</div>
	</div>
	<hr class="custom-hr">
	<?php if(isset($_SESSION['uid'])){?>
	<div class="row">
		<div class="col-md-offset-3">
			<div class="add-comment">
				<h3>Add Your Comment</h3>
				<form class="form-group" action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$result['item_ID'] ?>" method="POST">
					<textarea name="comment" required></textarea>
					<input type="submit" class="btn btn-primary" value="Add comment">
				</form>

				<?php

					if($_SERVER['REQUEST_METHOD']=='POST'){

						if(!empty($_POST['comment'])){

							$comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
							$item_comment=$result['item_ID'];
							$user_comment=$_SESSION['uid'];

							$query="INSERT INTO `comments`(`comment`, `status`, `c_date`, `item_id`, `user_id`)VALUES('$comment',0,now(),'$item_comment','$user_comment')";
							if($query_run=mysql_query($query)){
								
								echo "<div class='alert alert-success'>Comment Added</div>";
							}
						}else{
							echo "<div class='alert alert-danger'>Comment field should not be empty</div>";
						}
					}

				?>
			</div>
		</div>
		<?php }else{

			echo "<a href='login.php'>Log in</a> or <a href='login.php'>Register </a> to add comment";
		} ?>
	</div>
	<hr class="custom-hr">
	<?php

		$query="SELECT comments.* ,users.username FROM `comments` INNER JOIN `users` ON comments.user_id=users.userID
		WHERE `status`=1 AND `item_id`=".addslashes($result['item_ID'])."";
			$query_run=mysql_query($query);
			
			
	?>
	<?php
	while ($information=mysql_fetch_array($query_run)) {?>
	<div class="comment-box">
		<div class="row">
			<div class="col col-sm-2 text-center">
				<img src="man.png" class="img-responsive img-thumbnail img-circle">

				<?php echo $information['username']; ?>

			</div>

			<div class="col col-sm-10 comment-text ">
				<p class="lead"></p>
				<?php echo $information['comment']; ?>
			</div>
		</div>
	</div>
	<hr class="custom-hr">
	<?php } ?>
</div>

<?php
	}else{
		echo '<div class="container alert alert-danger">There\'s no such ID or this item waiting for Approval</div>';
	}
include $tpl.'footer.php';

ob_end_flush();

?> 