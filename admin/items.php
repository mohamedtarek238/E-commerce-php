<?php


	ob_start();

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {

		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') { 

			$stmt = $con->prepare("SELECT items.* , 
										categories.Name As category_name ,
										users.UserName
									FROM 
										items
									INNER JOIN 
										categories 
									ON 
										categories.ID = items.Cat_ID
									INNER JOIN 
										users 
									ON 
										users.UserD = Member_ID ");
			$stmt-> execute();
			$items = $stmt->fetchAll();
	?>		
		<h1 class="text-center">Manage Items</h1>
				<div class="container">

					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>NAme</td>
								<td>Description</td>
								<td>Price</td>
								<td>Adding Date</td>
								<td>Category</td>
								<td>Member</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach($items as $item) {
									echo "<tr>";
										echo "<td>" . $item['item_ID'] . "</td>";
										echo "<td>" . $item['Name'] . "</td>";
										echo "<td>" . $item['Description'] . "</td>";
										echo "<td>" . $item['Price'] . "</td>";
										echo "<td>" . $item['Add_Date'] . "</td>";
										echo "<td>" . $item['category_name'] . "</td>";
										echo "<td>" . $item['UserName'] . "</td>";
										echo "<td>
												<a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "'' class='btn btn-success'><i class='fa fa-edit'></i> Edit </a>
												<a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm '><i class='fa fa-close'></i>Delete </a>";
												if ($item['Approve'] ==0) {
													echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info Approve'><i class='fa fa-check'></i>Approve </a>";
												}
											echo "</td>";
									echo "</tr>";
								}
							?>
							
						</table>
				</div>
				<a href="items.php?do=add" class="btn btn-primary" > <i class="fa fa-plus"></i> New Item</a>
			</div>
			<?php 

		} elseif ($do == 'add') { ?>

			<h1 class="text-center">Add New Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="name" 
										class="form-control"
										required="required"
										placeholder="Item To Add" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Item To Add'"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="description" 
										class="form-control"
										required = "required"
										placeholder="Description Of Item" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Description Of Item'"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="price" 
										class="form-control"
										required = "required"
										placeholder="Items Price" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Items Price'"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="country" 
										class="form-control"
										required = "required"
										placeholder="where was item made?" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='where was item made?'"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-sm-6">
								<select name="status" class="form-control">
									<option value="0">.....</option>
									<option value="1">New</option>
									<option value="2">Like New</option>
									<option value="3">Used</option>
									<option value="4">Old</option>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-sm-6">
								<select name="member" class="form-control">
									<option value="0">.....</option>
								<?php
									$stmt = $con->prepare("SELECT * FROM users");
									$stmt->execute();
									$users= $stmt->fetchAll();
									foreach($users as $user) {
										echo "<option value=' " . $user['UserD'] . "'>" . $user['UserName'] . "</option>";
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-sm-6">
								<select name="category" class="form-control">
									<option value="0">.....</option>
								<?php
									$stmt2 = $con->prepare("SELECT * FROM categories");
									$stmt2->execute();
									$cats= $stmt2->fetchAll();
									foreach($cats as $cat) {
										echo "<option value=' " . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-sm-6">
								<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
							</div>
						</div>
					</form>
				</div>
				<?php


		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h1 class='text-center'> Insert Member</h1>";
			echo "<div class='container'>";
					
					$name 				=	$_POST['name'];
					$description 		=	$_POST['description'];
					$price 				=	$_POST['price'];
					$country 			=	$_POST['country'];
					$status 			=	$_POST['status'];
					$member 			=	$_POST['member'];
					$cat 			    =	$_POST['category'];

					$formerrors = array();

					if (empty($name)) { 
						$formerrors[] = 'Username Can\'t be <strong>Empty</strong>';
					}
					if (empty($description)) { 
						$formerrors[] = 'Description Can\'t be <strong>Empty</strong>';
					}

					if (empty($price)) { 
						$formerrors[] = 'you should write <strong>price</strong>';
					}

					if (empty($country)) { 
						$formerrors[] = 'you should write <strong>country</strong>';
					}

					if ($status == 0) { 
						$formerrors[] = 'you should Choose <strong>status</strong>';
					}
					if ($member == 0) { 
						$formerrors[] = 'you should Choose <strong>member</strong>';
					}					
					if ($cat == 0) { 
						$formerrors[] = 'you should Choose <strong>category</strong>';
					}
					foreach ($formerrors as $error) {
						echo '<div class="alert alert-danger">' . $error . '</div>';
					}

					if (empty($formerrors)) {


								$stmt = $con->prepare("INSERT INTO 
															items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID)
														VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
								$stmt->execute(array(

									'zname' 	=> $name,
									'zdesc' 	=> $description,
									'zprice' 	=> $price,
									'zcountry' 	=> $country,
									'zstatus' 	=> $status,
									'zcat' 		=> $cat,
									'zmember' 	=> $member,
								));

								$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Add Successfuly</div>';
									redirectHome($theMsg,'back'); 	
				}
					
				} else {
					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-danger'> sorry you cant do that</div>";
					redirectHome($theMsg);
					echo "</div>";
				}
				echo "</div>";

		} elseif ($do == 'Edit') {

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			
			$stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
			$stmt->execute(array($itemid));
			$item = $stmt->fetch();
			$count = $stmt->rowCount();
			if ($count > 0) { ?>
				<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="name" 
										class="form-control"
										required="required"
										placeholder="Item To Add" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Item To Add'"
										value="<?php echo $item['Name'] ?>" />
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="description" 
										class="form-control"
										required = "required"
										placeholder="Description Of Item" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Description Of Item'"
										value="<?php echo $item['Description'] ?>"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="price" 
										class="form-control"
										required = "required"
										placeholder="Items Price" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='Items Price'"
										value="<?php echo $item['Price'] ?>"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-sm-6">
								<input type="text" 
										name="country" 
										class="form-control"
										required = "required"
										placeholder="where was item made?" 
										onfocus="this.placeholder = ''" 
										onblur="this.placeholder='where was item made?'"
										value="<?php echo $item['Country_Made'] ?>"/>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-sm-6">
								<select name="status" class="form-control">
									<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
									<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
									<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
									<option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-sm-6">
								<select name="member" class="form-control">
									<option value="0">.....</option>
								<?php
									$stmt = $con->prepare("SELECT * FROM users");
									$stmt->execute();
									$users= $stmt->fetchAll();
									foreach($users as $user) {
										echo "<option value='" . $user['UserD'] . "'"; 
											if ($item['Member_ID'] == $user['UserD']) { echo 'selected'; } 
											echo ">" . $user['UserName'] . "</option>";
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-sm-6">
								<select name="category" class="form-control">
									<option value="0">.....</option>
								<?php
									$stmt2 = $con->prepare("SELECT * FROM categories");
									$stmt2->execute();
									$cats= $stmt2->fetchAll();
							
									foreach($cats as $cat) {
										echo "<option value='" . $cat['ID'] . "'";
												if ($item['Cat_ID'] == $cat['ID']) { echo ' selected'; }
												echo "> " . $cat['Name'] . "</option>";
									}
								?>
								</select>
							</div>
						</div>
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10 col-sm-6">
								<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
							</div>
						</div>
					</form>
					<?php
					$stmt = $con->prepare("SELECT comments.*, users.UserName AS Member  
									FROM 
										comments

									INNER JOIN 
										users 
									ON 
										users.UserD = comments.User_ID
									WHERE
										Item_ID=?");
					$stmt-> execute(array($itemid));

					$rows = $stmt->fetchAll();

	if (! empty($rows)) {
				?>
					<h1 class="text-center">Manage <?php echo $item['Name'];?> Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['Comment'] . "</td>";
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
				<?php } ?>
				</div>
	<?php
		} else {
					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-danger'> No Such ID</div>";
					redirectHome($theMsg);
					echo "</div>";
				}
				echo "</div>";

		} elseif ($do == 'Update') {
				echo "<h1 class='text-center'> Update Item</h1>";
				echo "<div class='container'>";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$id 			=	$_POST['itemid'];
			$name 			=	$_POST['name'];
			$desc 			=	$_POST['description'];
			$price 			=	$_POST['price'];
			$country 		=	$_POST['country'];
			$status 		=	$_POST['status'];
			$member 		=	$_POST['member'];
			$cat 			=	$_POST['category'];

			$formerrors = array();

					if (empty($name)) { 
						$formerrors[] = 'Username Can\'t be <strong>Empty</strong>';
					}
					if (empty($desc)) { 
						$formerrors[] = 'Description Can\'t be <strong>Empty</strong>';
					}

					if (empty($price)) { 
						$formerrors[] = 'you should write <strong>price</strong>';
					}

					if (empty($country)) { 
						$formerrors[] = 'you should write <strong>country</strong>';
					}

					if ($status == 0) { 
						$formerrors[] = 'you should Choose <strong>status</strong>';
					}
					if ($member == 0) { 
						$formerrors[] = 'you should Choose <strong>member</strong>';
					}					
					if ($cat == 0) { 
						$formerrors[] = 'you should Choose <strong>category</strong>';
					}
					foreach ($formerrors as $error) {
						echo '<div class="alert alert-danger">' . $error . '</div>';
					}

			if (empty($formerrors)) {

			$stmt = $con->prepare("UPDATE 
										items 
									SET 
										Name = ?, 
										Description = ?, 
										Price = ?, 
										Country_Made = ?,
										Status = ?, 
										Member_ID = ?,
										Cat_ID = ?
									WHERE 
										item_ID = ?");

			$stmt->execute(array($name, $desc, $price, $country, $status,$member,$cat,$id));

			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Success Edit</div>';
			redirectHome($theMsg,'back');

			}
		
			
		} else {
			$theMsg = "<div class='alert alert-danger'>sorry you cant do that</div>";
			redirectHome($theMsg);
		}
		echo "</div>";

		} elseif ($do == 'Delete') {

					echo "<h1 class='text-center'> Delete Item</h1>";
			echo "<div class='container'>";
	
				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


					$check = checkItem('item_ID', 'items', $itemid);


					if ($check > 0) {
						$stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");
						$stmt-> bindparam(":zid", $itemid);
						$stmt->execute();
						$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' User Deleted successfuly</div>';
						redirectHome($theMsg, 'back');
					} else{
						$theMsg = "<div class='alert alert-danger'>Some Thing Went Wrong</div>";
						redirectHome($theMsg);
					}
				echo '</div';
			
		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'> Approve Member</h1>";
				echo "<div class='container'>";
					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
						
						// $stmt = $con->prepare("SELECT * FROM users WHERE UserD = ? LIMIT 1");
						// $stmt->execute(array($itemid));
						// $count = $stmt->rowCount();
						// if ($count > 0) { 

						$check = checkItem('item_ID', 'items', $itemid);


						if ($check > 0) {
							$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID= ? ");
							$stmt->execute(array($itemid));
							$theMsg =  "<div class='alert alert-success'> " . $stmt->rowCount() . ' Approved Successfuly</div>';
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

	ob_end_flush();

?>