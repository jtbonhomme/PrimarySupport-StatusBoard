<link rel="stylesheet" href="modules2/types/types.css" type="text/css" media="screen" />

<div id="types">
<?php
function makeBlock ($title = NULL, $count = NULL) {	
	$output  = "<div class\"floatLeft\">";
    $output .= "<span class='mega'>" . $count . "</span><br />";
    $output .= "<span class='mega'>" . $title . "</span>";
	$output .= "</div>";
	
	return $output;
}

$highPriority = jobsClass::active_jobs_by_priority(1);
$mediumPriority = jobsClass::active_jobs_by_priority(2);
$lowPriority = jobsClass::active_jobs_by_priority(3);
$knownIssues = jobsClass::active_jobs_by_priority(4);

echo makeBlock("Known Issues", count($knownIssues));
echo makeBlock("Low<br/>Priority", count($lowPriority));
echo makeBlock("Medium Priority", count($mediumPriority));
echo makeBlock("High Priority", count($highPriority));
?>
</div>