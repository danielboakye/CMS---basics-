<?php 

if ($_POST) {
	$menu_name = htmlspecialchars( trim( $_POST['menu_name'] ) );
	$position = (int) $_POST['position'];
	$visible = (int) $_POST['visible'];
	$subject_id = $current_subject['id'];
	$content = htmlspecialchars(trim($_POST['content']));


	if( !HTML::has_max_length($menu_name, 20) ){
		//if greater than max
		$_SESSION['status'] = 'Error! Menu name exceeds maximum length!';
		HTML::redirect_to('new_subject.php');
	}

	if( HTML::has_presence($menu_name) && HTML::has_presence($position) && HTML::has_presence($visible) 
		&& HTML::has_presence($subject_id) && HTML::has_presence($content))
	{
		//why is that the user is always ""@localhost;
		lyndaCms\DB\insertQuery(
				"INSERT INTO lyndacms.pages (subject_id, menu_name, position, visible, content) 
				VALUES (:subject_id, :menu_name, :position, :visible, :content)",
				array('subject_id' => $subject_id, 'menu_name' => $menu_name, 'position' => $position, 
					'visible' => $visible, 'content' => $content), 
				$con);
		$_SESSION['status'] = 'Row has successfully been inserted.';
		HTML::redirect_to("manage_content.php?subject=" . urlencode($current_subject['id']));

	}else{

		$_SESSION['status'] = 'Please fill all sections ok.'. $subject_id;
		HTML::redirect_to("new_page.php?subject=" . urlencode($current_subject['id']));	
	}
}