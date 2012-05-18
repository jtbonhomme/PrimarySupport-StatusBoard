<link rel="stylesheet" href="modules2/marquee/marquee.css" type="text/css" media="screen" />

<?php
function micro_status($twitter_id, $hyperlinks = true) {
	$c = curl_init();
	
	if (is_numeric($twitter_id)) {
		curl_setopt($c, CURLOPT_URL, "http://identi.ca/api/statuses/user_timeline/$twitter_id.xml?count=1");

	} else {
		curl_setopt($c, CURLOPT_URL, "http://twitter.com/statuses/user_timeline/$twitter_id.xml?count=1");

	}
	
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($c, CURLOPT_TIMEOUT, 5);
	
	// proxy curl stuff
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($c, CURLOPT_PROXY, "http://t4140.theocn.net:8080"); 
	curl_setopt($c, CURLOPT_PROXYPORT, 8080); 
	
	$response = curl_exec($c);
	$responseInfo = curl_getinfo($c);
	curl_close($c);
	
	if (intval($responseInfo['http_code']) == 200) {
		if (class_exists('SimpleXMLElement')) {
			$xml = new SimpleXMLElement($response);
			return $xml;
		} else {
			return $response;
		}
	} else {
		return false;
	}
}
?>

<?php
	$tweets = "";
	
	// twitter usernames, or identi.ca number id's
	// the function will use identi.ca for numbers, and twitter for usernames
	$twits = array('bbcnews', 'CollinMel', 'wscommunityart', 'exanetworks');
	
	if (!$completed == TRUE) {
		foreach ($twits AS $twit) {
			if ($twitter_xml = micro_status($twit)) {
				foreach ($twitter_xml->status as $key => $status) {
					$img = "<img src=\"" . $status->user->profile_image_url . "\" width=\"30\" height=\"30\"> ";
					$tweets .= $img . uCase($status->text);
					$tweets .= "  .  ";
				
					++$i;
					$completed = TRUE;
			
					if ($i == 1) break;
					}
			} else {
				//$tweets .= uCase("Twitter seems to be unavailable at the moment");
				//$tweets .= "  .  ";
				$completed = FALSE;
		}
	}

}
?>

<div id="marquee">
	<div class="scroll">
		<?php echo $tweets; ?>
	</div>
</div>