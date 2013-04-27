<?php
// Config
define("API_SERVER"	, "http://api.trafikanten.no");
define("STOP"		, "3010057");
/* define("RUTER_PATH"	, "http://localhost/sb-ruter"); // Path to your installation (if you want to override automatic detection) - No trailing slash */

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
?>
