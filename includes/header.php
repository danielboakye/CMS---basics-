<?php
	if(!isset($layout_context)){
		$layout_context = "public";
	} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $title ?></title>
	<link rel="stylesheet" type="text/css" href=<?= "{$css_path}css/master.css" ?> >
</head>
<body>
	<div id="header">
	<!-- using context for conditional code -->
		<h1>Ark! <?php if ($layout_context == "admin") {echo "- Administrator";} ?></h1>
	</div>