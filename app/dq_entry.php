<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


//  Three json payloads are available
//  results.json  - Detailed match results 
//  match_deg.json - Match definitions
//  match_scores.json - Details and stage by stage scores 



if (!empty($_GET)) {

    $urlbase = $_GET['url'];

    $path = parse_url($urlbase, PHP_URL_PATH);
    $segments = explode('/', $path);
    $guid =  end($segments);


    // Initializing curl
    $curl = curl_init();

    // Sending GET request to reqres.in
    // server to get JSON data
    curl_setopt(
        $curl,
        CURLOPT_URL,
        "https://s3.amazonaws.com/ps-scores/production/" . $guid . "/match_def.json"
    );

    // Telling curl to store JSON data in a variable instead of dumping on screen
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Compressed
    curl_setopt($curl, CURLOPT_ENCODING, "");

    // Executing curl
    $match_def = curl_exec($curl);

    curl_setopt(
        $curl,
        CURLOPT_URL,
        "https://s3.amazonaws.com/ps-scores/production/" . $guid . "/match_scores.json"
    );
    $match_scores = curl_exec($curl);

    // Decoding JSON data
    $match_defData = json_decode($match_def, true);
    $match_scoresData = json_decode($match_scores, true);

    // Translate DQ key to DQ name and rule number
    $match_dqs = $match_defData["match_dqs"];

    // The contents of "$shooter['sh_dqrule']" (from match_deg.json) will depend on what OS was used for scoreing (or maybe the master??)  
    // This is further complicated because sometimes the scores are moved from an Andriod to an IOS (or vica-versa).  
    //
    // There is sometimes a node in the match_def.josn 'device_arch": "android"' if the upload was done by ANDRIOD.  
    //
    // For matches where scoring is done via IOS and uploaded via Andriod (TCGC) there is device_arch node and the format of the sh_dqrule is in the IOS format.

    // For matches where scoring is done via ANDRIOD and uploaded via IOS (Dundee) there is no device_arch node and the format of the sh_dqrule is in the ANDRIOD format.
    //
    // And matches where scoring is done via ANDRIOD and upload via ANDRIOD (Albany) there is a device_arch key and the sh_dqrule is in the ANDRIOD format.
    //
    // Formats    
    //   $shooter['sh_dqrule'] =  Astra Terminator<10.4.7 AD, while retrieving firearm>
    // Andriod
    //   $shooter['sh_dqrule'] =  Stage Name
    //
    // My best guess - If the data as a '<' in it then assume it is in the iOS format

    // To further complicate things, DQ information can be in the match data or on the scores data.  Each of these contains different information.  We will need to examine each to get complete information

    $matchShooters = $match_defData["match_shooters"];

    // The contents of $score["stagedq_details"] is the key to the DQ table $match_dqs

    $matchScores = $match_scoresData["match_scores"];

    // Closing curl
    curl_close($curl);

    $output = ""; // Messages

    // Get some general match information
    $matchName = $match_defData["match_name"];
    $matchDate = date("Y-m-d", strtotime($match_defData["match_date"]));
    // Sometimes CLUB is not populated
    if (array_key_exists('match_clubcode', $match_defData)) {
        $matchClub = strtoupper($match_defData["match_clubcode"]);
    } else {
        $matchClub = "";
    }

    $shootersDQ = [];  // A place to gather the information before writiing to the dB

    //
    //  Walk through the SHOOTERS and find any shooter who has DQ'd
    //
    // Formats    
    //   $shooter['sh_dqrule'] =  Astra Terminator<10.4.7 AD, while retrieving firearm>
    // Andriod
    //   $shooter['sh_dqrule'] =  Stage Name
    //
    foreach ($matchShooters as $shooter) {
        if (array_key_exists('sh_dq', $shooter) &&  ($shooter["sh_dq"])) {
            $fname  = $shooter['sh_fn'];
            $lname  = $shooter['sh_ln'];
            // Sometimes a shooter has no USPSA number

            if (array_key_exists('sh_id', $shooter)) {
                $number = $shooter['sh_id'];
            } else {
                $number = "";
            }
            $hash   = $matchDate . $fname . $lname . $number;

            // Let's see of sh_dqrule is in IOS or Andriod format
            $pos = strpos($shooter['sh_dqrule'], '<');
            if ($pos == false) {
                $stage  = $shooter['sh_dqrule'];
                $rule   = "";
                $reason = "";
            } else {
                // Split the string into it's parts
                // EX: Astra Terminator<10.4.7 AD, while retrieving firearm>
                // stage = Astra Terminator
                // rule = 10.4.7
                // reason = AD, while retrieving firearm
                $len       = strlen($shooter['sh_dqrule']);
                $stage     = substr($shooter['sh_dqrule'], 0, $pos);

                $remainder = substr($shooter['sh_dqrule'], $pos + 1, $len);
                $pos      = strpos($remainder, ' ');  // Split on ' '
                $rule      = substr($remainder, 0, $pos);

                $remainder = substr($remainder, $pos + 1, $len);
                $pos    = strpos($remainder, '>');
                $reason = substr($remainder, 0, $pos);
            }

            $shootersDQ[] = [
                'date'   => $matchDate,
                'club'   => $matchClub,
                'fname'  => $fname,
                'lname'  => $lname,
                'number' => $number,
                'stage'  => $stage,
                'rule'   => $rule,
                'reason' => $reason,
                'hash'   => $hash,
            ];
        }
    }

    //
    // Now walk through the matchScores and find any shooter who as DQ'd
    // If there is information at the stage score level it will be a DQ code that we need to translate to the actual DQ rule and reason..
    //
    foreach ($matchScores as $stage) {
        foreach ($stage['stage_stagescores'] as $score) {
            if (array_key_exists('dqs', $score) && $score['dqs'] != "") {
                // Found a DQ
                // Find the shooter from the shooter array
                $shooter_key = array_search($score['shtr'], array_column($matchShooters, 'sh_uuid'));
                $dq_key      = array_search($score['dqs'][0], array_column($match_dqs, 'uuid'));
                // Translate the DQ code to Rule and Description
                $dqArray     = explode(' ', $match_dqs[$dq_key]['name'], 2);

                $fname  = $matchShooters[$shooter_key]['sh_fn'];
                $lname  = $matchShooters[$shooter_key]['sh_ln'];

                // Sometimes a shooter has no USPSA number
                if (array_key_exists('sh_id', $matchShooters[$shooter_key])) {
                    $number = $matchShooters[$shooter_key]['sh_id'];
                } else {
                    $number = "";
                }

                $hash   = $matchDate . $fname . $lname . $number;

                // Search the array to see if there is partial information from the match level.  If so augment it with the additional details
                $key = array_search($hash, array_column($shootersDQ, 'hash'));

                if ($key === false) {
                    $shootersDQ[] = [
                        'date'   => $matchDate,
                        'club'   => $matchClub,
                        'fname'  => $fname,
                        'lname'  => $lname,
                        'number' => $number,
                        'stage'  => $score["stagedq_details"],
                        'rule'   => $dqArray[0],
                        'reason' => $dqArray[1],
                        'hash'   => $hash,
                    ];
                } else {
                    $shootersDQ[$key] = [
                        'date'   => $matchDate,
                        'club'   => $matchClub,
                        'fname'  => $fname,
                        'lname'  => $lname,
                        'number' => $number,
                        'stage'  => $score["stagedq_details"],
                        'rule'   => $dqArray[0],
                        'reason' => $dqArray[1],
                        'hash'   => $hash,
                    ];
                }
            }
        }
    }

    //   Now write to the DB
    foreach ($shootersDQ as $shooter) {
        // Does this record already exist in the DB?  If so skip
        $result = $db->get('ccs_dq_log',  ['hash', '=', $shooter['hash']]);
        $id = $result->first()->id;

        if (!is_null($id)) {
            $output .= "Update DQ Record for " .  $shooter['club'] . ", " . $shooter['lname'] . ", " . $shooter['date'] . "<br>";
            $result =  $db->update(
                "ccs_dq_log",
                $id,
                $shooter
            );
        } else {
            $output .= "New DQ Record for " .  $shooter['club'] . ", " . $shooter['lname'] . ", " . $shooter['date'] . "<br>";
            $result =  $db->insert(
                "ccs_dq_log",
                $shooter
            );
        }
    }
}
?>

<br>
<div class="row">
    <div class="col-6">
        <div class='card'>
            <div class="card-header">
                <label for="url" class="form-label">Enter PractiScore URL</label>
            </div>
            <div class='card-body'>
                <form action='dq_entry.php'>
                    <div class="mb-3">
                        <textarea class="form-control" id="url" name='url' rows="1"></textarea>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class='card'>
            <div class='card-header'>Status</div>
            <div class='card-body'>
                <?php
                echo "Name     : " . $matchName . "<br>";
                echo "Date     : " . $matchDate . "<br>";
                echo "Club     : " . $matchClub . "<br>";
                echo "Shooters : " . count($matchShooters) . "<br>";
                echo "<br>";
                echo $output;
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class='card'>
            <div class="card-header">
                <label for="url" class="form-label">Output</label>
            </div>
            <div class='card-body'>

                <table id="dqType" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Club</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>USPSA Number</th>
                            <th>Stage</th>
                            <th>Rule Number</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($shootersDQ as $shooter) {
                            // Print out DQ'd shooters

                            echo '<tr>';
                            echo '<td>' . $shooter['date'] . '</td>';
                            echo '<td>' . $shooter['club'] . '</td>';
                            echo '<td>' . $shooter['fname'] . '</td>';
                            echo '<td>' . $shooter['lname'] . '</td>';
                            echo '<td>' . $shooter['number'] . '</td>';
                            echo '<td>' . $shooter['stage'] . '</td>';
                            echo '<td>' . $shooter['rule'] . '</td>';
                            echo '<td>' . $shooter['reason'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>