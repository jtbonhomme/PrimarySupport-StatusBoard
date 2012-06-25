<link rel="stylesheet" href="modules2/grid/grid.css" type="text/css" media="screen" />

<div id="grid">
<?php
$output = "";
$jobs = new jobsClass();

$jobsUpdatedToday = $jobs->jobs_updated_by_day();



if (count($jobsUpdatedToday) > 0) {
//	$jobUIDS = array_slice($jobUIDS, 0, 12);	// the screen only has room for 12 updates, so limit them to this number
//	$jobUIDS = array_reverse($jobUIDS);			// keep the newest updates at the top
	
	$output .= "<div>";
	
	foreach($jobsUpdatedToday as $job) {		
		$poster = UserClass::find_by_uid($job->user_uid);
		$technician = UserClass::find_by_uid($job->owner_uid);
		
		$userGravatar  = "<img src=\"http://www.gravatar.com/avatar.php?gravatar_id=";
		$userGravatar .= md5(strtolower($technician->email));
		$userGravatar .= "&amp;s=" . 30;
		$userGravatar .= "\"> ";
		
		$output .= "<span class=\"cell_0\">";
		
		// replace '-- job logged by xx on behalf of yy --<br />' for the grid
		$jobText = $job->description(150);
		$jobText = preg_replace("/--.*--<br \/>/", " ", $jobText);
		$jobText = preg_replace("/--.*--<br>/", " ", $jobText);
		
		// strike through the job if it's been closed
		if ($job->active == 0) {
			$output .= $userGravatar . "<s>" . $jobText . "</s>";
		} else {
			$output .= $userGravatar . $jobText;
		}
		
		$loggedBy = substr($poster->firstname . " " . $poster->lastname, 0, 20);
				
		$output .= "</span>";
		$output .= "<span class=\"cell_1\">" . $loggedBy . "</span>";
		$output .= "<div class=\"clear\"></div>";
		$output .= "<br />";
	}
	
	$output .= "</div>";
} else {
	$output = "No job updates today";
}

echo $output;
?>
</div>