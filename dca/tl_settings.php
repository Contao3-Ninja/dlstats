<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, and 
 * show statistics in the backend. 
 *
 *
 * ----- Derived from dlstats 1.0.0 (2009-06-11) -----
 * ---------- Peter Koch (acenes) 2007-2009 ----------
 * 
 * Extends module tl_settings.
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2012
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][]	= 'dlstats'; 
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default']	   .= ';{dlstats_legend},dlstats'; 
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['dlstats']		= 'dlstatdets'; 

/**
 * Add field
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstats'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstats'],
	'inputType'	=> 'checkbox',
	'eval'		=> array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatdets'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstatdets'],
	'inputType'	=> 'checkbox'
);

?>