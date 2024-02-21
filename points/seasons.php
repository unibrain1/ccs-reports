<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query("SELECT current FROM points_currentseason")->results()[0]->current;
$seasons = $db->query("SELECT * FROM points_seasons")->results();
$matches = $db->query("SELECT * FROM points_matches WHERE season = ? ORDER BY date ASC", [$current_season])->results();

?>
<div id='page-wrapper'>
    <!-- Page Content -->
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-12'>
                <!-- Heading Row -->
                <h1 align="center"> Manage Season Information</h1>
            </div>
        </div>
    </div>
    <br>
    <div class='row'>
        <div class='col-6'>
            <div class='card-block'>
                <div class='card-header'>
                    <h2 align="center">Current Season</h2>
                </div>
                <div class='card-body'>
                    <?php


                    echo '<h3>Current season: ' . $current_season . '</h3></br>';
                    echo '<button type="current_season" class="btn btn-warning btn-lg btn-block">Edit</button></br>';
                    ?>
                </div>
            </div>
        </div>

        <div class='col-6'>
            <div class='card-block'>
                <div class='card-header'>
                    <h2 align="center">All Seasons</h2>
                </div>
                <div class='card-body'>
                    <?php
                    echo '<ul>';
                    foreach ($seasons as $s) {
                        echo '<li>' . $s->season . "</li>";
                    }

                    echo '</ul>';
                    echo '<button type="seasons" class="btn btn-warning btn-lg btn-block">Add</button></br>';
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>
</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>