<?php
// https://simplehtmldom.sourceforge.io

require_once '../../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

require('simple_html_dom.php');

$base = 'https://s3.amazonaws.com/ps-scores/production/';
$divisions = ['carryoptics', 'limited', 'limited10', 'open', 'pcc', 'production', 'revolver', 'singlestack'];

$results = "";

$record = [];
$i = 0;

if (!empty($_GET)) {

    $urlbase = $_GET['url'];
    $path = parse_url($urlbase, PHP_URL_PATH);
    $segments = explode('/', $path);
    $guid =  end($segments);


    // Need to make a URL that looks like this
    // $url = 'https://s3.amazonaws.com/ps-scores/production/888d91fc-6767-43f3-b4ea-284d927a58d0/html/';
    $record = [];
    $i = 0;
    foreach ($divisions as $division) {
        $url = $base . $guid . '/html/overall-' . $division;


        $html = file_get_html($url);
        if ($html) {
            $results .=  "Fetching $division <br>";
            foreach ($html->find('tr[bgcolor]') as $row) {
                $record[$i]['name']    = $row->find('td', 1)->plaintext;
                $record[$i]['place']   = $row->find('td', 0)->plaintext;
                $record[$i]['uspsa']   = $row->find('td', 2)->plaintext;
                $record[$i]['class']   = $row->find('td', 3)->plaintext;
                $record[$i]['div']     = $row->find('td', 4)->plaintext;
                $record[$i]['pf']      = $row->find('td', 5)->plaintext;
                $record[$i]['cat']     = $row->find('td', 6)->plaintext;
                $record[$i]['points']  = $row->find('td', 7)->plaintext;
                $record[$i]['percent'] = $row->find('td', 8)->plaintext;

                // Remove " %"
                $record[$i]['percent'] = str_replace('&nbsp;%', '', $record[$i]['percent']);

                //Fix typical problems with the USPSA number
                $record[$i]['uspsa']  = str_replace('-', '', $record[$i]['uspsa']); // Remove "-"
                $i++;
            }
        }
    }

    function html_table($data = array())
    {
        $rows = array();
        foreach ($data as $row) {
            $cells = array();
            foreach ($row as $cell) {
                $cells[] = "<td>{$cell}</td>";
            }
            $rows[] = "<tr>" . implode('', $cells) . "</tr>";
        }
        return "<table class='hci-table'>" . implode('', $rows) . "</table>";
    }
}
?>

<div class="row">
    <div class="col-sm-8">
        <div class='card'>
            <div class="card-header">
                <label for="url" class="form-label">Enter PractiScore URL</label>
            </div>
            <div class='card-body'>
                <form action='fetch.php'>
                    <div class="mb-3">
                        <textarea class="form-control" id="url" name='url' rows="1"></textarea>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class='card'>
            <div class='card-header'>Results</div>
            <div class='card-body'>
                <?= $results ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class='card'>
            <div class='card-header'>Output</div>
            <div class='card-body'>
                <?php
                if ($record) {
                    $keys = array_keys($record[0]);
                    echo "<table id='output' class='table table-striped table-bordered table-sm display dataTable' style='width:100%'>";
                    echo "<tr><th>" . implode("</th><th>", $keys) . "</th></tr>";
                    foreach ($record as $order) {
                        if (!is_array($order))
                            continue;
                        echo "<tr><td>" . implode("</td><td>", $order) . "</td></tr>";
                    }
                    echo "</table>";
                }
                ?>

            </div>
        </div>
    </div>
</div>