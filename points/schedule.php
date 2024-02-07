<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$current_season = $db->query('SELECT current FROM points_currentseason')->results()[0]->current;


$query = 'SELECT * FROM points_matches WHERE season = ? ORDER BY date ASC ';
$schedule = $db->query($query, [$current_season]);


?>
<div id='page-wrapper'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-12'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"><?= $current_season ?> Schedule</h2>
                    </div>
                    <div class='card-body'>
                        <table id="" style="width: 80%" class="display table table-striped table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope=column>Quarter</th>
                                    <th scope=column>Location</th>
                                    <th scope=column>Date</th>

                                    <th scope=column>Pistol</th>
                                    <th scope=column>PCC</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($schedule->results(true) as $record) {
                                    echo '<tr>';
                                    echo '<td>' . $record['quarter'] . '</td>';
                                    echo '<td>' . $record['location'] . '</td>';
                                    echo '<td>' . $record['date'] . '</td>';
                                    if ($record['pistol']) {
                                        echo '<td><i class="fa fa-fw fa-check" style="color: green"></i></td>';
                                    } else {
                                        echo '<td><i class="fa fa-fw fa-times" style="color: red"></i></td>';
                                    }
                                    if ($record['pcc']) {
                                        echo '<td><i class="fa fa-fw fa-check" style="color: green"></i></td>';
                                    } else {
                                        echo '<td><i class="fa fa-fw fa-times" style="color: red"></i></td>';
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
    $('table.display').dataTable({
        searching: false,
        paging: false,
        info: false,
    });
</script>