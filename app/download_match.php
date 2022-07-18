<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';



$messages = ""; // Messages
$matchName = ""; // Name of match
$matchDate = ""; // Date of match (YYYY-MM-DD)
$matchClub = ""; // Name of club
$shootersDQ = []; // Shooters who have DQ'd
$matchShooters = []; // All the shooters in the match

if (!empty($_GET)) {

    $urlbase = $_GET['url'];

    $path = parse_url($urlbase, PHP_URL_PATH);
    $segments = explode('/', $path);
    $guid =  end($segments);


    // Initializing curl
    $curl = curl_init();


    //  Three json payloads are available
    //  results.json  - Detailed match results 
    //  match_deg.json - Match definitions
    //  match_scores.json - Details and stage by stage scores 


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

    curl_setopt(
        $curl,
        CURLOPT_URL,
        "https://s3.amazonaws.com/ps-scores/production/" . $guid . "/results.json"
    );
    $results = curl_exec($curl);

    // Decoding JSON data
    $match_defData = json_decode($match_def, true);
    $match_scoresData = json_decode($match_scores, true);
    $match_results = json_decode($results, true);
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
                <form action='download_match.php'>
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
                echo $messages;
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class='card'>
            <div class="card-header">
                <label for="match_def.json" class="form-label">match_def.json</label>
            </div>
            <div class='card-body'>
                <?php
                dump($match_defData);
                ?>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class='card'>
            <div class="card-header">
                <label for="match_scores.json" class="form-label">match_scores.json</label>
            </div>
            <div class='card-body'>
                <?php
                dump($match_scoresData);
                ?>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class='card'>
            <div class="card-header">
                <label for="results.json" class="form-label">results.json</label>
            </div>
            <div class='card-body'>
                <?php
                dump($match_results);
                ?>
            </div>
        </div>
    </div>
</div>