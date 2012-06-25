<link rel="stylesheet" href="modules2/leaders/leaders.css" type="text/css" media="screen" />

<?php
$technicians = userClass::active_technicians();

$jobs = new jobsClass();
$newJobsToday = count($jobs->new_jobs_by_day());

foreach ($technicians AS $technician) {	
	$updates = jobsClass::find_by_sql("SELECT * FROM jobs WHERE entry BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() AND type='Response' AND user_uid = '" . $technician->uid . "'");
	$closedJobs = jobsClass::find_by_sql("SELECT * FROM jobs WHERE job_closed BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() AND type='Job' AND active = '0' AND owner_uid = '" . $technician->uid . "'");
	$avgTicketTime = jobsClass::find_by_sql("SELECT AVG(DATEDIFF(job_closed, entry)) AS last_update FROM jobs WHERE entry BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() AND TYPE = 'Job' AND active = 0 AND owner_uid = '" . $technician->uid . "'");
	$avgTicketTime = $avgTicketTime[0];
	
	$output  = "<div id=\"leaders\">";
	$output .= "<div class=\"mega\">";
	$output .= "<span>" . $technician->firstname . "</span> ";
	$output .= "<span class=\"leaders_updatesArrow\">A</span>" . count($updates) . " ";
	$output .= "<span class=\"icon\">U</span>" . count($closedJobs) . " ";
	$output .= "<span class=\"icon\">E</span>" . round($avgTicketTime->last_update, 2) . " days";
	$output .= "</div>";
	$output .= "</div>";
	
	echo $output;
}

?>