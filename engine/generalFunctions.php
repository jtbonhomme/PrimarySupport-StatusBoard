<?php

function pCase($string) {
	$string = strtolower($string);
	$string = substr_replace($string, strtoupper(substr($string, 0, 1)), 0, 1);
	
	return $string;
}

function uCase($string) {
	$string = strtoupper($string);
		
	return $string;
}

function autoPluralise ($singular, $plural, $count = 1) {
	// fantasticly clever function to return the correct plural of a word/count combo
	// Usage:	$singular	= single version of the word (e.g. 'Bus')
	//       	$plural 	= plural version of the word (e.g. 'Busses')
	//			$count		= the number you wish to work out the plural from (e.g. 2)
	// Return:	the singular or plural word, based on the count (e.g. 'Jobs')
	// Example:	autoPluralise("Bus", "Busses", 3)  -  would return "Busses"
	//			autoPluralise("Bus", "Busses", 1)  -  would return "Bus"

	return ($count == 1)? $singular : $plural;
} // END function autoPluralise

function showBlocker($string = "BLOCKER!") {
	$output  = "<span class=\"blocker\" id='blocker_icon'>M</span>";
	
	return $output;
}
?>