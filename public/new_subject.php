<?php 
	session_start();
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	require '../includes/connect.php';
	include '../includes/classes/html.php';

	lyndaCms\DB\confirm_logged_in();
	$status = array();

	if ($con) {
		// echo "Connection!";
		$data = lyndaCms\DB\query("SELECT * FROM subjects ORDER BY position ASC", 
									array(), $con);
	}else{
		$status['error'] = 'No return from db query!';
	}

	//get details for selected subject or page
	include '../includes/find_selected_page.php';

	$title = $title['new'];
	$css_path = $css_path['manage'];
	$layout_context = "admin";
	require '../includes/header.php';

?>

<div id="main">
	<div id="navigation">
		<?php include 'views/manage_content.view.php'; ?>
	</div>

	<div id="page">
		<h2>Create Subject</h2>
		<form action="create_subject.php" method="post">
		  <p>Menu Name:
		    <input type="text" name="menu_name" value="" placeholder="Enter menu name" >
		  </p>
		  <p>Position:
		    <select name="position">
				<!-- <option value="1">1</option> -->
				<?php
					$subject_set = lyndaCms\DB\query("SELECT * FROM subjects", array(), $con);
					if ($subject_set){
						$subject_count = $subject_set->rowCount();
						for($count=1; $count <= ($subject_count + 1); $count++) {
							echo "<option value=\"{$count}\">{$count}</option>";
						}
					}else{
						echo "<option value=\"1\">1</option>";
					}
					
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" /> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" /> Yes
		  </p>
		  <input type="submit" name="submit" value="Create Subject" />
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
		<br>

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>

	</div>
</div>

<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>