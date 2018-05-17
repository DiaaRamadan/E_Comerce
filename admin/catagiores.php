<?php
/*catagorie page*/

ob_start();
session_start();

$pagetitle='Catagories';

if(isset($_SESSION['username']))
{
	
	include 'init.php';


	$do=isset($_GET['do']) ? $_GET['do'] :'Manage';

	if($do=='Manage'){//manage page

		$sort='ASC';

		$sort_array=array('ASC','DESC');

		if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

			$sort=$_GET['sort'];
		}
		
		$query="SELECT * FROM `catagories` ORDER BY `ordering` $sort";
		$query_run=mysql_query($query);
		
			
		?>

			<div class="container catagories">
				<h1 class="text-center">Manage Catagories</h1>
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i>Manage Catagories
						<div class="options pull-right">
							<i class="fa fa-sort"></i> Ordering By:[ 
							<a href="?sort=ASC" class='<?php if($_GET['sort']=='ASC'){echo 'active';} ?>'>ASC</a> |
							<a href="?sort=DESC" class='<?php if($_GET['sort']=='DESC'){echo 'active';} ?>' >DESC</a> ]

							<i class="fa fa-eye"></i>View:
							[ 
							<span class="active" data-view='full'>Full</span> | 
							<span>Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php
							while ($result=mysql_fetch_array($query_run)) {
								echo "<div class='cat'>";
									echo "<div class='hidden-btn'>";
										echo "<a href='catagiores.php?do=Edit&catid=".$result['ID']."' class='btn btn-sm btn-primary '><i class='fa fa-edit'></i>Edit</a>";
										echo "<a href='catagiores.php?do=Delete&catid=".$result['ID']."' class='confirm btn btn-sm btn-danger '><i class='fa fa-close'></i>Delete</a>";
									echo '</div>';
									echo '<h3>'. $result['name'].'</h3>';
									echo "<div class='full-view'>";
										echo '<p>';if($result['description']==''){echo"This Catagory has no description";}else{echo $result['description'];}echo'</p>';
										if($result['visiabality']==1){echo'<span class="visb"> <i class="fa fa-eye"></i> Hidden</span>';}
										if($result['allow_comment']==1){echo'<span class="comment"> <i class="fa fa-close"></i> Comment Disabled</span>';}
										if($result['allow_ads']==1){echo'<span class="ads"> <i class="fa fa-close"></i> Ads Disabled</span>';}
									echo "</div>";
								echo "</div>";
								echo "<hr>";
							}
						?>
					</div>
				</div>

				<a href="catagiores.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Catagory</a>
			</div>

		<?php


	}else if($do=='Add'){ //add catagory?>
		<h1 class="text-center">Add New Catagorie</h1>

	<div class="container">
		
		<form class="form-horizontal" action="catagiores.php?do=Insert" method="POST">

			<!--Start name-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Name</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="name" class="form-control" autocomplete="off" required="required"  placeholder="Add New Catagory" />
				</div>
			</div>
			<!--end name-->

			<!--Start description-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Description</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="description" class="form-control" placeholder="catagory Discription" />
				</div>
			</div>
			<!--end description-->

			<!--Start ordering-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Ordering</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="ordering" class="form-control"  placeholder="Number For Arrange The catagories" />
				</div>
			</div>
			<!--end ordering-->

			<!--Start visible field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Visible</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="vis-yes" type="radio" name="visible" value="0" checked />
				 		<label for="vis-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="vis-no" type="radio" name="visible" value="1"/>
				 		<label for="vis-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end visible field-->

			<!--Start comment field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Allow Commenting</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="com-yes" type="radio" name="commenting" value="0" checked />
				 		<label for="com-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="com-no" type="radio" name="commenting" value="1"/>
				 		<label for="com-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end comment field-->

			<!--Start Ads field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Allow Ads</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="ads-yes" type="radio" name="ads" value="0" checked />
				 		<label for="ads-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="ads-no" type="radio" name="ads" value="1"/>
				 		<label for="ads-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end Ads field-->

			<!-- Start btn add-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Catagory" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!-- End btn add-->

		</form>

	</div>


		<?php
}else if($do=='Edit'){

	$catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):0;

	$query="SELECT * FROM `catagories` WHERE `ID`='$catid' ";

	if($query_run=mysql_query($query))
	{
		$rows=mysql_num_rows($query_run);
		$result=mysql_fetch_array($query_run);
		if($rows>0)

		{?>
		<h1 class="text-center">Edit Catagorie</h1>

	<div class="container">
		
		<form class="form-horizontal" action="catagiores.php?do=Update" method="POST">
			<input type="Hidden" name="catid" value="<?php echo $catid;?>">
			<!--Start name-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Name</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="name" class="form-control"  required="required"  value="<?php echo $result['name']?>" " />
				</div>
			</div>
			<!--end name-->

			<!--Start description-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Description</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="description" class="form-control" value="<?php echo $result['description']?>" />
				</div>
			</div>
			<!--end description-->

			<!--Start ordering-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Ordering</label>
				<div class="col col-sm-10 col-md-6">
				<input type="text" name="ordering" class="form-control"  value="<?php echo $result['ordering']?>" />
				</div>
			</div>
			<!--end ordering-->

			<!--Start visible field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Visible</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="vis-yes" type="radio" name="visible" value="0" <?php if($result['visiabality']==0){echo 'checked';}?>/>
				 		<label for="vis-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="vis-no" type="radio" name="visible" value="1" <?php if($result['visiabality']==1){echo 'checked';}?>
				 		>
				 		<label for="vis-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end visible field-->

			<!--Start comment field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Allow Commenting</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="com-yes" type="radio" name="commenting" value="0"  <?php if($result['allow_comment']==0){echo 'checked';}?>>
				 		<label for="com-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="com-no" type="radio" name="commenting" value="1" <?php if($result['allow_comment']==1){echo 'checked';}?>>
				 		<label for="com-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end comment field-->

			<!--Start Ads field-->
			<div class="form-group form-group-lg">
				<label class="col col-sm-2 control-lable">Allow Ads</label>
				<div class="col col-sm-10 col-md-6">
				 	<div>
				 		<input id="ads-yes" type="radio" name="ads" value="0" <?php if($result['allow_ads']==0){echo 'checked';}?>  />
				 		<label for="ads-yes">Yes</label>
				 	</div>

				 	<div>
				 		<input id="ads-no" type="radio" name="ads" value="1" <?php if($result['allow_ads']==1){echo 'checked';}?>/>
				 		<label for="ads-no">No</label>
				 	</div>
				</div>
			</div>
			<!--end Ads field-->

			<!-- Start btn add-->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg">
							</div>
						</div>
						<!-- End btn add-->

		</form>

	</div>


		<?php

			
		}else{
			echo "This ID not Exist";
		}
	}

}else if ($do=='Delete') {

	echo "<h1 class='text-center'>Delete Catagory</h1>";
	echo "<div class='container'>";

		$catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):0;

		$query="SELECT * FROM `catagories` WHERE `ID`='$catid' ";
		if($query_run=mysql_query($query))
		{
			$result=mysql_num_rows($query_run);
			if($result>0)
			{
				$query="DELETE FROM `catagories` WHERE `ID`='$catid'";
				$query_run=mysql_query($query);
				$theMsg='<div class="alert alert-success">'.$result.' Row deleted</div>';
				redirecthome($theMsg,'back');
			}else
			{
				$theMsg= "<div class='alert alert-danger'>This ID Not Found</div>";

				redirecthome($theMsg);
			}
		}
	echo "</div>";
}

elseif ($do=='Update') {


		echo "<h1 class='text-center'> Update Catagory</h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD']=='POST')
		{

			 $id=$_POST['catid'];
			 $name=$_POST['name'];
			 $description=$_POST['description'];
			 $ordering=$_POST['ordering'];
			 $visible=$_POST['visible'];
			 $allow_comment=$_POST['commenting'];
			 $allow_ads=$_POST['ads'];
			 $form_error=array();

				$query="UPDATE `catagories` SET `name`='$name',`description`='$description',`ordering`='$ordering',`visiabality`='$visible' ,`allow_comment`='$allow_comment',`allow_ads`='$allow_ads'  WHERE `ID`='$id' ";
				if($query_run=mysql_query($query))
				{

					
					$theMsg= '<div class="alert alert-success">1 Record Updated </div>'; 
					redirecthome($theMsg,'back');
				}else
				{
					$theMsg= '<div class="alert alert-success">0 Record Updated </div>';
					redirecthome($theMsg,'back');

				}
		
		}else
		{
			$errormsg='<div class="alert alert-danger">You Can Browse This Page Directly</div>';
			redirecthome($errormsg,'back');
		}
		echo '</div>';

	}


elseif ($do=='Insert') {



		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			echo "<div class='container'>";

			echo "<h1 class='text-center'> Update Catagory</h1>";
		

			 
			 $name=$_POST['name'];
			 $descr=$_POST['description'];
			 $ordering=$_POST['ordering'];
			 $comment=$_POST['commenting'];
			 $visible=$_POST['visible'];
			 $ads=$_POST['ads'];

			 

			

			 $form_error=array();

			 if(strlen($name)<4)
			 {
			 	$form_error[]='Name Can Not be Less Then<strong> 4 Characters</strong>  ';
			 }

			if(empty($name))
			{
				$form_error[]=' Name Can Not be<strong> Empty</strong>';
			}

			 if(strlen($name)>20)
			 {
			 	$form_error[]='Name Can Not be More Then <strong>20 Characters</strong> ';
			 }


			foreach ($form_error as $error) {

				$theMsg = '<div class="alert alert-danger">'. $error.'</div>'; 
				redirecthome($theMsg,'back');
			}

			if(empty($form_error))
			{
				$query="SELECT `name` FROM `catagories` WHERE `name`='$name'";
				if($query_run=mysql_query($query)){
					$num_row=mysql_num_rows($query_run);

					 if($num_row==1)
					 {
					 	$theMsg= "<div class='alert alert-danger'>Sorry This User Exist</div>";
					 	redirecthome($theMsg,'back');
					 }else{
							//insert catagory information into databases
							$query="INSERT INTO `catagories`(`name`, `description`,  `ordering`, `visiabality`, `allow_comment`, `allow_ads`) VALUES ('$name',' $descr','$ordering','$visible','$comment','ads')";
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



		 include $tpl.'footer.php';

}
else
{
	header('location: index.php');
	exit();
}
?>