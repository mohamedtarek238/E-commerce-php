<?php
	session_start();
	$noNavbar 	= '';
	$pageTitle 	= 'Login'; 

	if (isset($_SESSION['Username'])) {

		header('Location: dashboard.php');	
	}
	include 'init.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$username = $_POST['User'];	
		$password = $_POST['Password'];
		$hashpass = sha1($password);

		$stmt = $con->prepare("SELECT 
									UserD, Username, Password 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									Password = ? 
								AND 
									GroupID = 1
								LIMIT 1");
		$stmt->execute(array($username, $hashpass));
		$row = $stmt->fetch();
		$count=$stmt->rowCount();

		if($count > 0) {

			$_SESSION['Username'] = $username;
			$_SESSION['ID'] = $row['UserD'];
			header('Location: dashboard.php');
			exit();
		}
	}
	
?>
	<form class="Login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
		<h1 class="text-center">Login Page</h1>
		<input class="form-control input-lg" onfocus="this.placeholder = '';" onblur="this.placeholder = 'Username';" type="index" name="User" placeholder="UserName" autocomplete="off"/>
		<input class="form-control input-lg" onfocus="this.placeholder = '';" onblur="this.placeholder = 'Password';" type="index" name="Password" placeholder="Password" autocomplete="off"/>
		<input class="btn  btn-primary btn-block" type="submit" value="Continue">
	</form>
	

<?php
	include $tp1 . 'footer.php';
?>