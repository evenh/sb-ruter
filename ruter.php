<?php
// Even Holthe - 2013
// http://evenh.net

// Output UTF-8
header('Content-Type: text/html; charset=utf-8');

// Require our config and functions
require('config.php');
require('functions.php');

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

// Generate a path, unless overriden in config
if(!defined('RUTER_PATH')){
	define("RUTER_PATH", getPath());
} else {
	if(RUTER_PATH == ''){
		die("Please specify a valid RUTER_PATH like 'http://localhost/sb-ruter'.");
	}
}

// URL for querying json.php
$url = RUTER_PATH."/json.php?direction=$direction&stop=$stop";

// Fetch data
$data = fetchJSON($url);

// Did we manage to fetch data from json.php?
if(!$data){
	die("Please check RUTHER_PATH in config.php. Either the built-in path detector doesn't work or your specified path is wrong.");
}
?>
<table id="ruterRT">
	<tr>
		<th style="width:55px;text-align:center"><img src="logo.png" height="30px" /></th>
        <th style="padding-left:2%;text-align:left;"><?php echo getNameForStop($stop);?> <?php if(!$is_down){if($direction==1){echo '('.TO_TOWN.')';} elseif($direction==2){echo '('.FROM_TOWN.')';}}?></th>
        <th style="width:105px;text-align:center"><?php echo DEPARTURE; ?></th>
	</tr>
	<?php
	// Loop through travel data and output
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
