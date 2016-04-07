<ul class="subjects">
    <?php
  //   	$list = array(); 
  //   	array_map(function($name) {
  //   		global $list;
  //   		array_push($list, $name['menu_name']);
		// }, $data);
  //  	 	echo HTML::items($list);
	    // if ( empty($status) ) {
	  //   	array_map(function($name) {
	  //   		echo "<li>" . $name['menu_name'] . "</li>";
			// }, $data);

	    // }
	    // var_dump($status);
	?>
	<?php if( empty($status) ) : ?>

		<?php foreach ($data as $name)  : ?>
			
			<?= $name['id'] === $selected_subject_id ? "<li class=\"selected\">" : "<li>" ?>
				<a href="manage_content.php?subject=<?= urlencode($name['id']); ?>">
					<?= htmlentities($name['menu_name']); ?>
				</a>
				<ul class="pages">
					<?php if ($con) : ?>
						<?php 
							$pages = lyndaCms\DB\query(
											"SELECT * FROM pages WHERE subject_id = :num ORDER BY position ASC", 
											array(':num' => $name['id'] ),
											$con); 
						?>
						<?php if ($pages) : ?>
							<?php foreach($pages as $page) : ?>
								<?= $page['id'] === $selected_page_id ? "<li class=\"selected\">" : "<li>" ?>
									<a href="manage_content.php?page=<?= urlencode($page['id']); ?>">
										<?= htmlentities($page['menu_name']); ?>
									</a>
								</li>	
							<?php endforeach; ?>	
						<?php endif; ?>		
					<?php endif; ?>	
					
				</ul>
			</li>
		<?php endforeach; ?>

	<?php else : ?>	
		<?= "<li>". htmlentities($status['error']) . "</li>";  ?>
	<?php endif; ?>	
	
</ul>	