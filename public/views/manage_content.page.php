<?php if($current_subject) : ?>
	<h2>Manage Subject</h2>
	<p>Menu name: <?= htmlentities($current_subject['menu_name']); ?></p>
	<p>Position:  <?= $current_subject['position']; ?></p>
	<p>Visible:  <?= ($current_subject['visible'] == 1) ? "Yes" : "No"; ?></p><br>
	<!-- <?php print_r($current_subject) ?> -->
	<a href="edit_subject.php?subject=<?= urlencode($current_subject['id']); ?>">
		Edit <?= htmlentities($current_subject['menu_name']); ?>
	</a>
	<?php 
		$pages_set = lyndacms\DB\query("SELECT * FROM pages WHERE subject_id = :subject_id ORDER BY position ASC",
							array('subject_id' => $current_subject['id']), $con);
	?>
	<div style="margin-top: 1.5em; border-top: 1px solid #000; width: 50%;">
		<h3>Pages in the Subject: <?= htmlentities($current_subject["menu_name"]); ?></h3>
		<ul>
			<?php if($pages_set) : ?>
				<?php foreach ($pages_set as $page) : ?>
					<li>
						<a href="manage_content.php?page=<?= urlencode($page['id']); ?>">
							<?= htmlentities($page['menu_name']); ?>
						</a>
					</li>
				<?php endforeach; ?>	
			<?php endif; ?>	
		</ul>
		+ <a href="new_page.php?subject=<?= urlencode($current_subject['id']); ?>">Add a new page to this subject</a>
	</div>

<?php elseif($current_page) : ?>
	<h2>Manage Page</h2>
	<p>Menu name: <?= htmlentities($current_page['menu_name']); ?></p>
	<p>Position:  <?= $current_page['position']; ?></p>
	<p>Visible:  <?= ($current_page['visible'] == 1) ? "Yes" : "No"; ?></p>
	<div class="view_content">Content: <?= nl2br(htmlentities($current_page['content'])); ?></div><br>
	<a href="edit_page.php?page=<?= urlencode($current_page['id']); ?>">
		Edit <?= htmlentities($current_page['menu_name']); ?>
	</a>
<?php else : ?>
	<h2>Admin: <?= isset($_SESSION['admin_name']) ? ucfirst(htmlentities($_SESSION['admin_name'])) : "" ?></h2>
	<h2><?= "CRUD the CMS here";  ?></h2>

<?php endif; ?>		


