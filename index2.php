<!doctype html>
<?php
// include everything we might need!
require_once("engine/initialise.php");

?>
<html lang="en">
<head>
	<title>Wallingford School - ICT Facilities Status Board</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/bargraph.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/grid.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/types.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/arrow.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/snowflake.css" type="text/css" media="screen" />
	<script type='text/javascript' src='js/jquery.js'></script>
	<script type='text/javascript' src='js/highcharts.js'></script>
	<script type='text/javascript' src='js/highcharts.src.js'></script>
	
</head>

<body>
<script>
var chart; // global
		
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		function requestData() {
			$.ajax({
				url: 'live-server-data.php', 
				success: function(point) {
					var series = chart.series[0],
						shift = series.data.length > 20; // shift if the series is longer than 20
		
					// add the point
					chart.series[0].addPoint(eval(point), true, shift);
					
					// call it again after one second
					setTimeout(requestData, 1000);	
				},
				cache: false
			});
		}
			
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'spline',
					events: {
						load: requestData
					}
				},
				title: {
					text: 'Live random data'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150,
					maxZoom: 20 * 1000
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: 'Value',
						margin: 80
					}
				},
				series: [{
					name: 'Random data',
					data: []
				}]
			});		
		});
		</script>
		
		
<script type="text/javascript">
		
			var chart2;
			$(document).ready(function() {
				chart2 = new Highcharts.Chart({
					chart: {
						renderTo: 'container2',
						defaultSeriesType: 'column'
					},
					xAxis: {
						categories: ['Andrew', 'Christopher', 'Peter']
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Active Jobs'
						}
					},
					legend: {
						align: 'right',
						x: -100,
						verticalAlign: 'top',
						y: 20,
						floating: true,
						backgroundColor: '#FFFFFF',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>'+
								 'Total: '+ this.point.stackTotal;
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal'
						}
					},
				    series: [{
						name: 'Active',
						data: [5, 3, 4]
					}, {
						name: 'Stagnant',
						data: [2, 2, 3]
					}, {
						name: 'Very Stagnant',
						data: [3, 4, 4]
					}]
				});
				
				
			});
				
		</script>
<section id="statusboard">

		<div id="container2" style="width: 800px; height: 400px; margin: 0 auto"></div>
				<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>


</section>	

<footer></footer>
</body>
</html>