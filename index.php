<?php
session_start();

$pagetitle="Home page";


	include 'init.php';

	$query="SELECT items.* FROM `items` 
	INNER JOIN `users` ON users.userID=items.member_ID
	INNER JOIN `catagories` ON catagories.ID=items.cat_ID 
	WHERE `approve`=1
	ORDER BY `item_ID` DESC ";
	if ($query_run=mysql_query($query)) {

		


		?>

		<div class='container'>
				<div class="row">
					<?php while ($result=mysql_fetch_array($query_run)) {?>
					<div class="col col-sm-3 ">
						<div class="img-responsive thumbnail info-main">
							<span class="item-price">$<?php echo $result['price'] ?></span>
							<img class="img-responsive" src="man.png">
							 <a href='items.php?itemid=<?php echo $result['item_ID'] ?>'><h3><?php echo $result['Name'] ?></h3></a>
							<p><?php echo $result['description'] ?></p>
							<div class='date'>"<?php echo $result['item_date'] ?>"</div>
						</div>
				</div>
	<?php } ?>

		</div>
	</div>

	<?php
	}

	include $tpl.'footer.php';

?>
