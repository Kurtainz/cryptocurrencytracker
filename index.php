<?php 
	include 'getData.php';
	
	getData();
	
	$newData = getFromDatabase();
	$latestRates = [];
	
	// Loop through and check ID number, if greater change to that. 
	// Need to get that row from the array
	foreach($newData as $currency => $currencyArray) {
		$id = 0;
		foreach(array_column($currencyArray, 'id') as $rowid) {
			if (intval($rowid) > $id) {
				$id = intval($rowid);
			}
		}
		$latestRowIndex = array_search((string)$id, array_column($currencyArray, 'id'));
		$latestRow = $currencyArray[$latestRowIndex];
		$currencyString = ucfirst($currency);
		echo "<h1>The current rate in GBP for $currencyString is " . $latestRow['rate'] . "</h1>";
	}
	
	
	// foreach($newData as $key => $value) {
	// 	var_dump($value);
	// 	echo "<h1>END</h1>";
	// }
	
	// $curl = curl_init();
	// $curlOpts = [
	// 	CURLOPT_URL => "https://api.coindesk.com/v1/bpi/currentprice.json", 
	// 	CURLOPT_RETURNTRANSFER => true
	// ];

	// curl_setopt_array($curl, $curlOpts);

	// $result = curl_exec($curl);
	// curl_close($curl);

	// if ($result === false) {
	// 	$result = curl_error($curl);
	// }
	// else {
	//     $result = json_decode($result, true);
	//     foreach($result['bpi'] as $currency => $array) {
	//         $currencyCode = $array['code'];
	//         $rate = $array['rate'];
	//         $html = "<h1>Value of Bitcoin in $currencyCode is: $rate</h1>";
	//         echo $html;
	//     }
	// }
	
?>