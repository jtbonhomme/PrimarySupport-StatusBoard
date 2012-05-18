<link rel="stylesheet" href="modules2/newJobs/newJobs.css" type="text/css" media="screen" />

<?php
$jobs = new jobsClass();
$newJobsToday = count($jobs->new_jobs_by_day());
?>

<div id="newJobs">
	<div class='mega'>
	    <span class='icon'>H</span><br />
	    <span><?php echo $newJobsToday . " new"; ?></span>
	</div>
</div>