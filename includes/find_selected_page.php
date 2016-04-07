<?php 

if ( isset( $_GET["subject"]) ) {
	$selected_subject_id = htmlspecialchars($_GET["subject"]);
	$current_subject = lyndaCms\DB\get_subject_by_id($selected_subject_id,$con,false);
	$selected_page_id = null;
	$current_page = null;
} elseif ( isset( $_GET["page"]) ) {
	$selected_page_id = htmlspecialchars($_GET["page"]);
	$current_page = lyndaCms\DB\get_page_by_id($selected_page_id,$con,false);
	$selected_subject_id = null;
	$current_subject = null;
} else {
	$selected_subject_id = null;
	$selected_page_id = null;
	$current_page = null;
	$current_subject = null;
}