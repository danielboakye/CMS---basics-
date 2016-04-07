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
		$data = lyndaCms\DB\query("SELECT * FROM admins ORDER BY id ASC", array(), $con);
	}else{
		$status['error'] = 'Error! Could not connect to db.';
	}
	if(!$data){
		$status['error'] = 'There are no admins registered!';
	}

	//get details for selected subject or page

	$title = $title['admin'];
	$css_path = $css_path['manage'];
	$layout_context = "admin";
	require '../includes/header.php';
?>

<div id="main">
	<div id="navigation">
		<a id="mm" href="admin/admin.php">&laquo; Main Menu</a>
	</div>

	<div id="page">
		<h2 style="margin-top: -1px; margin-bottom: 5px;">Manage Admins</h2>
		<?php if($data) : ?>
			<div class="admin">
				<div class="title">
					<div class="left">
						<h4>Username</h4>
					</div>
					<div class="right">
						<h4>Actions</h4>
					</div>
					<br class="clear"></br>
				</div>
				<?php foreach ($data as $admin) : ?>
					<div class="left">
							<?= htmlentities(ucfirst($admin['username'])); ?>	
					</div>
					<div class="right">
						<a href="edit_admin.php?id=<?= urlencode($admin['id']); ?>">Edit</a>
						<a href="delete_admin.php?id=<?= urlencode($admin['id']); ?>" onclick="return confirm('CONFIRM DELETE\n\nAre you sure you want to delete this entity from your database?')">Delete</a>
					</div>
				<?php endforeach; ?>
				<br class="clear"></br>
			</div>
		<?php else : ?>
			<h4><?= $status['error']; ?></h4>		
		<?php endif; ?>	
		<div style="height: 7px;">&nbsp;</div>
		<div><a href="new_admin.php">Add new Admin</a></div>

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>	
	</div>
</div>
<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>