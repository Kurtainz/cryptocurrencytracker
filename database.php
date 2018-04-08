<?php 

    $pdo = new PDO('mysql:host=localhost;dbname=Cryptocurrency', 'kcorbett', '');
    $currencies = [
        'bitcoin', 'ethereum', 
        'litecoin', 'neo', 'ripple'
    ];
    
    function getFromDatabase() {
        global $pdo, $currencies;
        $resultsArr = [];
        
        foreach($currencies as $value) {
            $query = $pdo->prepare("SELECT * FROM $value ORDER BY timestamp DESC LIMIT 10");
            $query->execute();
            $result = $query->fetchAll();
            $resultsArr[$value] = $result;
        }
        return $resultsArr;
    }
    
    function createResultsObj($arr) {
        $resultsArr = [];
        $keyArray = ['currency', 'value', 'timestamp'];
        foreach($arr as $key => $value) {
            $DBRow = [];
            foreach($keyArray as $arrKey) {
                $DBRow[$arrKey] = $value[$arrKey];
            }
            array_push($resultsArr, $DBRow);
        }
        return $resultsArr;
    }
    
    function insertData($data) {
        global $pdo, $currencies;
        $message = 'Insertion successful';
        
        foreach($data as $key => $value) {
            if (in_array($key, $currencies)) {
                $query = $pdo->prepare("INSERT into $key(rate) VALUES(?)");
                try {
                    $query->execute([$value]);
                }
                catch (PDOException $e) {
                    return $e;
                    $message = $e;
                    break;
                }    
            }
        }
        return $message;
    }
    
    if (isset($_GET['getFromDatabase'])) {
        $data = json_encode(getFromDatabase());
        exit($data);
    }