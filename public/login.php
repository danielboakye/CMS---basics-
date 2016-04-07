<?php 
	session_start();
	// $_SESSION['status'] = null;
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	require '../includes/connect.php';
	require '../includes/classes/html.php';

	if ($_POST) {
		$username = htmlspecialchars( trim( $_POST['username'] ) );
		// $hashed_password = lyndaCms\DB\password_encrypt($_POST['password']);
		// $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10] );
		$password = $_POST['password'];


		if( HTML::has_presence($username) && HTML::has_presence($password) )
		{
			
			$found_admin = lyndaCms\DB\attempt_login($username, $password, $con);

			//if it matches
			if($found_admin){
				//Mark user as logged in
				$_SESSION['admin_id'] = $found_admin['id'];
				$_SESSION['admin_name'] = $found_admin['username'];
				HTML::redirect_to('admin/admin.php');
			}else{
				// if it doesn't match
				$_SESSION['status'] = "Invalid Username or password! \n Please try again using valid admin credentials.";
			}

		}else{

			$_SESSION['status'] = "Please fill all sections.";
		}
	}
?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>Admin | Login</title>
<link href='css/family.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
	<div class="logo"></div>
	<div class="login-block">
	    <h1>Login</h1>
	    <form action="login.php" method="post">
		    <input type="text" name="username" value="<?= isset($username) ? htmlentities($username) : ''; ?>" placeholder="Username" id="username" class="in">
		    <input type="password" name="password" value="" placeholder="Password" id="password" class="in">
		    <input type="submit" name="submit" value="Submit" class="button"> 
		</form>
		<a href="index.php"><button class="button">Cancel</button></a>   
		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  nl2br(htmlentities($_SESSION['status'])) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>
	</div>
</body>
</html>
<?php $con = null; ?>