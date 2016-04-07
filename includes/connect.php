<?php 
	require 'config.php';
	require_once '_functions.php';
	
	use lyndaCms\DB;
	global $config;

	$con = DB\connect_to_db($config);
	if (!$con) {
		die('Could not connect to database');
	}
