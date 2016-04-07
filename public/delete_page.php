<?php 

session_start();
require '../includes/config.php';
require_once '../includes/_functions.php';
require '../includes/connect.php';
include '../includes/classes/html.php';

$current_page = lyndacms\DB\get_page_by_id($_GET['page'],$con,false);
if (!$current_page) {
	HTML::redirect_to("manage_content.php");
}


$id = $current_page['id'];

$result = lyndaCms\DB\query("DELETE FROM pages WHERE id = :id LIMIT 1", array('id' => $id), $con);

if ($result){
	$_SESSION['status'] = "Page Removed from database";
	HTML::redirect_to("manage_content.php?subject=" . urlencode($current_page['subject_id']));
}else{
	$_SESSION['status'] = "Error! Subject could not be removed";
	HTML::redirect_to("manage_content.php?subject=" . urlencode($current_page['subject_id']));
}