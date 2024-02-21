<?php


$divisions = [
    "O" => "Open",
    "CO" => "Carry Optics",
    "LO" => "Limited Optics",
    "PCC" => "PCC",
    "L" => "Limited",
    "L10" => "Limited 10",
    "R" => "Revolver",
    "P" => "Production",
    "SS" => "Single Stack",
];

$quarters = [
    "Q1", "Q2", "Q3", "Q4"
];

$results = array();

$competitors = $db->query("SELECT First_Name, Last_Name, USPSA, Division, Nationals_Slot from points_competitors WHERE Season = ? ", [$current_season])->results('true');
foreach ($competitors as $competitor) {
    $results[$competitor['Division']][strtoupper($competitor['USPSA'])]['firstName']  = $competitor['First_Name'];
    $results[$competitor['Division']][strtoupper($competitor['USPSA'])]['lastName']  = $competitor['Last_Name'];
    $results[$competitor['Division']][strtoupper($competitor['USPSA'])]['slot']  = $competitor['Nationals_Slot'];
}

foreach ($quarters as $quarter) {
    for ($id = 1; $id <= 3; $id++) {
        // Get the list of matches that cover the season, quarter, and match number
        $matches = $db->query("SELECT * FROM points_matches WHERE season = ? AND quarter = ? AND matchid = ?", [$current_season, $quarter, $id])->results(true);
        foreach ($matches as $match) {
            // Only look at matches that have been uploaded
            $matchname = $quarter . "." . $id;
            if ($match['guid']) {
                // For each of the matches get results for those in the points match
                $query = $db->query(
                    "SELECT r.name, r.uspsa, r.division, r.class, r.matchPct from points_results r
                    JOIN points_competitors c ON r.uspsa = c.uspsa
                    WHERE r.guid = ? AND r.division = c.division",
                    [$match['guid']]
                )->results('true');
                foreach ($query as $i) {
                    $results[$i['division']][strtoupper($i['uspsa'])]['name']     = $i['name'];
                    $results[$i['division']][strtoupper($i['uspsa'])]['class']    = $i['class'];
                    $results[$i['division']][strtoupper($i['uspsa'])][$matchname] = $i['matchPct'];
                }
            }
        }
    }
}
?>
<?php
foreach ($results as $division => $divisionResults) {
?>
    <div class="card card-default">
        <div class='card-header'>
            <h2><?php echo $divisions[$division] ?></h2>
        </div>

        <div class='card-body'>
            <table id="standings-<?= $divisions[$division] ?>" style="width: 100%" class="table table-striped table-bordered table-sm table-hover" aria-describedby="card-header">
                <thead class=" table-dark">
                    <tr>
                        <th data-priority='1' scope=column>First Name</th>
                        <th data-priority='1' scope=column>Last Name</th>
                        <th scope=column>Slot</th>
                        <th scope=column>USPSA</th>
                        <th scope=column>Class</th>

                        <th scope=column>Q1.1</th>
                        <th scope=column>Q1.2</th>
                        <th scope=column>Q1.3</th>
                        <th data-priority='40' scope=column>Q1 Points</th>

                        <th scope=column>Q2.1</th>
                        <th scope=column>Q2.2</th>
                        <th scope=column>Q2.3</th>
                        <th data-priority='30' scope=column>Q2 Points</th>

                        <th scope=column>Q3.1</th>
                        <th scope=column>Q3.2</th>
                        <th scope=column>Q3.3</th>
                        <th data-priority='20' scope=column>Q3 Points</th>

                        <th scope=column>Q4.1</th>
                        <th scope=column>Q4.2</th>
                        <th scope=column>Q4.3</th>
                        <th data-priority='10' scope=column>Q4 Points</th>
                        <th scope=column>Sectional</th>
                        <th data-priority='1' scope=column>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($divisionResults as $uspsa => $results) {
                        echo '<tr>';

                        echo '<td>';
                        echo $results['firstName'];
                        echo '</td>';

                        echo '<td>';
                        echo $results['lastName'];
                        echo '</td>';
                        echo '<td>';

                        echo $results['slot'];
                        echo '</td>';

                        echo '<td>';
                        echo $uspsa;
                        echo '</td>';

                        echo '<td style="border-right:  solid">';

                        if (array_key_exists('class', $results)) {
                            echo $results['class'];
                        }
                        echo '</td>';

                        $total = 0;
                        foreach ($quarters as $quarter) {
                            $subtotal = array();
                            for ($id = 1; $id <= 3; $id++) {
                                echo '<td>';
                                $arrayKey = $quarter . "." . $id;
                                if (array_key_exists($arrayKey, $results)) {
                                    echo $results[$arrayKey];
                                    $subtotal[$arrayKey] = $results[$arrayKey];
                                }
                                echo '</td>';
                            }
                            echo '<td style="background-color: #FFFFE0;">';
                            arsort($subtotal);
                            if (count($subtotal) > 2) {
                                array_pop($subtotal);
                            }
                            $sum = array_sum($subtotal);
                            echo $sum;
                            $total = $total + $sum;
                            echo '</td>';
                        }

                        echo '<td>';
                        if (array_key_exists('sectional', $results)) {
                            echo $results['sectionl'];
                            $total = $total + 2 * $results['sectionl'];
                        }
                        echo '</td>';

                        echo '<td style="background-color: #FFE0FF;">';
                        echo $total;
                        echo '</td>';

                        echo '</tr>';
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php
}
?>