<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query("SELECT current FROM points_currentseason")->results()[0]->current;

?>
<div id='page-wrapper'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-12'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"><?= $current_season ?> Standings</h2>
                    </div>
                    <div class='card-body'>
                        <?php include 'include/_standings.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
