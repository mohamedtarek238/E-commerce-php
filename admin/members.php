<?php 
session_start(); 
	
	$pageTitle = 'Members';

	if(isset($_SESSION['Username'])) {

		
		include 'init.php';
		include $tp1 . 'header.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') { 

			$query = ' ';

			if (isset($_GET['page']) && $_GET['page'] == 'pending') {

				$query = 'AND RegStatus=0';

			}

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query" );
			$stmt-> execute();

			$rows = $stmt->fetchAll();
			?>
		<h1 class="text-center">Manage Member</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>UserName</td>
								<td>Email</td>
								<td>Full Name</td>
								<td>Registard Date</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['UserD'] . "</td>";
										echo "<td>" . $row['UserName'] . "</td>";
										echo "<td>" . $row['Email'] . "</td>";
										echo "<td>" . $row['FullName'] . "</td>";
										echo "<td>" . $row['Dateandtime'] . "</td>";
										echo "<td>
												<a href='Members.php?do=Edit&userid=" . $row['UserD'] . "'' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
												<a href='Members.php?do=Delete&userid=" . $row['UserD'] . "' class='btn btn-danger confirm '><i class='fa fa-close'></i>Delete </a>";
												if ($row['RegStatus'] ==0) {
													echo "<a href='Members.php?do=activate&userid=" . $row['UserD'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Activate </a>";
												}
											echo "</td>";
									echo "</tr>";
								}
							?>
							
						</table>
				</div>
				<a href="Members.php?do=add" class="btn btn-primary" > <i class="fa fa-plus"></i> New Member</a>
			</div>
		<?php } elseif ($do == 'add') { ?> 

				<h1 class="text-center">Add New Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="UserName" onfocus="this.placeholder = ''" onblur="this.placeholder='UserName'"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-sm-6">
								<input type="password" name="password" class="password form-control" required="required" placeholder = 'Password Must Be Hard & Complex' onfocus="this.placeholder = ''" onblur="this.placeholder='Password Must Be Hard & Complex'" />
								<i class="show-pass fa fa-eye fa-2x"></i>

							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-sm-6"> 
								<input type="Email" name="email" class="form-control" autocomplete="off" required="required" placeholder="name@example.com" onfocus="this.placeholder = ''" onblur="this.placeholder='name@example.com'" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" name="full" class="form-control" autocomplete="off" required="required" placeholder="Full Name" onfocus="this.placeholder = ''" onblur="this.placeholder='Full Name'" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-sm-6">
								<input type="submit" value="register" class="btn btn-primary btn-lg" />
							</div>
						</div>
					</form>
				</div>
		<?php 

		} elseif ($do == 'Insert') { 
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h1 class='text-center'> Insert Member</h1>";
			echo "<div class='container'>";
					
					$user 		=	$_POST['username'];
					$pass 		=	$_POST['password'];
					$email 		=	$_POST['email'];
					$name 		=	$_POST['full'];

					$hashpass 	=	sha1($_POST['password']);

					$formerrors = array();

					if (strlen($user)<5) { 
						$formerrors[] = ' new username should be <strong> more than 5 char</strong>';
					}

					if (strlen($user)>20) { 
						$formerrors[] = 'new username cant be <strong> more than 20 char</strong>';
					}

					if (empty($pass)) { 
						$formerrors[] = 'you should write <strong>Strong password</strong>';
					}

					if (empty($email)) { 
						$formerrors[] = 'you should write <strong>new email</strong>';
					}

					if (empty($name)) { 
						$formerrors[] = 'you should write <strong>new FullName</strong>';
					}

					foreach ($formerrors as $error) {
						echo '<div class="alert alert-danger">' . $error . '</div>';
					}

					if (empty($formerrors)) {
						$check = checkItem("UserName","users",$user);
						if($check==1) {
							$theMsg = '<div class="alert alert-danger">Sorry User Is Already Exist</div>';
							redirectHome($theMsg, 'back');
						}	else {


								$stmt = $con->prepare("INSERT INTO 
															users(UserName, Password, Email, FullName,RegStatus, DAteandtime)
														VALUES(:zuser, :zpass, :zmail, :zname, 1, now())");
								$stmt->execute(array(

									'zuser' 	=> $user,
									'zpass' 	=> $hashpass,
									'zmail' 	=> $email,
									'zname' 	=> $name,
								));

								$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' successful rejestration</div>';
									redirectHome($theMsg,'back');
								}
				}
					
				} else {
					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-danger'> sorry you cant do that</div>";
					redirectHome($theMsg);
					echo "</div>";
				}
				echo "</div>";

				} elseif ($do == 'Edit') { 

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			
			$stmt = $con->prepare("SELECT * FROM users WHERE UserD = ? LIMIT 1");
			$stmt->execute(array($userid));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();
			if ($count > 0) { ?>
				<h1 class="text-center">Edit Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $userid; ?>">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" name="username" value="<?php echo $row['UserName'] ?>" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-sm-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"/>
								<input type="password" name="password" class="password form-control" autocomplete="new-password"  placeholder = 'Password Must Be Hard & Complex' onfocus="this.placeholder = ''" onblur="this.placeholder='Password Must Be Hard & Complex'; "/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-sm-6"> 
								<input type="Email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" autocomplete="off" required="required"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" autocomplete="off" required="required" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-sm-6">
								<input type="submit" value="Save" class="btn btn-danger btn-lg" />
							</div>
						</div>
					</form>
				</div>
		<?php
	} else {
					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-danger'> No Such ID</div>";
					redirectHome($theMsg);
					echo "</div>";
				}
				echo "</div>";
			
	}	elseif($do=='Update') {
		
		echo "<h1 class='text-center'> Update Member</h1>";
		echo "<div class='container'>";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$id 	=	$_POST['userid'];
			$user 	=	$_POST['username'];
			$email 	=	$_POST['email'];
			$name 	=	$_POST['full'];

			$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

			$formerrors = array();

			if (strlen($user)<5) { 
				$formerrors[] = ' new username should be <strong> more than 7 char</strong>';
			}

			if (strlen($user)>20) { 
				$formerrors[] = 'new username cant be <strong> more than 20 char</strong>';
			}


			if (empty($email)) { 
				$formerrors[] = 'you should write <strong>new email</strong>';
			}

			if (empty($name)) { 
				$formerrors[] = 'you should write <strong>new FullName</strong>';
			}

			foreach ($formerrors as $error) {
				echo '<div class="alert alert-danger">' . $error . '</div';
			}

			if (empty($formerrors)) {

			$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserD = ?");

			$stmt->execute(array($user, $email, $name, $pass, $id));

			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Success Edit</div>';
			redirectHome($theMsg,'back');

			}
		
			
		} else {
			$theMsg = "<div class='alert alert-danger'>sorry you cant do that</div>";
			redirectHome($theMsg);
		}
		echo "</div>";
	}	elseif($do=='Delete') {
			echo "<h1 class='text-center'> Delete Member</h1>";
			echo "<div class='container'>";
	
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


					$check = checkItem('UserD', 'users', $userid);


					if ($check > 0) {
						$stmt = $con->prepare("DELETE FROM users WHERE UserD = :zuser");
						$stmt-> bindparam(":zuser", $userid);
						$stmt->execute();
						$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' User Deleted successfuly</div>';
						redirectHome($theMsg, 'back');
					} else{
						$theMsg = "<div class='alert alert-danger'>Some Thing Went Wrong</div>";
						redirectHome($theMsg);
					}
				echo '</div';
			} elseif ($do == 'activate') { 

				echo "<h1 class='text-center'> Activate Member</h1>";
				echo "<div class='container'>";
					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

						
						// $stmt = $con->prepare("SELECT * FROM users WHERE UserD = ? LIMIT 1");
						// $stmt->execute(array($userid));
						// $count = $stmt->rowCount();
						// if ($count > 0) {

						$check = checkItem('UserD', 'users', $userid);


						if ($check > 0) {
							$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserD= ? ");
							$stmt->execute(array($userid));
							$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' User Activated successfuly</div>';
							redirectHome($theMsg);
					} else{
							$theMsg = "<div class='alert alert-danger'>Some Thing Went Wrong</div>";
							redirectHome($theMsg);
						}
					echo '</div';
	}
		
		include $tp1 . 'footer.php';
		} else {
		header('Location: index.php');
		exit();
	}