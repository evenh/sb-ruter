# Ruter Panel for Status Board

Gives you the departure times for public transport in Oslo and surrounding areas. Inspired by [SB_BL](https://github.com/carlfranzon/SB_SL).

## How to install?
1. Clone this repo or download a zip
2. Upload to the webserver of your choice
3. Edit `config.php`

## How to set up?
1. Please [register](http://ruter.no/no/Om-Ruter/Om_Trafikanten/registrering/) to use Ruters open API.
2. Find your stop ID at [ruter.no](http://ruter.no). Go to the real time tab and search for your stop. The ID should be in URL.    
   *Example*: For the stop **Nationaltheateret [T-bane]** the URL is `http://reiseplanlegger.ruter.no/no/Stoppested/(3010031)Nationalth [...]` and the stop ID is 3010031.
3. Add your stop to the `config.php` if you want this to be the default location, otherwhise use it as an URL parameter.
4. If you want to enable static filtering of lines, edit the array in `config.php`. This will override the URL parameter.

## How to use?
1. Add a new table view in Status Board. The URL is different depending on whether you have set a static stop in `config.php`or not.
	1. If set: `http://yourserver.com/sb-ruter/ruter.php?direction=(1|2)`
	2. If not set: `http://yourserver.com/sb-ruter/ruter.php?stop=XXXXXX&direction=(1|2)`
2. You can optionally filter out the lines you want to see by adding `&filter=11,17` to the URL. This will only show lines 11 and 17.
3. If you want to ignore departures leaving in less than X minutes, uncomment line 5 in `config.php` and modify to suit your needs.

## Screenshots

<a href="http://i.imgur.com/ZkYnZ2x.png"><img alt="Horizontal" src="http://i.imgur.com/ZkYnZ2xm.png"></a>
<a href="http://i.imgur.com/dhG69du.png"><img alt="Vertical" src="http://i.imgur.com/dhG69dum.png"></a>

## Contributors
- [langtind](https://github.com/langtind)

## Notes
If you find any bugs, please open an issue.
