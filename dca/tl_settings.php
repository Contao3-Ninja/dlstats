<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, and 
 * show statistics in the backend. 
 *
 * Extends module tl_settings.
 * 
 * PHP version 5
 * @copyright  Glen Langer 2011..2013 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/dlstats
 */

/**
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][]	= 'dlstats'; 
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default']	   .= ';{dlstats_legend},dlstats'; 
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['dlstats']		= 'dlstatdets,dlstatDisableBotdetection,dlstatAnonymizeIP4,dlstatAnonymizeIP6,dlstatTopDownloads,dlstatLastDownloads'; 

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
	'inputType'	=> 'checkbox',
    'eval'      => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatDisableBotdetection'] = array
(
        'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstatDisableBotdetection'],
        'inputType'	=> 'checkbox',
        'eval'      => array('tl_class'=>'w50')
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

$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatTopDownloads'] = array
(
        'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstatTopDownloads'],
        'inputType'	=> 'text',
        'default'	=> '20',
        'eval'		=> array('mandatory'=>true, 'rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['dlstatLastDownloads'] = array
(
        'label'		=> &$GLOBALS['TL_LANG']['tl_settings']['dlstatLastDownloads'],
        'inputType'	=> 'text',
        'default'	=> '20',
        'eval'		=> array('mandatory'=>true, 'rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
);
