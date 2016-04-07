
<ul class="subjects">
		    
	<?php if( empty($status) ) : ?>

		<?php foreach ($data as $name)  : ?>
			
			<?= $name['id'] === $selected_subject_id ? "<li class=\"selected\">" : "<li>" ?>
				<a href="index.php?subject=<?= urlencode($name['id']); ?>" class="txt">
					<?= htmlentities($name['menu_name']); ?>
				</a>
				<?php if( $name['id'] === $current_subject['id'] || $name['id'] === $current_page['subject_id'] ) : ?>
					<ul class="pages">
						<?php if ($con) : ?>
							<?php 
								$pages = lyndaCms\DB\query("SELECT * FROM pages WHERE visible = :bool 
															AND subject_id = :num ORDER BY position ASC", 
													array(':bool' => 1, ':num' => $name['id'] ), $con); 
							?>
							<?php if ($pages) : ?>
								<?php foreach($pages as $page) : ?>
									<?= $page['id'] === $selected_page_id ? "<li class=\"selected\">" : "<li>" ?>
										<a href="index.php?page=<?= urlencode($page['id']); ?>" class="txt">
											<?= htmlentities($page['menu_name']); ?>
										</a>
									</li>	
								<?php endforeach; ?>	
							<?php endif; ?>		
						<?php endif; ?>	
					</ul> <!-- end pages ul -->
				<?php endif; ?>
			</li> <!-- end of subject li -->
		<?php endforeach; ?>

	<?php else : ?>	
		<?= "<li>". htmlentities($status['error']) . "</li>";  ?>
	<?php endif; ?>	
</ul>	