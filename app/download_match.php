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


    $matchName = $match_defData["match_name"];
    $matchDate = date("Y-m-d", strtotime($match_defData["match_date"]));
    if (array_key_exists('match_clubcode', $match_defData)) {
        $matchClub = strtoupper($match_defData["match_clubcode"]);
    }
    $matchShooters = $match_defData["match_shooters"];
}
?>

<link rel="stylesheet" href="includes/jquery.jsonbrowser.css" type="text/css">

<style>
    input {
        border: 1px solid #ccc;
        padding: 2px 4px;
        width: 200px;
    }

    .buttons {
        margin: 0 0 10px 0;
    }

    .buttons a {
        margin-right: 10px;
    }
</style>


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
                <label for="match_def.json" class="form-label">match_def.json - Match definitions</label>
            </div>
            <div class='card-body'>
                <div class="buttons">
                    <a href="#" id="collapse-all-match_defData">Collapse All</a>
                    <a href="#" id="expand-all-match_defData">Expand All</a>
                    <input type="text" id="search-match_defData" placeholder="Search ...">
                </div>
                <div id="match_defData" class="jsonbrowser"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class='card'>
            <div class="card-header">
                <label for="match_scores.json" class="form-label">match_scores.json - Details and stage by stage scores </label>
            </div>
            <div class='card-body'>
                <div class="buttons">
                    <a href="#" id="collapse-all-match_scoresData">Collapse All</a>
                    <a href="#" id="expand-all-match_scoresData">Expand All</a>
                    <input type="text" id="search-match_scoresData" placeholder="Search ...">
                </div>
                <div id="match_scoresData" class="jsonbrowser"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class='card'>
            <div class="card-header">
                <label for="results.json" class="form-label">results.json - Detailed match results </label>
            </div>
            <div class='card-body'>
                <div class="buttons">
                    <a href="#" id="collapse-all">Collapse All</a>
                    <a href="#" id="expand-all">Expand All</a>
                    <input type="text" id="search" placeholder="Search ...">
                </div>
                <div id="results" class="jsonbrowser"></div>
            </div>
        </div>
    </div>
</div>

<script src="includes/jquery.jsonbrowser.js"></script>


<script>
    $(function() {
        var match_defData = <?php echo json_encode($match_defData); ?>;

        $('#match_defData').jsonbrowser(match_defData);

        $('#collapse-all-match_defData').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.collapseAll('#match_defData');
        });

        $('#expand-all-match_defData').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.expandAll('#match_defData');
        });

        $('#search-match_defData').on('keyup', function(e) {
            e.preventDefault();
            $.jsonbrowser.search('#match_defData', $(this).val());
        });
        $('#search').focus().trigger('keyUp');




        var match_scoresData = <?php echo json_encode($match_scoresData); ?>;

        $('#match_scoresData').jsonbrowser(match_scoresData);

        $('#collapse-all-match_scoresData').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.collapseAll('#match_scoresData');
        });

        $('#expand-all-match_scoresData').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.expandAll('#match_scoresData');
        });

        $('#search-match_scoresData').on('keyup', function(e) {
            e.preventDefault();
            $.jsonbrowser.search('#match_scoresData', $(this).val());
        });
        $('#search').focus().trigger('keyUp');





        var results = <?php echo json_encode($match_results); ?>;

        $('#results').jsonbrowser(results);

        $('#collapse-all').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.collapseAll('#results');
        });

        $('#expand-all').on('click', function(e) {
            e.preventDefault();
            $.jsonbrowser.expandAll('#results');
        });

        $('#search').on('keyup', function(e) {
            e.preventDefault();
            $.jsonbrowser.search('#results', $(this).val());
        });
        $('#search').focus().trigger('keyUp');
    });
</script>