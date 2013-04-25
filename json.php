<?php
// Even Holthe - 2013
// http://evenh.net

// Require our config
require('config.php');

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


// Fetch data
$json = json_decode(file_get_contents(API_SERVER."/ReisRest/RealTime/GetRealTimeData/$stop"), true);

// Functions - some fetched from http://bit.ly/17UsfnH
function cleandate($date){ return substr($date,6,10);}
function cmp($a,$b){return strcmp($a["sort"], $b["sort"]);}
function showtime($seconds){ 
    if ($seconds<45) {
        $time = NOW;
    }
    elseif ($seconds>=45 && $seconds<=104){
        $time=1; 
    }
    elseif ($seconds>=105 && $seconds<=164){
        $time=2; 
    }
    elseif ($seconds>=165 && $seconds<=224){
        $time=3; 
    }
    elseif ($seconds>=225 && $seconds<=284){
        $time=4; 
    }
    elseif ($seconds>=285 && $seconds<=344){
        $time=5; 
    }
    elseif ($seconds>=345 && $seconds<=404){
        $time=6;
    }
    elseif ($seconds>=405 && $seconds<=464){
        $time=7; 
    }
    elseif ($seconds>=465 && $seconds<=524){
        $time=8; 
    }
    elseif ($seconds>=525 && $seconds<=584){
        $time=9; 
    }
    elseif ($seconds>=585){
        $time=false; 
    }
	
	if(is_numeric($time)){
    	$time=$time.' min'; 
	}

	return $time;
}

// Empty counters
$i = 0;
$j = 0;

// Loop through data
foreach($json as $pt){ // pt = public transport
	$ptTime = cleandate($pt['AimedArrivalTime']);
	$now 	= time();
	$time 	= showtime($ptTime-$now);

	if(!$time){
		$time = date("H:i", $ptTime);
	}

    // In what direction?
    if($pt['DirectionRef'] == 1){ // Towards the city
        $to[$i]['line'] = $pt['LineRef'];
        $to[$i]['dest'] = str_ireplace("stasjon", "st.", $pt['DestinationDisplay']);
        $to[$i]['time'] = $time;
        $to[$i]['sort'] = $ptTime;

        $i++;
    } else { // Away from the city
        $from[$j]['line'] = $pt['LineRef'];
        $from[$j]['dest'] = str_ireplace("stasjon", "st.", $pt['DestinationDisplay']);
        $from[$j]['time'] = $time;
        $from[$j]['sort'] = $ptTime;

        $j++;
    }
}

// Sort the data
if(!empty($to   )){ usort($to   , "cmp"); }
if(!empty($from )){ usort($from , "cmp"); }

// Output the data as JSON
header('Content-type: application/json');

// Output JSON
if($direction == 1){
    echo json_encode($to);
} elseif($direction == 2){
    echo json_encode($from);
} else {
    die("Invalid direction specified. Valid values: 1 or 2.");
}
?>