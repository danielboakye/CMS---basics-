<?php 

session_start();
require '../includes/config.php';
require_once '../includes/_functions.php';
require '../includes/connect.php';
include '../includes/classes/html.php';

$current_subject = lyndacms\DB\get_subject_by_id($_GET['subject'],$con,false);
if (!$current_subject) {
	HTML::redirect_to("manage_content.php");
}

$pages_set = lyndacms\DB\query("SELECT * FROM pages WHERE subject_id = :subject_id ORDER BY position ASC",
							array('subject_id' => $current_subject['id']), $con);

if ($pages_set) {
	$_SESSION['status'] = "Error! Can't remove a subject with related pages";
	$link = urlencode($current_subject['id']);
	HTML::redirect_to("manage_content.php?subject={$link}");
}

$id = $current_subject['id'];

$result = lyndaCms\DB\query("DELETE FROM subjects WHERE id = :id LIMIT 1", array('id' => $id), $con);

if ($result){
	$_SESSION['status'] = "Subject Removed from database";
	HTML::redirect_to("manage_content.php");
}else{
	$_SESSION['status'] = "Error! Subject could not be removed";
	HTML::redirect_to("manage_content.php?subject=" . urlencode($id));
}



