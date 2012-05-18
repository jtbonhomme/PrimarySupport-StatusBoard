<?php
function techTotalsBargraph() {
	// get a list of all technicians with jobs
	$technicians = userClass::active_technicians();
	
	// itterate though each technician
	foreach ($technicians AS $technician) {
		// find the total active jobs for this technician
		$jobs = new jobsClass();
		$techActiveJobs = $jobs->active_jobs_by_techUID($technician->techUid);
		
		// if there are active jobs - add them to the arrays for the chart
		if (count($techActiveJobs) > 0) {
			$techNames[] = "'" . $technician->firstName . "'";
			$totalJobs[] = count($techActiveJobs);
		}
	}
	
	$output  = "<script type=\"text/javascript\">" . "\r";
	$output .= "var chart;" . "\r";
	$output .= "$(document).ready(function() {" . "\r";
	$output .= 		"chart = new Highcharts.Chart({" . "\r";
	$output .= 			"chart: {" . "\r";
	$output .= 				"renderTo: 'techTotals_container'," . "\r";
	$output .= 				"defaultSeriesType: 'column'" . "\r";
	$output .= 			"}," . "\r";
	
	$output .= 			"credits: {" . "\r";
    $output .= 				"enabled: false" . "\r";
    $output .= 			"}," . "\r";
	$output .= 			"title: {" . "\r";
	$output .= 				"text: 'Technician Totals'" . "\r";
	$output .= 			"}," . "\r";
	$output .= 			"xAxis: {" . "\r";
	$output .= 				"categories: [" . implode(",", $techNames) . "]" . "\r";
	$output .= 			"}," . "\r";
	$output .= 			"yAxis: {" . "\r"; // PRIMARY AXIS
	$output .= 				"title: {" . "\r";
	$output .= 					"text: 'Jobs'" . "\r";
	$output .= 				"}," . "\r";
	$output .= 				"min: 0" . "\r";
	$output .= 			"}," . "\r";
	$output .= 			"tooltip: {" . "\r";
	$output .= 				"formatter: function() {" . "\r";
	$output .= 					"return '<b>'+this.x+' Total Visits:</b>' + this.y" . "\r";
	$output .= 				"}" . "\r";
	$output .= 			"}," . "\r";
	$output .= 			"legend: {" . "\r";
	$output .= 				"enabled: false" . "\r";
	$output .= 			"}," . "\r";
	$output .= 			"plotOptions: {" . "\r";
	$output .= 				"pointPadding: 0.2," . "\r";
	$output .= 				"borderWidth: 0" . "\r";
	$output .= 			"}," . "\r";
	
	$output .= 			"series: [{" . "\r";
	$output	.=				"name: 'Totals'," . "\r";
	$output .=				"data: [ " . implode(",", $totalJobs) . " ]" . "\r";
	    	
	$output .= 			"}]" . "\r";
	$output .= 		"});" . "\r";
	$output .= "});" . "\r";
	$output .= "</script>" . "\r";
	
	$output .= "<div id=\"techTotals_container\" style=\"width: 100%; height: 400px; margin: 0 auto\"></div>";
	return $output;
}

function techTotalsStackedBargraph() {
	// get a list of all technicians with jobs
	$technicians = userClass::active_technicians();
	
	foreach ($technicians AS $technician) {
		$jobs = new jobsClass();
		$techActiveJobs = $jobs->active_jobs_by_owner_uid($technician->uid);
		$techNames[] = "'" . $technician->firstname . "'";
		
		// if there are active jobs - add them to the arrays for the chart
		if (count($techActiveJobs) > 0) {
			$jobsArray['updatedJobs'][$technician->uid] = count($jobs->not_stagnant_jobs_by_userUID($technician->uid));
			$jobsArray['stagnantJobs'][$technician->uid] = count($jobs->stagnant_jobs_by_userUID($technician->uid));
			$jobsArray['veryStagnantJobs'][$technician->uid] = count($jobs->very_stagnant_jobs_by_userUID($technician->uid));
		}
	}
		
	$output  = "<script type=\"text/javascript\">" . "\r";
	$output .= "Highcharts.setOptions({" . "\r";
	$output .= 		"colors: ['#829b00', '#ff8000', '#b70007']" . "\r";
	$output .= "});" . "\r";
	
    $output .= "var chart;" . "\r";
    $output .= "$(document).ready(function() {" . "\r";
    $output .= 		"chart = new Highcharts.Chart({" . "\r";
    $output .= 			"chart: {" . "\r";
    $output .= 				"renderTo: 'techTotalsStacked_container'," . "\r";
    $output .= 				"defaultSeriesType: 'column'" . "\r";
    $output .= 			"}," . "\r";
    
    $output .= 			"credits: {" . "\r";
    $output .= 				"enabled: false" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"title: {" . "\r";
    $output .= 				"text: 'Total Jobs by Technician'" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"xAxis: {" . "\r";
    $output .= 				"categories: [" . implode(",", $techNames) . "]" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"yAxis: {" . "\r"; // PRIMARY AXIS
    $output .= 				"title: {" . "\r";
    $output .= 					"text: 'Jobs'" . "\r";
    $output .= 				"}," . "\r";
    $output .= 				"min: 0" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"tooltip: {" . "\r";
    $output .= 				"formatter: function() {" . "\r";
    $output .= 					"return '<b>'+this.x+' Total Jobs:</b>' + this.point.stackTotal + '<br/>'+";
    $output .= 					"'<b>'+this.series.name +' Jobs:</b>'+ this.y" . "\r";
    $output .= 				"}" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"legend: {" . "\r";
    $output .= 				"enabled: false" . "\r";
    $output .= 			"}," . "\r";
    $output .= 			"plotOptions: {" . "\r";
    $output .= 				"column: {" . "\r";
    $output .= 					"stacking: 'normal'" . "\r";
    $output .= 				"}" . "\r";
    $output .= 			"}," . "\r";
    
    $output .= 			"series: [{" . "\r";
    
    foreach ($jobsArray AS $jobsTypeArray) {
    	$technician = userClass::find_by_uid($techUID);
    	
    	$implodedData = implode($jobsTypeArray, ",");
    	
    	$stackData[] =	"data: [ " . $implodedData . "]";
    }
    
    $output .= implode("}, {", $stackData);
    
    $output .= "}]" . "\r";
    $output .= 		"});" . "\r";
    $output .= "});" . "\r";
    $output .= "</script>" . "\r";
    
	$output .= "<div id=\"techTotalsStacked_container\" style=\"width: 100%; height: 400px; margin: 0 auto\"></div>";
    return $output;
}

echo techTotalsStackedBargraph();
?>