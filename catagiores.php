<?php 


$pagetitle= str_replace('-',' ' ,$_GET['pagename']);
include 'init.php';


?>
<div class="container">
	<h1 class="text-center"><?php echo str_replace('-',' ', $_GET['pagename'])?></h1>
	<div class="row">
	<?php

	$items=getItems('cat_ID',$_GET['pageid']);
	if(isset($items)){

		
		foreach ($items as $item) {
					echo "<div class='col col-sm-6 col-md-3'>";
						echo "<div class='thumbnail item-box'>";
							echo "<span class='item-price'>$".$item['price']."</span>";
							echo "<img class='img-responsive' src='man.png' alet='not found'/>";
							echo "<div class='caption'>";
								echo "<h3><a href='items.php?itemid=".$item['item_ID']."'>".$item['Name']."</a></h3>";
								echo "<p>".$item['description']."</p>";
								echo "<div class='date'>\"".$item['item_date']."\"</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				}


	}else
	{
		echo "No Items Exist";
	}
	?>
	</div>
</div>

<?php include $tpl.'footer.php';?>