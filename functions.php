<?php
// Even Holthe - 2013
// http://evenh.net

// Fetches JSON and decodes
function fetchJSON($url){
    global $is_down;

	$fetch = file_get_contents($url);
	if($fetch === false){
        $is_down = true;
		return false;
	} else {
        $is_down = false;
		return json_decode($fetch);
	}
}

// Gets the name for a stop
function getNameForStop($stop){
	$json = fetchJSON(API_SERVER."/ReisRest/Place/FindMatches/$stop");
	if(!$json){
		return "API is down";
	} else {
		return $json[0]->Name;
	}
}

// Get current path on server
function getPath() {
    $server = $_SERVER['HTTP_HOST'];
    $path   = dirname($_SERVER['PHP_SELF']);

    return "http://$server$path";
}


// Some fetched from http://bit.ly/17UsfnH
function cleandate($date){
	return substr($date,6,10);
}

function cmp($a,$b){
	return strcmp($a["sort"], $b["sort"]);
}

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


?>
