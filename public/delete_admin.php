<?php 

session_start();
require '../includes/config.php';
require_once '../includes/_functions.php';
require '../includes/connect.php';
include '../includes/classes/html.php';

$current_admin = lyndacms\DB\get_admin_by_id($_GET['id'],$con);
if (!$current_admin) {
	HTML::redirect_to("manage_admins.php");
}


$id = $current_admin['id'];

$result = lyndaCms\DB\query("DELETE FROM admins WHERE id = :id LIMIT 1", array('id' => $id), $con);

if ($result){
	$_SESSION['status'] = "Admin Removed from database";
	HTML::redirect_to("manage_admins.php");
}else{
	$_SESSION['status'] = "Error! Admin could not be removed";
	HTML::redirect_to("manage_admins.php");
}