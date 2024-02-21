<?php

require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query("SELECT current FROM points_currentseason")->results()[0]->current;
?>
<div id='page-wrapper'>
	<!-- Page Content -->
	<div class='container-fluid'>
		<div class="well">
			<div class='row'>
				<div class='col'>
					<div class='card-block'>
						<div class='card-header'>
							<h2 align="center"><?= $current_season ?> Points Standings</h2>
						</div>
						<div class='card-body'>
							<?php
							include_once 'points/include/_standings.php';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>


<link rel='stylesheet' href='https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap.min.css' />
<script src='https://cdn.datatables.net/2.0.0/js/dataTables.min.js'></script>


<link rel='stylesheet' href='https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css' />
<script src='https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js'></script>


<script>
	new DataTable('[id^="standings"]', {
		fixedHeader: true,
		responsive: true,
		searching: false,
		paging: false,
		info: false,

		order: [
			[22, 'desc']
		],
	});
</script>