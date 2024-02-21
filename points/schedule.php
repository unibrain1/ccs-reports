<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query('SELECT current FROM points_currentseason')->results()[0]->current;

?>
<div id='page-wrapper'>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"><?= $current_season ?> Schedule</h2>
                    </div>
                    <div class='card-body'>
                        <?php include 'include/_schedule.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
?>

<link rel='stylesheet' href='https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css' />

<script src='https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js'></script>

<script>
    new DataTable('#schedule', {
        fixedHeader: true,
        responsive: true,
        scrollX: true,
        searching: false,
        paging: false,
        info: false,
        "order": [
            2, 'asc'
        ],
    });
</script>