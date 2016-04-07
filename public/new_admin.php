<?php 
	session_start();
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	require '../includes/connect.php';
	require '../includes/classes/html.php';

	lyndaCms\DB\confirm_logged_in();

	$title = $title['new'];
	$css_path = $css_path['manage'];
	$layout_context = "admin";
	require '../includes/header.php';

?>

<div id="main">
	<div id="navigation">
		<a id="mm" href="admin/admin.php">&laquo; Main Menu</a>
	</div>

	<div id="page">
	 	<style type="text/css">input{height: 25px; border-radius: 5px; width: 250px;  padding-left: 2px;}</style>
		<h2>Create Admin</h2>
		<form action="create_admin.php" method="post">
		  <p>Name: &nbsp;&nbsp;&nbsp;
		    <input type="text" name="username" value="" placeholder=" Please enter your name here" >
		  </p>
		  <p>Password:
		  	<input type="password" name="password" value="" placeholder="">
		  </p>
		  <input type="submit" name="submit" value="Create Admin" style="width: 100px; margin-top: 4px;">
		</form>
		<br>
		<a href="manage_admins.php">Cancel</a>
		<br>

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>

	</div>
</div>

<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>