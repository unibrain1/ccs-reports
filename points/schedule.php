<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query('SELECT current FROM points_currentseason')->results()[0]->current;

$pcc = $db->query('SELECT * FROM points_matches WHERE season = ? AND PCC = "1" ORDER BY date ASC ', [$current_season])->results(true);

$pistol = $db->query('SELECT * FROM points_matches WHERE season = ? AND PISTOL = "1" ORDER BY date ASC ', [$current_season])->results(true);

?>
<div id='page-wrapper'>
    <div class='container'>
        <div class='row justify-content-center'>
            <h2 align="center"><?= $current_season ?> Schedule</h2>
        </div>
        <div class='row justify-content-center'>

            <div class='col-6'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center">PCC</h2>
                    </div>
                    <div class='card-body'>

                        <table id="schedule" style="width: 100%" class="table table-hover table-striped table-bordered table-responsive-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope=column>Quarter</th>
                                    <th scope=column>Location</th>
                                    <th scope=column>Date</th>
                                    <th scope=column>Included in Results</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($pcc as $record) {
                                    echo '<tr>';
                                    echo '<td>' . $record['quarter'] . '</td>';
                                    echo '<td>' . $record['location'] . '</td>';
                                    echo '<td>' . $record['date'] . '</td>';

                                    if ($record['guid']) {
                                        echo '<td><i class="fa fa-fw fa-check" style="color: green"></i></td>';
                                    } else {
                                        echo '<td></td>';
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class='col-6'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center">Pistol</h2>
                    </div>
                    <div class='card-body'>

                        <table id="schedule" style="width: 100%" class="table table-hover table-striped table-bordered table-responsive-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope=column>Quarter</th>
                                    <th scope=column>Location</th>
                                    <th scope=column>Date</th>

                                    <th scope=column>Included in Results</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($pistol as $record) {
                                    echo '<tr>';
                                    echo '<td>' . $record['quarter'] . '</td>';
                                    echo '<td>' . $record['location'] . '</td>';
                                    echo '<td>' . $record['date'] . '</td>';



                                    if ($record['guid']) {
                                        echo '<td><i class="fa fa-fw fa-check" style="color: green"></i></td>';
                                    } else {
                                        echo '<td></td>';
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
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