<?php
// Config
define("API_SERVER"	, "http://api.trafikanten.no");
define("STOP"		, "3010057");
/* define("IGNORE_MIN" , 5); // Ignore departures that leaves in less than 5 minutes */
/* define("RUTER_PATH"	, "http://localhost/sb-ruter"); // Path to your installation (if you want to override automatic detection) - No trailing slash */

// If you want to specify which line(s) to show, uncomment this and set in line number(s). This will override lines specified in the URL.
// $lines = array("11", "17");

// Localization
define("NOW"		, "Nå");
define("DEPARTURE"	, "Avgang");
define("FROM_TOWN"	, "Fra byen");
define("TO_TOWN"	, "Mot byen");

// Error messages if the API is down.
// Add as many as you like to fit your screen
$apiDown[0] = "Service down";
$apiDown[1] = "";
$apiDown[2] = "Will update until";
$apiDown[3] = "service is restored";

// Turn off error reporting
error_reporting(0);

// Sets timeout for fetching JSON (and all other data) to 20 seconds
ini_set("default_socket_timeout", 20);
?>
