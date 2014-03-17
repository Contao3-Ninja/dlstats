<?php 

/**
 * TL_ROOT/system/modules/dlstats/languages/de/tl_settings.php 
 * 
 * Contao extension: dlstats
 * Language file for modules (en).
 * 
 * Copyright : &copy; 2013
 * License   : LGPL 
 * Author    : Glen Langer (BugBuster)
 * Translator: Glen Langer (BugBuster)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['dlstats_legend'] = "Download statistics";
$GLOBALS['TL_LANG']['tl_settings']['dlstats']        = array('Enable counting', 'Activate to counting of downloads.');
$GLOBALS['TL_LANG']['tl_settings']['dlstatdets']     = array('Enable detailed logging and statistic', 'Activate to additional logging for IP, Domain and Member name.');

$GLOBALS['TL_LANG']['tl_settings']['dlstatDisableBotdetection'] = array("Disable Bot Detection filtering", "Disable the filtering of counting by the extension Bot Detection");

$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP4'] = array("Anonymization level for IPv4", "Here, you can change the level of anonymization for IPv4. Anonymize IP addresses in Contao must be activated.");
$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP6'] = array("Anonymization level for IPv6", "Here, you can change the level of anonymization for IPv6. Anonymize IP addresses in Contao must be activated.");

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][1] = 'Octets: 1 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][2] = 'Octets: 2';

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][2] = 'Groups: 2 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][3] = 'Groups: 3';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][4] = 'Groups: 4';

$GLOBALS['TL_LANG']['tl_settings']['dlstatTopDownloads']  = array("Number of items for the TOP downloads" , "In the statistic the number of items for the TOP downloads");
$GLOBALS['TL_LANG']['tl_settings']['dlstatLastDownloads'] = array("Number of items for the last downloads", "In the statistic the number of items for the last downloads");
