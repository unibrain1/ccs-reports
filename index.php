<?php
if (file_exists("install/index.php")) {
	//perform redirect if installer files exist
	//this if{} block may be deleted once installed
	header("Location: install/index.php");
}

require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (isset($user) && $user->isLoggedIn()) {
}
?>
<div class="jumbotron">
	<h1 align="center"><?= lang("JOIN_SUC"); ?> <?php echo $settings->site_name; ?></h1>
	<div class="jumbotron">
		<ul>
			<li><a href='app/classifiers.php'>Classifiers</a> - A list of current USPSA classifiers with some intersting information about the setup for each</li>
			<li><a href='app/section_shot.php'>Section Classifiers</a> - What classifiers the section has run and when</li>

			<?php
			if ($user->isLoggedIn()) { ?>
				<li>Section DQ - Reports on section DQ's</li>
			<?php } ?>

		</ul>
	</div>
</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>