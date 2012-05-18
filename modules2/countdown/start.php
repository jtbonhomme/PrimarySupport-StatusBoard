<link rel="stylesheet" href="modules2/countdown/countdown.css" type="text/css" media="screen" />

<?php
$countdownDate = "2012-04-01 00:01";
$countdownName = "INDEPENDENCE DAY";

/* DEFAULTS */
date_default_timezone_set('Europe/London');
$stop = date('U', strtotime($countdownDate));

/* DISPLAY */
$diff = $stop - time();
$days = floor($diff/(60*60*24));

if ($days <= 0) {
    $result = 'COUNTDOWN FINISHED!';
} else {
    $result = "$days " . autoPluralise("DAY", "DAYS", $days) . " UNTIL <span class='event'>" . $countdownName . "</span>";
}


?>

<div id="countdown">
	<div class='mega'>
	    <span class='icon'>H</span><?php echo $result; ?>
	</div>
</div>