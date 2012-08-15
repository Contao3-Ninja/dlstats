<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Dlstats
 * @link    http://contao.org
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
	'BugBuster\DLStats\ModuleDlstatsTag' => 'system/modules/dlstats/modules/ModuleDlstatsTag.php',
	'BugBuster\DLStats\Dlstats'          => 'system/modules/dlstats/modules/Dlstats.php',

	// Classes
	'BugBuster\DLStats\DlstatsHelper'    => 'system/modules/dlstats/classes/DlstatsHelper.php',
));
