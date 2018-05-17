<?php
ob_start();//start oytput buffring
session_start();

if(isset($_SESSION['username']))
{
	$pagetitle='Dashbord';
	include 'init.php';

     $numlatestusers=6;
	$latestuser=checkLatest('*','users','userID',$numlatestusers);// use in panel to get the last registerd users

	$numlatestitems=6;
	$latestitems=checkLatest('*','items','item_ID',$numlatestitems);

?>
	<!--start dashbord page-->	

	<div class="container home-stats text-center">
		<h1 >Dashbord</h1>
		<div class="row">
			<div class="col col-md-3">
				<div class="stat st-members">
					<i class="fa fa-users"></i>
					<div class="info">
						Total Members
						<span> <a href="members.php"><?php echo countItems('userID','users');?></a></span>
					</div>
				</div>
			</div>
			<div class="col col-md-3">
				<div class="stat st-pending">
					<i class="fa fa-user-plus"></i>
					<div class="info">
						Pending Members 
						<span> <a href="members.php?do=Manage&page=Pending"><?php echo check_item('Regstatus','users',0)?></a></span>
					</div>
				</div>
			</div>
			<div class="col col-md-3">
					
				<div class="stat st-items">
					<i class="fa fa-tag"></i>
						<div class="info">
						Total Items
						<span><a href="items.php"><?php echo countItems('item_ID','items');?></a></span>
					</div>
			    </div>
			</div>
			<div class="col col-md-3">
				<div class="stat st-comments">
					<i class="fa fa-comments"></i>
					<div class="info">
						Total Comments
					<span><a href="comments.php"><?php echo countItems('c_ID','comments');?></a></span>
					</div>
				</div>
			</div>
		</div>

	</div>


	<div class="latest">
		<div class="container ">
			<div class="row">
				<div class="col col-sm-6">
					<div class="panel panel-default">
						

						<div class="panel-heading">
							<i class="fa fa-users"></i>
							Latest <?php echo $numlatestusers ?> Registerd Users
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled list-users">
							<?php

								foreach($latestuser as $user)
								{
									echo '<li>' .$user['username'].'<a href="members.php?do=Edit&userid='.$user['userID'].'">';
											echo '<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit';
											if($user['Regstatus']==0)
													{
														echo  "<a href='members.php?do=Activate&userid=".$user['userID']. "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Activate</a>";
													}
											echo'</span>'; 

										echo'</a>';

									echo '</li>';

								}
							?>
							</ul>

						</div>
					</div>
				</div>
				<div class="col col-sm-6">
					<div class="panel panel-default">

						<div class="panel-heading">
							<i class="fa fa-tag"></i>
							Latest <?php echo $numlatestitems ?> Items
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled list-users">
						<?php

								foreach($latestitems as $items)
								{
									echo '<li>' .$items['Name'].'<a href="items.php?do=Edit&itemid='.$items['item_ID'].'">';
											echo '<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit';
											if($items['approve']==0)
													{
														echo  "<a href='items.php?do=approve
														&itemid=".$items['item_ID']. "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Approve</a>";
													}
											echo'</span>'; 

										echo'</a>';

									echo '</li>';

								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col col-sm-6">
					<div class="panel panel-default">
						

						<div class="panel-heading">
							<i class="fa fa-comments-o"></i>
							Latest Comments
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled list-users">
								<?php
								$query="SELECT comments.* ,users.username,items.Name AS Item_Name FROM comments
								INNER JOIN users ON users.userID=comments.user_id
								INNER JOIN items ON items.item_ID=comments.item_id ORDER BY c_ID DESC";
								$query_run=mysql_query($query);
								

								while ($result=mysql_fetch_array($query_run)) {
									
									echo "<div class='comment-box'>";

										echo "<span class='member_n'>". $result['username']."</span>";
										echo "<p class='member_c'>". $result['comment']."</p>";

									echo "</div>";
								}
								?>
							</ul>

						</div>
					</div>
				</div>
				
			</div>

		</div>
	</div>
	<!--end dashbord page-->	

<?php
	
    include $tpl.'footer.php';

}
else
{
	header('location: index.php');
	exit();
}
ob_end_flush();
?>