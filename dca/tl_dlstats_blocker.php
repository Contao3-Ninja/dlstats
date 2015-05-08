<?php

/**
 * Table tl_dlstats_blocker
 */
$GLOBALS['TL_DCA']['tl_dlstats_blocker'] = array
(
        // Config
        'config' => array
        (
                'sql' => array
                (
                        'keys' => array
                        (
                                'id'  => 'primary'
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
                'dlstats_tstamp' => array
                (
                        'sql'       => "timestamp NULL"
                ),
                'dlstats_ip' => array
                (
                        'sql'       => "varchar(40) NOT NULL default '0.0.0.0'"
                ),
                'dlstats_filename' => array
        		(
        			'sql'           => "varchar(255) NOT NULL default ''"
        		)
        )
);
