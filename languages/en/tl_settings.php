<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
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
$GLOBALS['TL_LANG']['tl_settings']['dlstats']        = array('Enable counting', 'Check to enable counting of downloads.');
$GLOBALS['TL_LANG']['tl_settings']['dlstatdets']     = array('Enable detailed statistics (recommended)', 'Check to enable logging all distinct downloads for detailed statistics.');

$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP4'] = array("Level of the anonymization for IPv4", "Here, you can change the level of anonymization for IPv4. Anonymize IP addresses in Contao must be activated.");
$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP6'] = array("Level of the anonymization for IPv6", "Here, you can change the level of anonymization for IPv6. Anonymize IP addresses in Contao must be activated.");

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][1] = 'Octets: 1 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][2] = 'Octets: 2';

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][2] = 'Groups: 2 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][3] = 'Groups: 3';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][4] = 'Groups: 4';

?>