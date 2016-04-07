<?php 
	session_start();
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	$title = $title['manage'];
	$css_path = $css_path['manage'];
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

	include '../includes/find_selected_page.php';

	if (!$current_subject) {
		$_SESSION['status'] = 'Error! No subject specified';
		HTML::redirect_to("manage_content.php");
	}

	//updating the data
	$counter = 1;
	if ($_POST) {
		$menu_name = htmlspecialchars( trim( $_POST['menu_name'] ) );
		$position = (int) $_POST['position'];
		$visible = (int) $_POST['visible'];

		if( HTML::has_presence($menu_name) && HTML::has_presence($position) && HTML::has_presence($visible) )
		{
			if( HTML::has_max_length($menu_name, 21) ){
				if ($current_subject['menu_name'] === $menu_name && $current_subject['position'] == $position  &&
							 $current_subject['visible'] == $visible) 
				{
					$_SESSION['status'] = 'Subject successfully updated.';
					HTML::redirect_to("manage_content.php?subject=" . urlencode($id));
				}else{
					$id = $current_subject['id'];
					$result = lyndaCms\DB\query(
							"UPDATE subjects SET menu_name = :menu_name, position = :position, visible = :visible WHERE id = :id LIMIT 1",
							array('menu_name' => $menu_name, 'position' => $position, 'visible' => $visible, 'id' => $id), 
							$con);
					if($result){
						$_SESSION['status'] = 'Subject successfully updated.';
						HTML::redirect_to("manage_content.php?subject=" . urlencode($id));
					}else{
						$_SESSION['status'] = 'Error! Row update failed.';
					}
				}
			}else{
				$_SESSION['status'] = 'Error! Menu name exceeds maximum length!';
			}
		}else{

			$_SESSION['status'] = 'Please fill all sections.';	
		}
	}else{
		// $_SESSION['status'] = 'Error! Server request method invalid';
	}

	$layout_context = "admin";
	require '../includes/header.php';
?>

<div id="main">
	<div id="navigation">
		<?php include 'views/manage_content.view.php'; ?>
	</div>

	<div id="page">
		<h2>Edit Subject: <?= htmlentities($current_subject['menu_name']); ?></h2>
		<form action="edit_subject.php?subject=<?= urlencode($current_subject['id']); ?>" method="post">
		  <p>Menu Name:
		    <input type="text" name="menu_name" value="<?= htmlentities($current_subject['menu_name']); ?>" 
		    				placeholder="Enter menu name" >
		  </p>
		  <p>Position:
		    <select name="position">
				<!-- <option value="1">1</option> -->
				<?php
					$subject_set = lyndaCms\DB\query("SELECT * FROM subjects", array(), $con);
					if ($subject_set){
						$subject_count = $subject_set->rowCount();
						for($count=1; $count <= ($subject_count); $count++) {
							if($current_subject['position'] == $count){
								echo "<option value=\"{$count}\" selected>{$count}</option>";
							}else{
								echo "<option value=\"{$count}\">{$count}</option>";
							}//end if
							
						}//end for
					}else{
						echo "<option value=\"1\">1</option>";
					}
					
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if ($current_subject['visible'] == 0) { echo "checked";} ?>> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if ($current_subject['visible'] == 1) { echo "checked";} ?>> Yes
		  </p>
		  <input type="submit" name="submit" value="Edit Subject" />
		</form>
		<br>
		<a href="manage_content.php">Cancel</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="delete_subject.php?subject=<?= urlencode($current_subject['id']); ?>" id = "confirm">
			Delete <?= htmlentities($current_subject['menu_name']); ?>
		</a>


		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>

	</div>
</div>
<script type="text/javascript" src="js/master.js"></script>
<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>