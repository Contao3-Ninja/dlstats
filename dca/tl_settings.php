<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
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
 * @copyright  Glen Langer (BugBuster) 2012..2013
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
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['dlstats']		= 'dlstatdets,dlstatAnonymizeIP4,dlstatAnonymizeIP6'; 


/**
 * Add field
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstats'] = array
        (
            'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstats'],
            'inputType'	=> 'checkbox',
            'eval'		=> array('submitOnChange'=>true)
        );
$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatdets'] = array
        (
            'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstatdets'],
            'inputType'	=> 'checkbox'
        );
$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatAnonymizeIP4'] = array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP4'],
			'inputType' => 'select',
			'default'   => 1,
			'options'   => array(1, 2),
			'reference' => &$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip4'],
			'eval'      => array('tl_class'=>'w50')
	    );
$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatAnonymizeIP6'] = array
	    (
            'label'     => &$GLOBALS['TL_LANG']['tl_settings']['dlstatAnonymizeIP6'],
            'inputType' => 'select',
            'default'   => 2,
            'options'   => array(2, 3, 4),
            'reference' => &$GLOBALS['TL_LANG']['tl_settings']['dlstats']['anonip6'],
            'eval'      => array('tl_class'=>'w50')
	    );


?>