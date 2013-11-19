<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
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
 * @copyright  Glen Langer 2011..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/dlstats
 */

define('DLSTATS_VERSION', '3.5');
define('DLSTATS_BUILD'  , '0');

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['BE_MOD']['content']['dlstats'] = array
(
        'callback'   => 'DLStats\ModuleDlstatsStatistics',
        'icon'       => 'system/modules/dlstats/assets/icon.png',
        'stylesheet' => 'system/modules/dlstats/assets/mod_dlstatsstatistics_be.css',
);
/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][]  = array('DLStats\DlstatsCheck', 'checkExtensions');
$GLOBALS['TL_HOOKS']['postDownload'][] = array('DLStats\Dlstats', 'logDownload');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('DLStats\ModuleDlstatsTag', 'DlstatsReplaceInsertTags');

/**
 * -------------------------------------------------------------------------
 * syncCto Blacklists - Tables
 * -------------------------------------------------------------------------
 */
$GLOBALS['SYC_CONFIG']['table_hidden'] = array_merge( (array) $GLOBALS['SYC_CONFIG']['table_hidden'], array(
        'tl_dlstats',
        'tl_dlstatdets',
));
