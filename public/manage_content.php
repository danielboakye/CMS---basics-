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

	$title = $title['manage'];
	$css_path = $css_path['manage'];
	$layout_context = "admin";
	require '../includes/header.php';
?>

<div id="main">
	<div id="navigation">
		<a id="mm" href="admin/admin.php">&laquo; Main Menu</a>
		<div style="height: 7px;">&nbsp;</div>
		<?php include 'views/manage_content.view.php'; ?>
		<div class="addsub"><a href="new_subject.php">+ Add a subject</a></div>
	</div>

	<div id="page">
		<?php include 'views/manage_content.page.php'; ?>

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>	
	</div>
</div>

<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>