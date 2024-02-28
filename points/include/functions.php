
<?php

// Given a URL, return the match UUID
// There are 2 forms of URL
//   A)  https://practiscore.com/results/new/231700
//   B_  https://practiscore.com/results/new/e0492b2c-3ce2-4b44-88f7-23e08dfad151

// For Type A URL need to retrieve and find match_uuid name to get GUID
//      <input name="match_uuid" type="hidden" value="e0492b2c-3ce2-4b44-88f7-23e08dfad151">

// For Type B URL parse the URL to get GUID



function urltoguid($url)
{

    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', $path);

    if (strlen(end($segments)) == 6) {
        // Type A
        $curl = curl_init();
        curl_setopt(
            $curl,
            CURLOPT_URL,
            $url
        );

        // Telling curl to store JSON data in a variable instead of dumping on screen
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Compressed
        curl_setopt($curl, CURLOPT_ENCODING, "");

        // Executing curl
        $html = curl_exec($curl);



        dump($html);
        die;
        return 'hello';
    } else {
        // Type B
        return end($segments);
    }
}



function guidturl($guid)
{
    if ($guid) {
        return "https://practiscore.com/results/new/" . $guid;
    } else {
        return null;
    }
}
