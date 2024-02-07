<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

if (isset($user) && $user->isLoggedIn()) {
}
?>
<div id='page-wrapper'>
    <!-- Page Content -->
    <div class='container'>
        <div class='row'>
            <div class='col-12'>
                <!-- Heading Row -->
                <h1 align="center"> Manage Seasons Information</h1>
            </div>
        </div>
    </div>
    <br>
    <div class='row'>
        <div class='col-12'>
            <div class='card-block'>
                <div class='card-header'>
                    <h2 align="center">Current Season</h2>
                </div>
                <div class='card-body'>
                    <?php
                    $query = $db->query("SELECT * FROM points_currentseason")->results();
                    $table = "points_currentseason";
                    quickCrud($query, $table);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-12'>
            <div class='card-block'>
                <div class='card-header'>
                    <h2 align="center">All Seasons</h2>
                </div>
                <div class='card-body'>
                    <?php
                    $query = $db->query("SELECT * FROM points_seasons")->results();
                    $table = "points_seasons";
                    quickCrud($query, $table);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-12'>
            <div class='card-block'>
                <div class='card-header'>
                    <h2 align="center">Matches</h2>
                </div>
                <div class='card-body'>
                    <?php
                    $query = $db->query("SELECT * FROM points_matches")->results();
                    $table = "points_seasons";
                    quickCrud($query, $table);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>