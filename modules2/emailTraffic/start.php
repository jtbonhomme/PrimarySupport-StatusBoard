<link rel="stylesheet" href="modules2/emailTraffic/emailTraffic.css" type="text/css" media="screen" />

<div id="emailTraffic">
<?php
$row = 1;
$csvAddress = "https://mail.wallingfordschool.com/logs/output.csv";

if (($handle = fopen($csvAddress, "r")) !== FALSE) {
	$header = fgetcsv($handle, 1, ",");
	$data = fgetcsv($handle, 1, ",");
	
	$emailsPerSec = round($data[0],2);
	
	fclose($handle);
}

$output = "<span class='mega'>" . $emailsPerSec . " E-Mails Sent In The Last Hour" . "</span>";

echo $output;
?>
</div>