<?php
$query = 'SELECT * FROM points_matches WHERE season = ? ORDER BY date ASC ';
$schedule = $db->query($query, [$current_season]);
?>

<table id="schedule" style="width: 100%" class="table table-hover table-striped table-bordered table-responsive-sm">
    <thead class="table-dark">
        <tr>
            <th scope=column>Quarter</th>
            <th scope=column>Location</th>
            <th scope=column>Date</th>

            <th scope=column>Pistol</th>
            <th scope=column>PCC</th>
            <th scope=column>Included in Results</th>

        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($schedule->results(true) as $record) {
            echo '<tr>';
            echo '<td>' . $record['quarter'] . "." . $record['matchid'] . '</td>';
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