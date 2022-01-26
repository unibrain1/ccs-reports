<?php
global $ip, $settings, $db, $abs_us_root, $us_url_root;
if ($ip != $settings->cron_ip) {
    logger(1, "CronPro - summary.php", "Direct access attempted");
    die;
}
// logger(1, "summary.php", "Start");

//put your script here. Don't touch anything above this line
//Create any php script below

// require_once '../../../../users/init.php';
// require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

// ALTER TABLE `ccs_section_classifier` ADD `clubname` VARCHAR(128) NOT NULL AFTER `date`, ADD `classifiername` VARCHAR(128) NOT NULL AFTER `clubname`;
require('simple_html_dom.php');

$base = 'https://uspsa.org/classifiers-by-club?action=show&club=';
$clubs = array(
    'CC01' => 'Columbia Cascade Section',
    'CC02' => 'Tri-County Gun Club',
    'CC03' => 'Dundee Practical Shooters',
    // 'CC04' => 'Non-affiliated Club ',
    'CC05' => 'Albany Rifle & Pistol Club',
    'CC06' => 'Cossa Practical Shooters',
    // 'CC07' => 'Douglas Ridge Rifle Club',
    // 'CC08' => 'Eugene Practical Shooters',
    // 'CC09' => 'Clatskanie Rifle & Pistol Club',
    // 'CC10' => 'Painted Hills Practical Shooters',
);

$output = ""; // Message to be emailed
$to = 'competition@columbia-cascade.org';

foreach ($clubs as $club => $clubname) {
    $url = $base . $club;

    $html = file_get_html($url);
    if ($html) {
        $output .=  "<strong>Fetching $club - $clubname</strong><br>";
        // logger(1, "summary.php", $club);

        $record = [];
        foreach ($html->find('tr') as $row) {
            $record['club']   = $club;
            $record['clubname']   = $clubname;
            $record['classifier']   = $row->find('td', 0)->plaintext;
            $record['classifiername']    = $row->find('td', 1)->plaintext;
            $record['date']   = $row->find('td', 2)->plaintext; // Date format 1/16/22

            $newDate = date("Y-m-d", strtotime($record['date']));

            $record['date']  = $newDate;

            if ($record['classifier']) {
                $result = $db->get('ccs_section_classifier',  $record);

                if ($result) {
                    // logger(1, "summary.php", 'update');

                    $id = $result->results()[0]->id;
                    // $output .= "Update Classifier for " .  $record['club'] . ", " . $record['classifier'] . ", " . $record['date'] . "<br>";

                    $result =  $db->update(
                        "ccs_section_classifier",
                        $id,
                        $record
                    );
                } else {
                    // logger(1, "summary.php", 'new');

                    $output .= "New Classifier: " .  $record['date'] . ", " . $record['classifier'] . "<br>";

                    $result =  $db->insert(
                        "ccs_section_classifier",
                        $record
                    );
                }
            }
        }
        $output .= '<br>';
    }
}
email($to, 'CCS Section Classifier Summary Report', $output);
// logger(1, "summary.php", "End");
