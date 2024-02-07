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
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"> Manage Competitors</h2>
                        This should really include an upload with season selection
                    </div>
                    <div class='card-body'>
                        <?php
                        $query = $db->query("SELECT * FROM points_competitors")->results();
                        $table = "points_competitors";
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