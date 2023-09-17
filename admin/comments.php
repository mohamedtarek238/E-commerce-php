<?php 
session_start(); 
	
	$pageTitle = 'Comments';

	if(isset($_SESSION['Username'])) {

		
		include 'init.php';
		include $tp1 . 'header.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') { 


			$stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name, users.UserName AS Member  
									FROM 
										comments
									INNER JOIN 
										items 
									ON 
										items.item_ID = comments.Item_ID
									INNER JOIN 
										users 
									ON 
										users.UserD = comments.User_ID");
			$stmt-> execute();

			$rows = $stmt->fetchAll();
			?>
		<h1 class="text-center">Manage Comments</h1>
				<div class="container">

					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>ID</td>
								<td>Comment</td>
								<td>Item Name</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['C_ID'] . "</td>";
										echo "<td>" . $row['Comment'] . "</td>";
										echo "<td>" . $row['Item_Name'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['Comment_Date'] . "</td>";
										echo "<td>
												<a href='comments.php?do=Edit&comid=" . $row['C_ID'] . "'' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
												<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . "' class='btn btn-danger confirm '><i class='fa fa-close'></i>Delete </a>";
												if ($row['Status'] ==0) {
													echo "<a href='comments.php?do=Approve&comid=" . $row['C_ID'] . "' class='btn btn-info Approve'><i class='fa fa-check'></i>Approve </a>";
												}
											echo "</td>";
									echo "</tr>";
								}
							?>
							
						</table>
				</div>
			</div>
					<?php
							} elseif ($do == 'Edit') { 

								$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

							
									$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ?");
									$stmt->execute(array($comid));
									$row = $stmt->fetch();
									$count = $stmt->rowCount();
							if ($count > 0) { ?>
								<h1 class="text-center">Edit Comment</h1>
								<div class="container">
									<form class="form-horizontal" action="?do=Update" method="POST">
										<input type="hidden" name="comid" value="<?php echo $comid; ?>">
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">Comment</label>
											<div class="col-sm-10 col-sm-6">
												<textarea  class="form-control" name="comment"><?php echo $row['Comment'] ?></textarea>
											</div>
										</div>
										<div class="form-group form-group-lg">
											<div class="col-sm-offset-2 col-sm-10 col-sm-6">
												<input type="submit" value="Save" class="btn btn-primary btn-lg" />
											</div>
										</div>
									</form>
								</div>
						<?php
					} else {
									echo "<div class='container'>";
									$theMsg = "<div class='alert alert-danger'> No Such ID</div>";
									redirectHome($theMsg,'back');
									echo "</div>";
								}
								echo "</div>";
							
					}	elseif($do=='Update') {
						
						echo "<h1 class='text-center'> Update Comment</h1>";
						echo "<div class='container'>";
						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							
							$comid 		=	$_POST['comid'];
							$comment 	=	$_POST['comment'];
							
							if (empty($formerrors)) {

							$stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ?");

							$stmt->execute(array($comment, $comid));

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Success Edit</div>';
							redirectHome($theMsg,'back');

							}
						
							
						} else {
							$theMsg = "<div class='alert alert-danger'>sorry you cant do that</div>";
							redirectHome($theMsg);
						}
						echo "</div>";
				}	elseif($do=='Delete') {
							echo "<h1 class='text-center'> Delete Comment</h1>";
							echo "<div class='container'>";
	
							$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;


								$check = checkItem('C_ID', 'comments', $comid);


								if ($check > 0) {
									$stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zcom");
									$stmt-> bindparam(":zcom", $comid);
									$stmt->execute();
									$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' Comment Deleted successfuly</div>';
									redirectHome($theMsg, 'back');
								} else{
									$theMsg = "<div class='alert alert-danger'>Some Thing Went Wrong</div>";
									redirectHome($theMsg);
								}
							echo '</div';
			} elseif ($do == 'Approve') { 

							echo "<h1 class='text-center'> Approve Comments</h1>";
							echo "<div class='container'>";
								$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

									
									// $stmt = $con->prepare("SELECT * FROM users WHERE UserD = ? LIMIT 1");
									// $stmt->execute(array($comid));
									// $count = $stmt->rowCount();
									// if ($count > 0) {

									$check = checkItem('C_ID', 'comments', $comid);


									if ($check > 0) {
												$stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID= ? ");
												$stmt->execute(array($comid));
												$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' Comment Approved Successfuly</div>';
												redirectHome($theMsg,'back');
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