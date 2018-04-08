<?php 
	include "database.php";

	// function getData() {
	// 	$curl = curl_init();
	// 	$curlOpts = [
	// 		CURLOPT_URL => "https://api.coindesk.com/v1/bpi/currentprice.json", 
	// 		CURLOPT_RETURNTRANSFER => true
	// 	];
	
	// 	curl_setopt_array($curl, $curlOpts);
	
	// 	$result = curl_exec($curl);
	// 	curl_close($curl);
	
	// 	if (!$result) {
	// 		return $curl;
	// 	}
	// 	else {
	// 		$result = createDBArray(json_decode($result, true));
	// 	    return $result;
	// 	}	
	// }
	
	function getData() {
		$curl = curl_init();
		$curlOpts = [
			CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/?convert=GBP&limit=20", 
			CURLOPT_RETURNTRANSFER => true
		];
	
		curl_setopt_array($curl, $curlOpts);
	
		$result = curl_exec($curl);
		curl_close($curl);
	
		if (!$result) {
			return $curl;
		}
		else {
			$result = createDBArray(json_decode($result, true));
		    return $result;
		}	
	}
	
	// Turns result into array ready to be passed to DB function
	// function createDBArray($arr) {
	// 	$ratesArray = [];
	// 	foreach($arr['bpi'] as $key => $value) {
	// 		$ratesArray[$key] = $value['rate'];
	// 	}
	// 	insertData($ratesArray);
	// 	return $ratesArray;
	// }
	
	function createDBArray($arr) {
		$dbArray = [];
		foreach($arr as $key => $value) {
			$dbArray[$value['id']] = $value['price_gbp'];
		}
		$val = insertData($dbArray);
		return $val;
	}

?>