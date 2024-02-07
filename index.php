<?php

require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query("SELECT current FROM points_currentseason")->results()[0]->current;


?>
<div id='page-wrapper'>
	<!-- Page Content -->
	<div class='container-fluid'>
		<?php
		if ($user->isLoggedIn()) { ?>
			<div class='row'>
				<div class='col'>
					<div class='card-block'>
						<div class='card-header'>
							<h2 align="center">Classifier Information</h2>

						</div>
						<div class='card-body'>
							<ul>
								<li><a href='classifiers/classifiers.php'>Classifiers</a> - A list of current USPSA classifiers with some intersting information about the setup for each</li>
								<li><a href='classifiers/section_shot.php'>Section Classifiers</a> - What classifiers the section has run and when</li>
								<li><a href='classifiers/dq_report.php'>Section DQ</a> - Reports on section DQ's</li>
								<li><a href='classifiers/dq_entry.php'>Section DQ Data Entry</a> - Parse Practiscore entry for DQ's</li>
								<li><a href='classifiers/download_match.php'>Download and Display a match</a> - Raw Data</li>
							</ul>
						</div>
					</div>
				</div>
				<div class='col'>
					<div class='card-block'>
						<div class='card-header'>
							<h2 align="center">Points Series Information</h2>
						</div>
						<div class='card-body'>
							<ul>

								<li><a href='points/FetchPoints/fetch.php'>Generate Points CSV</a></li>
								<br>
								<li><a href='points/seasons.php'>Seasons and Match Information</a></li>
								<li><a href='points/competitors.php'>Competitor Information</a></li>
								<li><a href='points/standings.php'>Standings </a></li>
								<li><a href='points/schedule.php'>Schedule </a></li>

							</ul>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class='row'>
			<div class='col'>
				<div class='card-block'>
					<div class='card-header'>
						<h2 align="center"><?= $current_season ?> Standings</h2>
					</div>
					<div class='card-body'>
						<?php include 'points/include/_standings.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>