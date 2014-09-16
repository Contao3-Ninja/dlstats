<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Dlstats
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'BugBuster\DLStats\Dlstats'                        => 'system/modules/dlstats/modules/Dlstats.php',
	'BugBuster\DLStats\ModuleDlstatsStatistics'        => 'system/modules/dlstats/modules/ModuleDlstatsStatistics.php',
	'BugBuster\DLStats\DlstatsTestIP'                  => 'system/modules/dlstats/modules/DlstatsTestIP.php',
	'BugBuster\DLStats\ModuleDlstatsTag'               => 'system/modules/dlstats/modules/ModuleDlstatsTag.php',

	// Public
	'BugBuster\DLStats\ModuleDlstatsStatisticsDetails' => 'system/modules/dlstats/public/ModuleDlstatsStatisticsDetails.php',

	// Classes
	'BugBuster\DLStats\ModuleDlstatsStatisticsHelper'  => 'system/modules/dlstats/classes/ModuleDlstatsStatisticsHelper.php',
	'BugBuster\DLStats\DlstatsCheck'                   => 'system/modules/dlstats/classes/DlstatsCheck.php',
	'BugBuster\DLStats\DlstatsHelper'                  => 'system/modules/dlstats/classes/DlstatsHelper.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_dlstats_be_statistics'      => 'system/modules/dlstats/templates',
	'mod_dlstats_be_partial_details' => 'system/modules/dlstats/templates',
	'mod_dlstats_fe_test_ip'         => 'system/modules/dlstats/templates',
));
