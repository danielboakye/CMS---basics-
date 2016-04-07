<?php
	session_start(); 
	require '../../includes/config.php';
	require_once '../../includes/_functions.php';
	require '../../includes/classes/html.php';

	if(!lyndaCms\DB\logged_in()){
		HTML::redirect_to("../login.php");
	}

	$title = $title['admin'];
	$css_path = $css_path['admin'];
	$layout_context = "admin";
	require '../../includes/header.php';
?>

<div id="main">
	<div id="navigation">
	    &nbsp;
	</div>

	<div id="page">
		<h2>Admin Menu</h2>
		<p class="welcome_message">
			Welcome to the admin area, <?= isset($_SESSION['admin_name']) ? ucfirst(htmlentities($_SESSION['admin_name'])) : "" ?>
		</p>

	    <?php foreach ($links as $link => $name) : ?>
 			<ul>
 				<?= "<li>" . HTML::anchor($link,$name) . "</li>" ?>
 			</ul>
 		<?php endforeach; ?>

	</div>
</div>

<?php require '../../includes/footer.php'; ?>
	