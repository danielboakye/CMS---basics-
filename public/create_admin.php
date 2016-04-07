<?php 
//form processing part of new_subject.php
session_start();
require_once '../includes/_functions.php';
require '../includes/connect.php';
include '../includes/classes/html.php';

if ($_POST) {
	$username = htmlspecialchars( trim( $_POST['username'] ) );
	// $hashed_password = lyndaCms\DB\password_encrypt($_POST['password']);
	$hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10] );

	if( !HTML::has_max_length($username, 35) ){
		//if greater than max
		$_SESSION['status'] = 'Error! Menu name exceeds maximum length!';
		HTML::redirect_to('new_admin.php');
	}

	if( HTML::has_presence($username) && HTML::has_presence($hashed_password))
	{
		//why is that the user is always ""@localhost;
		lyndaCms\DB\insertAdmin(
				"INSERT INTO lyndacms.admins (username, hashed_password) VALUES (:username, :hashed_password)",
				array('username' => $username, 'hashed_password' => $hashed_password), 
				$con);
		$_SESSION['status'] = htmlentities(ucfirst($username)) . "  has been successfully made an Admin";
		HTML::redirect_to('manage_admins.php');

	}else{

		$_SESSION['status'] = 'Please fill all sections.';
		HTML::redirect_to('new_admin.php');	
	}
}else{
	$_SESSION['status'] = 'Error! Server request method invalid';
	HTML::redirect_to('new_admin.php');
}



$con = null; 