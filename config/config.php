<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads 
 * and show statistics in the backend. 
 *
 *
 * Module configuration file.
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2012
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['BE_MOD']['content']['dlstats'] = array(
    'tables'      =>  array('tl_dlstats','tl_dlstatdets'),
    'icon'        =>  'system/modules/dlstats/assets/icon.png',
    'stylesheet'  =>  'system/modules/dlstats/assets/style.css'
);

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_HOOKS']['postDownload'][] = array('DLStats\Dlstats', 'logDownload');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('DLStats\ModuleDlstatsTag', 'DlstatsReplaceInsertTags');

