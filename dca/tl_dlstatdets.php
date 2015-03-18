<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, and 
 * show statistics in the backend. 
 *
 *
 * This is the data container array for table tl_dlstatdets.
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
 * Table tl_dlstatdets
 */
$GLOBALS['TL_DCA']['tl_dlstatdets'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_dlstats',
        'closed'           => true,
        'notEditable'      => true,
        'sql' => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' => 'index'
            )
        )
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'       => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'ip' => array
        (
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'username' => array
        (
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'domain' => array
        (
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'page_host' => array
        (
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'page_id' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'browser_lang' => array
        (
             'sql'       => "varchar(10) NOT NULL default ''"
        )
    )
);

