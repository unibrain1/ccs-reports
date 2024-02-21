
<?php


function urltoguid($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', $path);
    return end($segments);
}

function guidturl($guid)
{
    if ($guid) {
        return "https://practiscore.com/results/new/" . $guid;
    } else {
        return null;
    }
}
