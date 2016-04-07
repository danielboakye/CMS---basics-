<?php 
//form processing part of new_subject.php
session_start();
require_once '../includes/_functions.php';
require '../includes/connect.php';
include '../includes/classes/html.php';

if ($_POST) {
	$menu_name = htmlspecialchars( trim( $_POST['menu_name'] ) );
	$position = (int) $_POST['position'];
	$visible  = (int) $_POST['visible'];

	if( !HTML::has_max_length($menu_name, 35) ){
		//if greater than max
		$_SESSION['status'] = 'Error! Menu name exceeds maximum length!';
		HTML::redirect_to('new_subject.php');
	}

	if( HTML::has_presence($menu_name) && HTML::has_presence($position) && HTML::has_presence($visible) )
	{
		//why is that the user is always ""@localhost;
		lyndaCms\DB\insertQuery(
				"INSERT INTO lyndacms.subjects (menu_name, position, visible) VALUES (:menu_name, :position, :visible)",
				array('menu_name' => $menu_name, 'position' => $position, 'visible' => $visible), 
				$con);
		$_SESSION['status'] = 'Row has successfully been inserted.';
		HTML::redirect_to('manage_content.php');

	}else{

		$_SESSION['status'] = 'Please fill all sections.';
		HTML::redirect_to('new_subject.php');	
	}
}else{
	$_SESSION['status'] = 'Error! Server request method invalid';
	HTML::redirect_to('new_subject.php');
}



$con = null; 