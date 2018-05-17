<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo getTitle();?></title>

	
	<link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css"/>
	<link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css"/>
	<link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css"/>
	<link rel="stylesheet" href="<?php echo $css;?>front.css"/>
</head>
<body>
	<div class="upper-bar">
		<div class="container">

			<?php
			 if(isset($_SESSION['user'])){?>

			 <span class="upper-brand"><?php  echo $_SESSION['user'];?></span>
			 	
			 	<div class="my-info btn btn-default btn-group pull-right">
			 		<span class="btn dropdown-toggle" data-toggle='dropdown'>
					 		<?php  echo $_SESSION['user'];?>
					 		<span class="caret"></span>
				 		</span>
				 		<ul class="dropdown-menu">
				 			<li><a href='profile.php'>My Profile</a></li>
				 			<li><a href='newad.php'>New Ad</a></li>
				 			<li><a href='profile.php#my-ads'>My items</a></li>
				 			<li><a href='logout.php'>Log out</a></li>
				 		</ul>
			 		
			 	</div>
			 	<img class="upper-image pull-right img-thumbnail img-circle" src="man.png">


			 <?php

			 

			 	$userstatus=ckeckuserstatus($_SESSION['user']);
			 	if($userstatus >0)
			 	{
			 		//user not active
			 	}

				?>
			 	
				<?php
			 }else{
			 	?>
				<a href='login.php'>
					<span class='pull-right lsup'>Log in/sign up</span>
				</a>

			 <?php }?>
		</div>
	</div>

	<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>

   
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
      	<?php
			 $cat=getCat();
			foreach ($cat as $value) {
				echo'<li> <a href="catagiores.php?pageid='.$value['ID'] .'&pagename='.str_replace(' ','-',$value['name']).   '"> '. $value['name'].'</a></li>';
			}
			
			?>

            
          </ul>
        </li>
      </ul> 
    </div>
  </div>
</nav>

