<?php
// include everything we might need!
require_once("engine/initialise.php");
?>
<!doctype html>
<html lang="en">
<head>
	<title>Wallingford School - ICT Facilities Status Board</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles/style02.css" type="text/css" media="screen" />
	<script type='text/javascript' src='engine/jquery.js'></script>
	<script type='text/javascript' src='engine/board.js'></script>
	<script type='text/javascript' src='js/highcharts.js'></script>
	<script type='text/javascript' src='js/highcharts.src.js'></script>
</head>

<body>
<div id="left">
	<section id="bargraphModule">
		<?php include_once("modules2/bargraph/start.php"); ?>
	</section>
	<section id="countdownModule">
		<?php include_once("modules2/countdown/start.php"); ?>
	</section>
	<section id="updatesModule">
		<?php include_once("modules2/updates/start.php"); ?>
	</section>
	<section id="newJobsModule">
		<?php include_once("modules2/newJobs/start.php"); ?>
	</section>
	<section id="totalJobsModule">
		<?php include_once("modules2/totalJobs/start.php"); ?>
	</section>
	<section id="primaryModule">
		<?php include_once("modules2/primary/start.php"); ?>
	</section>
</div>

<div id="right">
	<section id="typesModule">
		<?php include_once("modules2/types/start.php"); ?>
	</section>
	<section id="emailTrafficModule">
		<?php include_once("modules2/emailTraffic/start.php"); ?>
	</section>
	<section id="gridModule">
		<?php include_once("modules2/grid/start.php"); ?>
	</section>
</div>

<div id="footer">
	<section id="marqueeModule">
		<?php include_once("modules2/marquee/start.php"); ?>
	</section>
</div>
</body>
</html>