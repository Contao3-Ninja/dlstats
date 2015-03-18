<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Modul Download Statistics Details - Backend
 *
 * 
 * @copyright  Glen Langer 2011..2013 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/dlstats
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\DLStats;

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');

$dir = __DIR__;
 
while ($dir != '.' && $dir != '/' && !is_file($dir . '/system/initialize.php'))
{
    $dir = dirname($dir);
}
 
if (!is_file($dir . '/system/initialize.php'))
{
    throw new \ErrorException('Could not find initialize.php!',2,1,basename(__FILE__),__LINE__);
}
require($dir . '/system/initialize.php');

/**
 * Class BotStatisticsDetails
 *
 * @copyright  Glen Langer 2012 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotStatistics
 */
class ModuleDlstatsStatisticsDetails extends \DLStats\ModuleDlstatsStatisticsHelper 
{
   
    /**
	 * Set the current file
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct(); 
		$this->User->authenticate(); 
	    $this->loadLanguageFile('tl_dlstatstatistics_stat');
	}
	
	public function run()
	{
	    if ( is_null( \Input::get('action'   ,true) ) ||
             is_null( \Input::get('dlstatsid',true) ) )
	    {
	        echo '<html><body><p class="tl_error">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['wrong_parameter'].'</p></body></html>';
	        return ;
	    }
	
	    switch (\Input::get('action',true))
	    {
	        case 'TopLastDownloads' :
	            $DetailFunction = 'getDlstatsDetails'.$this->Input->get('action',true);
	            echo $this->$DetailFunction( \Input::get('action',true), \Input::get('dlstatsid',true) );
	            break;
	        default:
	            echo '<html><body><p class="tl_error">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['wrong_parameter'].'</p></body></html>';
	            break;
	    }
	    return ;
	}
	
	
}

/**
 * Instantiate
 */
$objModuleDlstatsStatisticsDetails = new ModuleDlstatsStatisticsDetails();
$objModuleDlstatsStatisticsDetails->run();

