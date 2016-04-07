<?php 
	session_start();
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	require '../includes/connect.php';
	require '../includes/classes/html.php';
	use lyndaCms\DB;

	DB\confirm_logged_in();

	if ($con) {
		// echo "Connection!";
		$data = DB\get_admin_by_id($_GET['id'],$con);
	}else{
		$status['error'] = 'Error! No connection to database.';
	}

	if(!$data){
		$_SESSION['status'] = 'Error! No Admin specified';
		HTML::redirect_to("manage_admins.php");
	}

	if ($_POST) {
		$username = htmlspecialchars( trim( $_POST['username'] ) );
		// $hashed_password  = DB\password_encrypt($_POST['password']);
		$hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10] );

		if( HTML::has_presence($username) && HTML::has_presence($hashed_password) )
		{
			if( HTML::has_max_length($username, 35) ){
				if ($data['username'] === $username && password_verify($_POST['password'], $data['hashed_password']) )
				{
					$_SESSION['status'] = 'Admin credentials has been successfully updated.';
					HTML::redirect_to("manage_admins.php");
				}else{
					$id = $data['id'];
					$result = DB\query(
							"UPDATE admins SET username = :username, hashed_password = :hashed_password WHERE id = :id LIMIT 1",
							array('username' => $username, 'hashed_password' => $hashed_password, 'id' => $id), 
							$con);
					if($result){
						$_SESSION['status'] = 'Admin credentials updated successfully.';
						HTML::redirect_to("manage_admins.php");
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
	 	<style type="text/css">input{height: 25px; border-radius: 5px; width: 250px; padding-left: 2px;}</style>
		<h2>Edit Admin: <?= htmlentities($data['username']); ?></h2>
		<form action="edit_admin.php?id=<?= urlencode($data['id']); ?>" method="post">
		  <p>Name: &nbsp;&nbsp;&nbsp;
		    <input type="text" name="username" value="<?= htmlentities($data['username']); ?>" >
		  </p>
		  <p>Password:
		  	<input type="password" name="password" value="" placeholder="">
		  </p>
		  <input type="submit" name="submit" value="Edit Admin" style="width: 100px; margin-top: 4px;">
		</form>
		<br>
		<a href="manage_admins.php">Cancel</a>
		<br>

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>
		<?php if (isset($status['error']) ) : ?>
			<div class="message"> <?= (isset( $status['error'] ) ) ?  htmlentities($status['error']) : ''; ?></div>
			<?php $status['error'] = null; ?>
		<?php endif; ?>

	</div>
</div>

<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>