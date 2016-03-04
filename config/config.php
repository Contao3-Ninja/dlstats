<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
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
 * @copyright  Glen Langer 2011..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/dlstats
 */

define('DLSTATS_VERSION', '3.9');
define('DLSTATS_BUILD'  , '2');

/**
 * Defaults, you can overwrite this in Backend -> System -> Settings
 */
$GLOBALS['TL_CONFIG']['dlstatTopDownloads']  = 20;
$GLOBALS['TL_CONFIG']['dlstatLastDownloads'] = 20;

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
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('DLStats\ModuleDlstatsTag', 'dlstatsReplaceInsertTags');

/**
 * -------------------------------------------------------------------------
 * syncCto Blacklists - Tables
 * -------------------------------------------------------------------------
 */
$GLOBALS['SYC_CONFIG']['table_hidden'] = array_merge( (array) $GLOBALS['SYC_CONFIG']['table_hidden'], 
        array(
            'tl_dlstats',
            'tl_dlstatdets',
        )
);

$GLOBALS['SYC_CONFIG']['local_blacklist'] = array_merge( (array) $GLOBALS['SYC_CONFIG']['local_blacklist'], 
        array(
            'dlstatAnonymizeIP4',
            'dlstatAnonymizeIP6',
            'dlstatdets',
            'dlstatDisableBotdetection',
            'dlstatLastDownloads',
            'dlstats',
            'dlstatTopDownloads'
        )
);

/**
 * -------------------------------------------------------------------------
 * FRONT END MODULES ONLY FOR DEBUGGING 
 * -------------------------------------------------------------------------
 */
//$GLOBALS['FE_MOD']['DlstatTestDebug']['testip'] = 'DLStats\DlstatsTestIP';
