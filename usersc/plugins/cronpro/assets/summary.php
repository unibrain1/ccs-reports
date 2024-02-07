<?php
$browser = true;  // Set to true if you are calling from a browser

if ($browser) {
    require_once '../../../../users/init.php';
} else {
    global $ip, $settings, $db, $abs_us_root, $us_url_root;
    if ($ip != $settings->cron_ip) {
        logger(1, "CCS Summary", "Direct access attempted");
        die;
    }
}

//put your script here. Don't touch anything above this line
//Create any php script below

logger(1, "CCS Summary", "Start");

require_once $abs_us_root . $us_url_root . 'app/includes/simple_html_dom.php';

$base = 'https://uspsa.org/classifiers-by-club?action=show&club=';

// Get the clubs
$clubs = $db->query("SELECT * from ccs_clubs where active = 1")->results();

// Email report
$to = 'coordinator@columbia-cascade.org';
$output = ""; // Message to be emailed
// Add a link to the report 
$output .= '<a href="https://columbia-cascade.org/report/app/section_shot.php">Online Report</a><br><br><hr>';


foreach ($clubs as $club) {

    $url = $base . $club->club;
    if ($browser) {
           $output .= "Update CLUB " . $club->club . " URL " . $url . "<br>";
    }

    $html = file_get_html($url);
    if ($html) {
        $output .=  "<strong>Fetching $club->club - $club->name</strong><br>";

        $record = [];
        foreach ($html->find('tr') as $row) {
            $record['club']   = $club->club;
            $record['clubname']   = $club->name;
            $record['classifier']   = $row->find('td', 0)->plaintext;
            $record['classifiername']    = $row->find('td', 1)->plaintext;
            $record['date']   = $row->find('td', 2)->plaintext; // Date format 1/16/22

            $newDate = date("Y-m-d", strtotime($record['date']));

            $record['date']  = $newDate;

            if ($record['classifier']) {
                $result = $db->get('ccs_section_classifier',  $record);

                if ($result) {
                    $id = $result->results()[0]->id;
                    if (is_null($id)) {
                        $output .= "New Classifier: " .  $record['date'] . ", " . $record['classifier'] . "<br>";

                        $result =  $db->insert(
                            "ccs_section_classifier",
                            $record
                        );
                    } else {


                        if ($browser) {
                            $output .= "Update Classifier for " .  $record['club'] . ", " . $record['classifier'] . ", " . $record['date'] . "<br>";
                        }

                        $result =  $db->update(
                            "ccs_section_classifier",
                            $id,
                            $record
                        );
                    }
                }
            }
        }
        $output .= '<br>';
    } else
    {
    	if ($browser) {
		$error = error_get_last();
           	$output .= " Request did not return HTML<br>";
           	$output .= "   TYPE:" . $error['type'] . "<br>";
           	$output .= "   MESSAGE:" . $error['message'] . "<br>";
           	$output .= "   FILE:" . $error['file'] . "<br>";
           	$output .= "   LINE:" . $error['line'] . "<br>";
    	}
    }
}

$output .= '<br>';


if ($browser) {
    echo $output;
} else
{
	$email_sent=email($to, 'CCS Section Classifier Summary Report', $output);
	if(!$email_sent){
		logger(1,"CCS Summary","Error sending email = " . $email_sent);
	}
	logger(1,"CCS Summary","Complete");
}
