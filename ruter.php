<?php
// Even Holthe - 2013
// http://evenh.net

// Output UTF-8
header('Content-Type: text/html; charset=utf-8');

// Require our config
require('config.php');

// Get the direction
$direction = @$_GET['direction'];
if(!is_numeric($direction) || empty($direction)){
    die("Please specify a valid direction in the URL. Valid values: 1 or 2.");
}

// Check if the stop is overriden
if(!empty($_GET['stop']) && is_numeric($_GET['stop'])){
	$stop = @$_GET['stop'];
} else {
	$stop = STOP;
}

// Check for valid path
if(RUTER_PATH == ''){
	die("Please specify a valid RUTER_PATH like 'http://localhost/sb-ruter'.");
}

// URL for querying json.php
$url = RUTER_PATH."/json.php?direction=$direction&stop=$stop";

// Gets the name for a stop
function getNameForStop($stop){
	$json = json_decode(file_get_contents(API_SERVER."/ReisRest/Place/FindMatches/$stop"));
	return $json[0]->Name;
}

// Fetch data and decode JSON
$data = json_decode(file_get_contents("$url"));
?>
<table id="ruterRT">
	<tr>
		<th style="width:50px;text-align:center"><img src="logo.png" height="30px" /></th>
        <th style="padding-left:2%;text-align:left;"><?php echo getNameForStop($stop); ?> (<?php if($direction == 1){ echo TO_TOWN; } elseif($direction == 2){ echo FROM_TOWN; } ?>)</th>
        <th style="width:95px;text-align:center"><?php echo DEPARTURE; ?></th>
	</tr>
	<?php
	// Loop through travel data
	foreach($data as $departure){
		echo "
		<tr>
			<td>{$departure->line}</td>
			<td>{$departure->dest}</td>
			<td>{$departure->time}</td>
		</tr>\n";
	}
	?>
</table>