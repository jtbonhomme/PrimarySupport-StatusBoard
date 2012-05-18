<link rel="stylesheet" href="modules2/totalJobs/totalJobs.css" type="text/css" media="screen" />

<?php
/* DATA */
$jobs = new jobsClass();
$currentTotalJobs = count($jobs->active_jobs());
$newJobsToday = count($jobs->new_jobs_by_day());

$jobsDifference = ($currentTotalJobs - $newJobsToday);

/* DISPLAY */
if ($jobsDifference < 0) {
    $class = 'downgreenarrow';
    $code = 'A';
} elseif ($jobsDifference > 0) {
    $class = 'upredarrow';
    $code = 'A';
} else {
	$class = 'zero-block';
    $code = 'K';
}
?>

<div id="totalJobs">
	<span class='<?php echo $class; ?>' id='arrow_icon'><?php echo $code; ?></span>
	<span class='mega'><?php echo $currentTotalJobs; ?> total</span>
</div>