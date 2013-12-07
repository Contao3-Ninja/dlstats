<?php 

/**
 * TL_ROOT/system/modules/dlstats/languages/de/tl_settings.php 
 * 
 * Contao extension: dlstats 
 * Language file for modules (de)
 * 
 * Copyright : &copy; 2013 
 * License   : LGPL 
 * Author    : Glen Langer (BugBuster)
 * Translator: Glen Langer (BugBuster)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['dlstats_legend'] = "Downloadstatistik";
$GLOBALS['TL_LANG']['tl_settings']['dlstats']        = array("Downloadstatistik","Aktivieren, um die Aufstellung von Downloadstatistiken zu ermöglichen.");
$GLOBALS['TL_LANG']['tl_settings']['dlstatdets']     = array("Detailerfassung für die Downloadstatistik","Aktivieren, um zusätzlich IP, Domain und Benutzername zu erfassen.");

$GLOBALS['TL_LANG']['tl_settings']['dlstatDisableBotdetection'] = array("Die Botdetection Filterung deaktivieren", "Die Filterung der Zählung durch die Erweiterung Botdetection deaktivieren");

$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP4'] = array("Stärke der Anonymisierung bei IPv4", "Hier kann die Stärke der IPv4 Anonymisierung verändert werden. Contao IP-Anonymisierung muss aktiviert sein.");
$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP6'] = array("Stärke der Anonymisierung bei IPv6", "Hier kann die Stärke der IPv6 Anonymisierung verändert werden. Contao IP-Anonymisierung muss aktiviert sein.");

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][1] = 'Oktetts: 1 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'][2] = 'Oktetts: 2';

$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][2] = 'Blöcke: 2 (Contao Default)';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][3] = 'Blöcke: 3';
$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'][4] = 'Blöcke: 4';
