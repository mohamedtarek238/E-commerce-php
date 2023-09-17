<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title><?php gettitle(); ?></title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet"  href="<?php echo $css ?>style.css">
	</head>
	<body>	
			</div>
		</div>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <div class="prof pull-left">
		      <?php 
				if (isset($_SESSION['user'])) { ?>
					<div class="prof">
				<img class="my-image img-thumbnail img-circle" src="download.png" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">

						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="profile.php">My Profile</a></li>
						<li><a href="newad.php">New Item</a></li>
						<li><a href="#">My Items</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
				</div>
				<?php } 
				  
				if (!isset($_SESSION['user'])) { ?>
				<div class="lolin" > 
					<a href="login.php">Login</a>	  
				</div> 
			<?php } ?>
			</div>
		      <a class="homem navbar-brand" href="index.php">HomePage</a>
		    </div>
		    <div class="collapse navbar-collapse" id="app-nav">
		      <ul class="nav navbar-nav navbar-right">
		       <?php
		       foreach(getCat() as $cat) {
		       	echo 
		       	'<li>
					<a href="categories.php?pageid=' . $cat['ID'] . '">
						' . $cat['Name'] . '
					</a>
				</li>';
		       }

		       ?>
		      </ul>
		    </div>
		  </div>
		</nav>