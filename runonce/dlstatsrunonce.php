<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Download Statistics"
 *
 * @copyright  Glen Langer 2011..2013 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats 
 * @license    LGPL 
 * @filesource
 * @see	       https://github.com/BugBuster1701/dlstats
 */

/**
 * Class DLStatsRunonce
 *
 * Runonce for DLStats
 *
 * @copyright  Glen Langer 2011..2013 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 */
class DLStatsRunonce extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	}
	public function run()
	{
	    if (is_file(TL_ROOT . '/system/modules/dlstats/config/database.sql'))
	    {
	        $objFile = new File('system/modules/dlstats/config/database.sql');
	        $objFile->delete();
	        $objFile->close();
    		$objFile=null;
    		unset($objFile);
	    }
	}
}

$objDLStatsRunonce = new DLStatsRunonce();
$objDLStatsRunonce->run();
