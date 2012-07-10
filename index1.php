<!doctype html>
<?php
// include everything we might need!
require_once("engine/initialise.php");
define('CONFIG', 'config.json');

// FIRST: read in the configuration
$config = fopen(CONFIG, 'r');
$dataSet = fread($config, filesize(CONFIG));
$dataSet = json_decode($dataSet);

?>
<html lang="en">
<head>
	<title>Wallingford School - ICT Facilities Status Board</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/grid.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/types.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/arrow.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/snowflake.css" type="text/css" media="screen" />
	<script type='text/javascript' src='engine/jquery.js'></script>
	<script type='text/javascript' src='engine/board.js'></script>
	<script type='text/javascript' src='js/highcharts.js'></script>
	<script type='text/javascript' src='js/highcharts.src.js'></script>
</head>

<body>	
<section id="statusboard">
<?php
$totalJobs = jobsClass::active_jobs();

if (count($totalJobs) <= 50) {
	// only do this if the total jobs is less than 50!
	echo ("<div class=\"champagne\"></div>");
}

?>

<?php
	foreach($dataSet->modules as $module) {
		$argstr = array();
	    $args = $module->args;
	    $args->width = $module->width;
	
	    foreach($args as $key => $val) {
	        $argstr[] = "$key=" . urlencode($val);
	    }
	
	    $argstr = "'" . implode("&", $argstr) . "'";
	    
	    $style = "width: {$module->width}px;";
	
	    if ($module->height) $style .= " height: {$module->height}px";
	    
	    
		echo ("<article id=\"" . $module->name . "\" class=\"" . $module->name . "\">");
		echo "<div class='module $module->class' id='$module->name' style='$style'></div>\n";
	    echo "\t<script type='text/javascript'>activate_module('$module->name', $module->update, $argstr);</script>\n\n";
		echo ("</article>");
	}
?>
</section>	
	
<footer>
</footer>
<?php

// clean up after yourself! Close the db connection
$database->close_connection();
?>
</body>
</html>