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

$query = "SELECT c.First_Name, c.Last_Name, c.Division, c.USPSA,
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q1' AND r.MatchID='1' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q1.1',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q1' AND r.MatchID='2' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q1.2',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q1' AND r.MatchID='3' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q1.3',

(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q2' AND r.MatchID='1' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q2.1',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q2' AND r.MatchID='2' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q2.2',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q2' AND r.MatchID='3' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q2.3',

(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q3' AND r.MatchID='1' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q3.1',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q3' AND r.MatchID='2' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q3.2',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q3' AND r.MatchID='3' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q3.3',

(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q4' AND r.MatchID='1' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q4.1',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q4' AND r.MatchID='2' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q4.2',
(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Q4' AND r.MatchID='3' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Q4.3',

(SELECT r.MatchPCT FROM points_results r WHERE r.Quarter='Special' AND r.USPSA=c.USPSA AND r.Division=c.Division AND r.Season='$current_season' LIMIT 1) AS 'Special'

FROM points_competitors AS c
WHERE c.Division = ?
";


?>


<div class="card card-default">
    <?php
    foreach ($divisions as $key => $val) {
        $results = $db->query($query, [$key]);
    ?>
        <div class='card-header'>
            <h2><?php echo $val ?></h2>
        </div>
        <div class='card-body'>

            <table id="" style="width: 80%" class="display table table-striped table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th scope=column>First Name</th>
                        <th scope=column>Last Name</th>
                        <th scope=column>USPSA</th>
                        <th scope=column>Division</th>

                        <th scope=column>Q1.1</th>
                        <th scope=column>Q1.2</th>
                        <th scope=column>Q1.3</th>
                        <th scope=column>Q1 Points</th>

                        <th scope=column>Q2.1</th>
                        <th scope=column>Q2.2</th>
                        <th scope=column>Q2.3</th>
                        <th scope=column>Q2 Points</th>

                        <th scope=column>Q3.1</th>
                        <th scope=column>Q3.2</th>
                        <th scope=column>Q3.3</th>
                        <th scope=column>Q3 Points</th>

                        <th scope=column>Q4.1</th>
                        <th scope=column>Q4.2</th>
                        <th scope=column>Q4.3</th>
                        <th scope=column>Q4 Points</th>
                        <th scope=column>Special</th>
                        <th scope=column>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($results->results(true) as $record) {
                        echo "<tr>";
                        echo "<td>" . $record['First_Name'] . "</td>";
                        echo "<td style='border-right:  solid'>" . $record['Last_Name'] . "</td>";
                        echo "<td>" . $record['USPSA'] . "</td>";
                        echo "<td>" . $record['Division'] . "</td>";

                        $total = 0;

                        $quarters = array("Q1.1", "Q1.2", "Q1.3");
                        $temp = array();
                        $subtotal = 0;
                        foreach ($quarters as $q) {
                            $temp[$q] = $record[$q];
                            echo "<td>" . $record[$q] . "</td>";
                        }
                        arsort($temp);
                        $keys = array_keys($temp);
                        $subtotal = $temp[$keys[0]] + $temp[$keys[1]];
                        $total = $total + $subtotal;
                        echo "<td style='border-right:  solid' class='table-info'>" . $subtotal . "</td>";


                        $quarters = array("Q2.1", "Q2.2", "Q2.3");
                        $temp = array();
                        $subtotal = 0;
                        foreach ($quarters as $q) {
                            $temp[$q] = $record[$q];
                            echo "<td>" . $record[$q] . "</td>";
                        }
                        arsort($temp);
                        $keys = array_keys($temp);
                        $subtotal = $temp[$keys[0]] + $temp[$keys[1]];
                        $total = $total + $subtotal;
                        echo "<td style='border-right:  solid' class='table-info'>" . $subtotal . "</td>";


                        $quarters = array("Q3.1", "Q3.2", "Q3.3");
                        $temp = array();
                        $subtotal = 0;
                        foreach ($quarters as $q) {
                            $temp[$q] = $record[$q];
                            echo "<td>" . $record[$q] . "</td>";
                        }
                        arsort($temp);
                        $keys = array_keys($temp);
                        $subtotal = $temp[$keys[0]] + $temp[$keys[1]];
                        $total = $total + $subtotal;
                        echo "<td style='border-right:  solid' class='table-info'>" . $subtotal . "</td>";


                        $quarters = array("Q4.1", "Q4.2", "Q4.3");
                        $temp = array();
                        $subtotal = 0;
                        foreach ($quarters as $q) {
                            $temp[$q] = $record[$q];
                            echo "<td>" . $record[$q] . "</td>";
                        }
                        arsort($temp);
                        $keys = array_keys($temp);
                        $subtotal = $temp[$keys[0]] + $temp[$keys[1]];
                        $total = $total + $subtotal;
                        echo "<td style='border-right:  solid' class='table-info'>" . $subtotal . "</td>";


                        echo "<td>" . $record['Special'] . "</td>";

                        $subtotal = $record['Special'];
                        $total = $total + 2 * $subtotal;
                        echo "<td class='table-success'>" . $total . "</td>";

                        echo "</tr>";
                    }

                    ?>

                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
</div>




<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

<script>
    $('table.display').dataTable({
        "order": [
            [21, 'desc']
        ],

        searching: false,
        paging: false,
        info: false,
        columnDefs: [{
            visible: false,
            targets: [2, 3]
        }]
    });
</script>