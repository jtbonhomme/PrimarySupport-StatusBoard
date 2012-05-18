<?php
echo ("<hr />");
echo ("<h1>Primary Support Status</h1>");

/////////////////////////////

function micro_status2($twitter_id, $hyperlinks = true) {
	$c = curl_init();
	
	curl_setopt($c, CURLOPT_URL, "http://ict.wallingford.oxon.sch.uk/primary.module.php");

	
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($c, CURLOPT_TIMEOUT, 5);
	
	// proxy curl stuff
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($c, CURLOPT_PROXY, "http://10.100.249.180:8080"); 
	curl_setopt($c, CURLOPT_PROXYPORT, 8080); 
	
	$response = curl_exec($c);
	$responseInfo = curl_getinfo($c);
	curl_close($c);
	
	if (intval($responseInfo['http_code']) == 200) {
		if (class_exists('SimpleXMLElement')) {
		//	$xml = new SimpleXMLElement($response);
		//	return $xml;
		} else {
		//	return $response;
		}
	} else {
		//return false;
	}
	
	return $response;
}

//////////////////////////////////////
?>

<div class="primary">

<?php
if ($twitter_xml = micro_status2($twit)) {
	echo $twitter_xml;

}
?>
</div>
