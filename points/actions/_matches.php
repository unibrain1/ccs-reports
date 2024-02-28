<?php

require_once '../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
require_once $abs_us_root . $us_url_root . 'points/include/simple_html_dom.php';
include_once $abs_us_root . $us_url_root . 'points/include/functions.php';


$base = 'https://s3.amazonaws.com/ps-scores/production/';
$pistolDivisions = ['carryoptics', 'limited', 'limited10', 'open',  'production', 'revolver', 'singlestack', 'limitedoptics'];
$divisions = array(); // What divisions to download


// Process The Form

if (!empty($_POST)) {
    $token = Input::get('csrf');
    if (!Token::check($token)) {
        include_once $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
    } else {

        $action = Input::get('action');

        if ($action) {
            $id = Input::get('id');
            $match = $db->query("SELECT * FROM points_matches WHERE id = ?  ORDER BY date ASC", [$id])->results()[0];
        }

        if ($action == "upload") {
            // Upload this match
            // $id = Input::get('id');
            $matchurl = Input::get('matchurl');
            $guid = urltoguid($matchurl);
            $pistol = Input::get('pistol');
            $pcc = Input::get('pcc');

            if (filter_var($matchurl, FILTER_VALIDATE_URL) === false) {
                die('Not a valid URL');  // Should do something better than this
            }


            // Download the match for pistol and/or PCC according to flags
            if ($pistol) {
                $divisions = $pistolDivisions;
            }
            if ($pcc) {
                array_push($divisions, "pcc");
            }

            // Get some match information first
            // Need to use CURL on this
            $curl = curl_init();
            curl_setopt(
                $curl,
                CURLOPT_URL,
                $base . $guid . "/match_def.json"
            );

            // Telling curl to store JSON data in a variable instead of dumping on screen
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Compressed
            curl_setopt($curl, CURLOPT_ENCODING, "");

            // Executing curl
            $matchDefFile = curl_exec($curl);
            $matchDef = json_decode($matchDefFile, true);

            $matchName = $matchDef["match_name"];
            $matchDate = date("Y-m-d", strtotime($matchDef["match_date"]));
            if (array_key_exists('match_clubcode', $matchDef)) {
                $matchClub = strtoupper($matchDef["match_clubcode"]);
            }
            $matchShooters = $matchDef["match_shooters"];
            $countMatchShooters = 0;
            foreach ($matchShooters as $s) {
                if ($s['sh_del'] != 'true') {
                    $countMatchShooters++;
                }
            }

            $i = 0;
            foreach ($divisions as $division) {
                $html = @file_get_html($base . $guid . '/html/overall-' . $division);  // @ supresses warnings, i.e. 404
                if ($html) {
                    foreach ($html->find('tr[bgcolor]') as $row) {
                        $results[$i]['guid']    = $guid;

                        $results[$i]['place']   = $row->find('td', 0)->plaintext;
                        $results[$i]['name']    = $row->find('td', 1)->plaintext;
                        $results[$i]['uspsa']   = $row->find('td', 2)->plaintext;
                        $results[$i]['class']   = $row->find('td', 3)->plaintext;
                        $results[$i]['division'] = $row->find('td', 4)->plaintext;
                        $results[$i]['pf']      = $row->find('td', 5)->plaintext;
                        $results[$i]['cat']     = $row->find('td', 6)->plaintext;
                        $results[$i]['points']  = $row->find('td', 7)->plaintext;
                        $results[$i]['percent'] = $row->find('td', 8)->plaintext;

                        // Remove " %"
                        $results[$i]['percent'] = str_replace('&nbsp;%', '', $results[$i]['percent']);
                        $results[$i]['percent'] = str_replace('%', '', $results[$i]['percent']);

                        //Fix typical problems with the USPSA number
                        $results[$i]['uspsa']  = str_replace('-', '', $results[$i]['uspsa']); // Remove "-"
                        $i++;
                    }
                }
            }
            // clear a temporary table
            $tempTable = $db->query("TRUNCATE points_results_temp;");

            foreach ($results as $r) {
                $qr = $db->insert(
                    'points_results_temp',
                    [
                        "guid" => $r['guid'],
                        "Place" => $r['place'],
                        "Name" => $r['name'],
                        "USPSA" => $r['uspsa'],
                        "Class" => $r['class'],
                        "Division" => $r['division'],
                        "PF" => $r['pf'],
                        "Cat" => $r['cat'],
                        "MatchPts" => $r['points'],
                        "MatchPct" => $r['percent'],
                    ]
                );
            }
            // Update the match URL
            $db->update("points_matches", $id, ["guid" => $guid]);
        }
        if ($action == "uploadValid") {

            // Update the "points_matches" table with the new information
            $result =   $db->query(
                "INSERT into
                    points_results ( guid, Place, Name, USPSA, Class, Division, PF,  Cat, MatchPts, MatchPct )
                SELECT
                    guid,  Place,  Name,  USPSA,   Class,  Division,   PF,   Cat,   MatchPts,  MatchPct
                FROM points_results_temp"
            );

            $tempTable = $db->query("TRUNCATE points_results_temp;");

            Redirect::to($us_url_root . '/points/matches.php');
        }


        if ($action == "delete") {
            // Find this match and delete it
            $q = "SELECT count(*) as count FROM points_results WHERE guid = ?";
            $count = $db->query($q, [$match->guid])->results()[0]->count;
        }

        if ($action == "deleteValid") {
            // remove URL
            $resultQ = $db->update("points_matches", $id, ["guid" => ""]);
            // Update the points_matches and remove URL
            $q = "DELETE FROM points_results WHERE guid = ?";
            $resultQ  = $db->query($q, [$match->guid]);
            Redirect::to($us_url_root . '/points/matches.php');
        }
    } // End Post with data

}


?>
<div id='page-wrapper'>
    <!-- Page Content -->
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-12'>
                <!-- Heading Row -->
                <h1 align="center">Match Action Results </h1>
            </div>
        </div>
    </div>
    <br>

    <?php
    if ($action == "upload") {
    ?>

        <div class='row'>
            <div class='col'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"><?php echo strtoupper($action); ?> </h2>
                    </div>
                    <div class='card-body'>
                        <table id="match" class="display table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Match ID</td>
                                    <td><?= $match->id ?></td>
                                    <td color='grey'></td>
                                </tr>
                                <tr>
                                    <td>Season</td>
                                    <td><?= $match->season ?></td>
                                    <td color='grey'></td>
                                </tr>
                                <tr>
                                    <td>Quarter</td>
                                    <td><?= $match->quarter ?></td>
                                    <td color='grey'></td>

                                </tr>
                                <tr>
                                    <td>Number</td>
                                    <td><?= $match->matchid ?></td>
                                    <td color='grey'></td>

                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td><?= $match->location ?></td>
                                    <td color='grey'></td>

                                </tr>
                                <tr>
                                    <td>Pistol</td>
                                    <td><?= $match->pistol ?></td>
                                    <td><?= $pistol ?></td>
                                </tr>
                                <tr>
                                    <td>PCC</td>
                                    <td><?= $match->pcc ?></td>
                                    <td><?= $pcc ?></td>

                                </tr>
                            </tbody>
                        </table>
                        <table id="match" class="display table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th> Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td><?= $matchName ?></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td><?= $matchDate ?></td>
                                </tr>
                                <tr>
                                    <td>Count of Shooters</td>
                                    <td><?= $countMatchShooters ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <form method="post" id="editMatch" name="editMatch" action="_matches.php" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="csrf" id="csrf" value="<?= Token::generate(); ?>" />
                            <input type="hidden" name="id" id="id" value="<?= $match->id ?>" />
                            <button type="submit" name="action" value="uploadValid" class=" btn btn-success btn-lg btn-block">Accept</button>
                            <a class="btn btn-danger btn-lg btn-block" href="<?= $us_url_root ?>/points/matches.php">Reject</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if ($action == "delete") {
    ?>
        <div class='row'>
            <div class='col'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center"><?php echo strtoupper($action); ?> </h2>
                    </div>
                    <div class='card-body'>
                        <table id="match" class="display table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Match ID</td>
                                    <td><?= $match->id ?></td>
                                </tr>
                                <tr>
                                    <td>Season</td>
                                    <td><?= $match->season ?></td>
                                </tr>
                                <tr>
                                    <td>Quarter</td>
                                    <td><?= $match->quarter ?></td>
                                </tr>
                                <tr>
                                    <td>Number</td>
                                    <td><?= $match->matchid ?></td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td><?= $match->location ?></td>
                                </tr>
                                <tr>
                                    <td>Pistol</td>
                                    <td><?= $match->pistol ?></td>
                                </tr>
                                <tr>
                                    <td>PCC</td>
                                    <td><?= $match->pcc ?></td>
                                </tr>
                                <tr>
                                    <td>Count</td>
                                    <td><?= $count ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <form method="post" id="editMatch" name="editMatch" action="_matches.php" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="csrf" id="csrf" value="<?= Token::generate(); ?>" />
                            <input type="hidden" name="id" id="id" value="<?= $match->id ?>" />
                            <button type="submit" name="action" value="deleteValid" class="btn btn-success btn-lg btn-block">Are you sure?</button>
                            <a class="btn btn-danger btn-lg btn-block" href="<?= $us_url_root ?>/points/matches.php">Reject</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <?php
    }
    ?>

</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>