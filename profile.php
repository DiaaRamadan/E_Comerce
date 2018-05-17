<?php

session_start();

$pagetitle="Profile";

include 'init.php';

if(isset($_SESSION['user'])){

	$query="SELECT * FROM `users` WHERE `username`='$sessionuser'";

	$query_run=mysql_query($query);

	$info=mysql_fetch_array($query_run);



?>

<h1 class="text-center">My Profile</h1>

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li><i class="fa fa-unlock-alt fa-fw"></i> 
						<span>Login Name:</span> <?php echo $info['username']; ?> 
					</li>

					<li>
					 <i class="fa fa-envelope-o"></i> 
						<span> Email:</span> <?php echo $info['Email']; ?>
					</li>

					<li> 
						<i class="fa fa-users"></i>
						<span> Full Name:</span> <?php echo $info['FullName']; ?>
					</li>
					<li> 
						<i class="fa fa-calendar"></i>
						<span>Register Date:</span><?php echo $info['Date'] ;?>
					</li>

					<li> 
						<i class="fa fa-tags"></i>
						<span>Favourite Catagory:</span> 
					</li>
				</ul>
				<div class="btn btn-default edit-user"><a href='#'> Edit Information </a></div>
			</div>
		</div>
	</div>
</div>

<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Ads</div>
			<div class="panel-body">
				<?php

			$items=getItems('member_ID',$info['userID'],1);
			if(isset($items)){

				
				foreach ($items as $item) {
					
						echo "<div class='col col-sm-6 col-md-3'>";
							echo "<div class='thumbnail item-box'>";
							if($item['approve']==0){echo "<span class='item_waiting'> Waiting Approval </span>" ;}
								echo "<span class='item-price'>$".$item['price']."</span>";
								echo "<img class='img-responsive' src='man.png' alet='not found'/>";
								echo "<div class='caption'>";
									echo "<a href='items.php?itemid=".$item['item_ID']."'><h3>".$item['Name']."</h3></a>";
									echo "<p>".$item['description']."</p>";
									echo "<div class='date'>\"".$item['item_date']."\"</div>";

								echo "</div>";
							echo "</div>";
						echo "</div>";
				}

	}else
	{
		echo "No Items Exist create <a href='newad.php'>New Ad</a>";
	}
	?>
			</div>
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Leatest comments</div>
			<div class="panel-body">
				<?php 
				$comments=getusercomment('user_id',$info['userID']);
				if(!empty($comments)){

					foreach ($comments as $comment) {
						echo $comment['comment'] .'<br>';
					}
				}else{
					echo "There is no comments";
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
