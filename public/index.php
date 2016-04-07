<?php 
	session_start();
	require '../includes/config.php';
	require_once '../includes/_functions.php';
	$title = $title['index'];
	$css_path = $css_path['manage'];
	require '../includes/header.php';
	require '../includes/connect.php';
	include '../includes/classes/html.php';
	$status = array();

	if ($con) {
		// echo "Connection!";
		$data = lyndaCms\DB\query("SELECT * FROM subjects WHERE visible = :bool AND position > :num ORDER BY position ASC", 
									array(':bool' => 1, ':num' => 0), $con);
	}else{
		$status['error'] = 'No return from db query!';
	}

	//get details for selected subject or page
	include '../includes/find_selected_public_page.php';

?>
<style type="text/css">
	
button {width: 150px; height: 30px; background: #ff656c; box-sizing: border-box; border-radius: 5px; border: 1px solid #e15960;color: #fff;
	font-weight: bold; text-transform: uppercase; font-size: 12px; font-family: Montserrat; outline: none; cursor: pointer; }

button:hover {background: #ff7b81;}
a:hover{zoom: 1.3;}
</style>
<div id="main">
	<div id="navigation">
		<style type="text/css">a{font-family: comic; zoom: 1.2;}</style>
		<a id="mm" href="index.php">Home</a>
		<div style="height: 7px;">&nbsp;</div>
		<?php include 'views/public_navigation.view.php'; ?>

		<div style="height: 230px;">&nbsp;</div>
		<a style="padding-left: 10px;" href="login.php"><button>Admin Login</button></a>
	</div>

	<div id="page">
		<?php if($current_subject) : ?>
			<h2><?= htmlentities($current_subject['menu_name']); ?></h2>
			<?php 
				$pages = 
					lyndaCms\DB\query("SELECT * FROM pages WHERE subject_id = :num AND visible = 1 ORDER BY position ASC LIMIT 1", 
							array(':num' => $current_subject['id'] ),
							$con); 
			?>
			<?php if ($pages) : ?>
				<?php foreach ($pages as $page)  : ?>
					<h2><?= htmlentities($page['menu_name']); ?></h2>
					<div class="view_content">Content: <?= nl2br(htmlentities($page['content'])); ?></div>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php elseif($current_page) : ?>
			<h2><?= htmlentities($current_page['menu_name']); ?></h2>
			<div class="view_content">Content: <?= nl2br(htmlentities($current_page['content'])); ?></div><br>
		<?php else : ?>
			
			<!-- <div>Welcome!</div> -->
			<!-- put a slideshow here -->
			<style type="text/css">
				.fadeInLeft{
					/*transition-duration: 2s;*/
					margin-left: 100%;
					-webkit-transition: margin 2s cubic-bezier(.5, -.5, .3, 1.3) 0s, background .6s ease 1s;
					-moz-transition: margin 2s cubic-bezier(.5, -.5, .3, 1.3) 0s, background .6s ease 1s;
					-o-transition: margin 1s cubic-bezier(.5, -.5, .3, 1.3) 0s, background .6s ease 1s;
					transition: margin 1s cubic-bezier(.5, -.5, .3, 1.3) 0s, background .6s ease 1s;
				}
				.otherclass{
					margin-left: 0;
					transition-duration: 2s;
					
				}
				.img_container{overflow: hidden;
				}
			</style>
			<div class="img_container" id="img_anime" style="background-color: #303030;">
				<img class="fadeInLeft" id="mainImage" src="images/girl_dress_fantasy_88609_1366x768.jpg" width="100%" height="100%">
				<p id="welcome" class="ls-l ls-mental-title" style="font-size: 45px; font-weight: bold; top: 250px; left: 30%; opacity: 0.45; width: auto; color: #fff;">Hello Guest, Welcome to Ark Inc!</p>
			</div>

		<?php endif; ?>		

		<?php if (isset($_SESSION['status']) ) : ?>
			<div class="message"> <?= (isset( $_SESSION['status'] ) ) ?  htmlentities($_SESSION['status']) : ''; ?></div>
			<?php $_SESSION['status'] = null; ?>
		<?php endif; ?>	
	</div>
</div>
<script src="js/timers.js" type="text/javascript"></script>
<?php require '../includes/footer.php'; ?>
<?php $con = null; ?>