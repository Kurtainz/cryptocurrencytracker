<?php
    include "database.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>There Will Be Graphs</title>
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono" rel="stylesheet">
        <link rel="stylesheet" href="styles/main.css" type="text/css" />
    </head>
    <body>
        
        <h1 id="mainHeader">Cryptocurrency Rates</h1>
        
        <label for="select">Graph Type</label>
        <select name="barType" id="chartSelect">
            <option value="line" selected>Line</option>
            <option value="bar">Bar</option>
        </select>
        
        <div id="main">
        </div>
        <p>All rates in GBP</p>
        <script type="text/javascript" src="/node_modules/chart.js/dist/Chart.js"></script>
        <script type="text/javascript" src="js/statistics.js"></script>
    </body>
</html>
