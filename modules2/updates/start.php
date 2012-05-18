<link rel="stylesheet" href="modules2/updates/updates.css" type="text/css" media="screen" />

<?php
/* DATA */
$yesterday = date("Y-m-d", time()-86400);
$jobs = new jobsClass();

$updatesToday = count($jobs->new_updates_by_day());
$updatesYesterday = count($jobs->new_updates_by_day($yesterday));

$difference = $updatesToday - $updatesYesterday;

/* DISPLAY */
if ($difference > 0) {
    $class = 'upgreenarrow';
    $code = 'A';
} elseif ($difference < 0) {
    $class = 'downredarrow';
    $code = 'A';
} else {
    $class = 'zero-block';
    $code = 'K';
}
?>

<div id="updates">
	<span class='<?php echo $class; ?>' id='arrow_icon'><?php echo $code ?></span>
	<span class='mega'><?php echo $updatesToday; ?> updates</span>
</div>