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
		// this query is for the naviagation side bar. Don't touch it!
		$data = lyndaCms\DB\query("SELECT * FROM subjects ORDER BY position ASC", 
									array(), $con);
	}else{
		$status['error'] = 'No return from db query!';
	}

	include '../includes/find_selected_page.php';

	if (!$current_page) {
		$_SESSION['status'] = 'Error! No subject specified';
		HTML::redirect_to("manage_content.php");
	}

	//updating the data
	if ($_POST) {
		$menu_name = htmlspecialchars( trim( $_POST['menu_name'] ) );
		$position = (int) $_POST['position'];
		$visible = (int) $_POST['visible'];
		$content = htmlspecialchars(trim($_POST['content']));

		if( HTML::has_presence($menu_name) && HTML::has_presence($position) && HTML::has_presence($visible) 
				&& HTML::has_presence($content))
		{
			if( HTML::has_max_length($menu_name, 20) ){
				if ($current_page['menu_name'] === $menu_name && $current_page['position'] == $position  &&
							 $current_page['visible'] == $visible && $current_page['content'] === $content) 
				{
					$_SESSION['status'] = 'Subject successfully updated.';
					HTML::redirect_to("manage_content.php?subject=" . urlencode($current_page['subject_id']));
				}else{
					$id = $current_page['id'];
					$result = lyndaCms\DB\query(
							"UPDATE pages SET menu_name = :menu_name, position = :position, visible = :visible, content = :content WHERE id = :id LIMIT 1",
							array('menu_name' => $menu_name, 'position' => $position, 'visible' => $visible, 'content' => $content, 'id' => $id), 
							$con);
					if($result){
						$_SESSION['status'] = 'Subject successfully updated.';
						HTML::redirect_to("manage_content.php?subject=" . urlencode($current_page['subject_id']));
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
	}

	$layout_context = "admin";
	require '../includes/header.php';
?>

<div id="main">
	<div id="navigation">
		<?php include 'views/manage_content.view.php'; ?>
	</div>

	<div id="page">
		<h2>Edit Page: <?= htmlentities($current_page['menu_name']); ?></h2>
		<form action="edit_page.php?page=<?= urlencode($current_page['id']); ?>" method="post">
		  <p>Menu Name:
		    <input type="text" name="menu_name" value="<?= htmlentities($current_page['menu_name']); ?>" >
		  </p>
		  <p>Position:
		    <select name="position">
				<!-- <option value="1">1</option> -->
				<?php
					$page_set = 
						lyndaCms\DB\query("SELECT * FROM pages WHERE subject_id = :subject_id ORDER BY position ASC",
							array('subject_id' => $current_page['subject_id']), $con);
					if ($page_set){
						$page_count = $page_set->rowCount();
						for($count=1; $count <= ($page_count); $count++) {
							if($current_page['position'] == $count){
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
		    <input type="radio" name="visible" value="0" <?php if ($current_page['visible'] == 0) { echo "checked";} ?>> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if ($current_page['visible'] == 1) { echo "checked";} ?>> Yes
		  </p>
		  <p>Content:<br />
          	<textarea name="content" rows="12" cols="80"><?= htmlentities($current_page['content']); ?></textarea>
      	  </p>
		  <input type="submit" name="submit" value="Edit Page" />
		</form>
		<br>
		<a href="manage_content.php?subject=<?= urlencode($current_page['subject_id']) ?>">Cancel</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="delete_page.php?page=<?= urlencode($current_page['id']); ?>" id = "confirm">
			Delete <?= htmlentities($current_page['menu_name']); ?>
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
