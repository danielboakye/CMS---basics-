<?php 

session_start();
require '../includes/classes/html.php';

$_SESSION = array();

if( isset( $_COOKIE[session_name()] ) ) {
	//if cookie[session_name] exists destroy the cookie
	setcookie(session_name(), '', time() - 3600, '/');
	// fouth parameter '/' means the cookie is availble on the entire domain
}

session_destroy();
HTML::redirect_to("login.php");