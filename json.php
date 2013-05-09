<?php
// Even Holthe - 2013
// http://evenh.net

// Require our config and functions
require('config.php');
require('functions.php');

// This widget is only useful if location == Oslo
date_default_timezone_set('Europe/Oslo');

// No caching
header('Cache-Control: no-cache, must-revalidate');

// Check if the stop is overriden
if(!empty($_GET['stop']) && is_numeric($_GET['stop'])){
	$stop = @$_GET['stop'];
} else {
	$stop = STOP;
}

// Get the direction
$direction = @$_GET['direction'];
if(!is_numeric($direction) || empty($direction)){
    die("Please specify a valid direction in the URL. Valid values: 1 or 2.");
}

// Should we filter by lines?
if(!isset($lines) && isset($_GET['lines']) && !empty($_GET['lines'])){
    $lines = explode(',',$_GET['lines']);
}

// Output the data as JSON
header('Content-type: application/json');

// Fetch data
$json = fetchJSON(API_SERVER."/ReisRest/RealTime/GetRealTimeData/$stop");

if($json){
    // Empty counters
    $i = 0;
    $j = 0;

    // Loop through data
    foreach($json as $pt){ // pt = public transport

        if (count(@$lines) > 0 && !in_array($pt->LineRef, @$lines)) continue;

        $ptTime = cleandate($pt->AimedArrivalTime);
        $now    = time();
        $time   = showtime($ptTime-$now);

        if(!$time){
            $time = date("H:i", $ptTime);
        }

        // In what direction?
        if($pt->DirectionRef == 1){ // Towards the city
            $to[$i]['line'] = $pt->LineRef;
            $to[$i]['dest'] = str_ireplace("stasjon", "st.", $pt->DestinationDisplay);
            $to[$i]['time'] = $time;
            $to[$i]['sort'] = $ptTime;

            $i++;
        } else { // Away from the city
            $from[$j]['line'] = $pt->LineRef;
            $from[$j]['dest'] = str_ireplace("stasjon", "st.", $pt->DestinationDisplay);
            $from[$j]['time'] = $time;
            $from[$j]['sort'] = $ptTime;

            $j++;
        }
    }

    // Sort the data
    if(!empty($to   )){ usort($to   , "cmp"); }
    if(!empty($from )){ usort($from , "cmp"); }

    // Output JSON
    if($direction == 1){
        echo json_encode($to);
    } elseif($direction == 2){
        echo json_encode($from);
    } else {
        die("Invalid direction specified. Valid values: 1 or 2.");
    }
} else {
    // If the API is down
    for($i=0;$i<count($apiDown);$i++){
        $error[$i]['line'] = $i+1;
        $error[$i]['dest'] = $apiDown[$i];
        $error[$i]['time'] = "Err";
    }

    echo json_encode($error);
}
?>
