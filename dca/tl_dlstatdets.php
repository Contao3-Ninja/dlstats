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
 * @copyright  Glen Langer (BugBuster) 2012..2013
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
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
        )
    )
);

