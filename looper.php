<?php 
    include 'getData.php';
    
    while(true) {
        $request = getData();
        if (is_array($request)) {
    		$message = "Insertion successful ;) " . date("H:i") . "\n";
    	}
    	else {
    	    $message = "An error occured X(\n" . curl_error($request);
    	    var_dump($request);
    	}
    	
    // 	echo $message;
    	
    // 	$logfile = 'log.txt';
    // 	$newLogText = $message . date("d/m/y - H:i:s") . "\n";
    // 	file_put_contents($logfile, $newLogText, FILE_APPEND);
    	sleep(600);
    }
    