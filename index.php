<?php
	ob_start();
	session_start();
	$pageTitle = 'Homepage';
	include 'init.php';
?>
<div class="container">
	<div class="row">
		<?php
			$allItems = getAllFrom('*', 'items', 'where Approve = 1', '', 'item_ID');
			foreach ($allItems as $item) {
				echo '<div class="col-sm-4 col-md-4">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">$' . $item['Price'] . '</span>';
						echo '<img class="img-responsive" src="download.png" alt="" />';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='. $item['item_ID'] .'">' . $item['Name'] .'</a></h3>';
							echo '<p>' . $item['Description'] . '</p>';
							echo '<div class="date">' . $item['Add_Date'] . '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		?>
	</div>
</div>
<?php
	include $tp1 . 'footer.php'; 
	ob_end_flush();
?>