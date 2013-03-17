<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads 
 * and show statistics in the backend. 
 *
 *
 * ----- Derived from dlstats 1.0.0 (2009-06-11) -----
 * ---------- Peter Koch (acenes) 2007-2009 ----------
 * 
 * Module configuration file.
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

define('DLSTATS_VERSION', '2.3');
define('DLSTATS_BUILD'  , '0');

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['BE_MOD']['content']['dlstats'] = array
(
        'callback'   => 'ModuleDlstatsStatistics',
        'icon'       => 'system/modules/dlstats/html/icon.png',
        'stylesheet' => 'system/modules/dlstats/html/mod_dlstatsstatistics_be.css',
);
/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_HOOKS']['postDownload'][] = array('Dlstats', 'logDownload');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ModuleDlstatsTag', 'DlstatsReplaceInsertTags');

/**
 * -------------------------------------------------------------------------
 * syncCto Blacklists - Tables
 * -------------------------------------------------------------------------
 */
$GLOBALS['SYC_CONFIG']['table_hidden'] = array_merge( (array) $GLOBALS['SYC_CONFIG']['table_hidden'], array(
        'tl_dlstats',
        'tl_dlstatdets',
));

?>