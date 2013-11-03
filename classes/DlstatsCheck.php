<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Download Statistics
 * Check the required extensions 
 * 
 * @copyright  Glen Langer 2011..2013 <http://www.contao.glen-langer.de>
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
 * Class DlstatsCheck
 *
 * @copyright  Glen Langer 2011..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 */
class DlstatsCheck extends \System
{
    /**
	 * Current object instance
	 * @var object
	 */
    protected static $instance = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * Return the current object instance (Singleton)
     * @return BotStatisticsHelper
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new DlstatsCheck();
        }
    
        return self::$instance;
    }

    /**
     * Hook: Check the required extensions and files for BotStatistics
     *
     * @param string $strContent
     * @param string $strTemplate
     * @return string
     */
    public function checkExtensions($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main')
        {
            if (!is_array($_SESSION["TL_INFO"]))
            {
                $_SESSION["TL_INFO"] = array();
            }
    
            // required extensions
            $arrRequiredExtensions = array(
                    'BotDetection' => 'botdetection'
            );
    
            // required files
            $arrRequiredFiles = array(
                    'Modulname' => 'plugins/.....'
            );
    
            // check for required extensions
            foreach ($arrRequiredExtensions as $key => $val)
            {
                if (!in_array($val, \Config::getInstance()->getActiveModules() ))
                {
                    $_SESSION["TL_INFO"] = array_merge($_SESSION["TL_INFO"], array($val => 'Please install the required extension <strong>' . $key . '</strong> for the extension dlstats.'));
                }
                else
                {
                    if (is_array($_SESSION["TL_INFO"]) && key_exists($val, $_SESSION["TL_INFO"]))
                    {
                        unset($_SESSION["TL_INFO"][$val]);
                    }
                }
            }
    
            // check for required files
            /*
            foreach ($arrRequiredFiles as $key => $val)
            {
                if (!file_exists(TL_ROOT . '/' . $val))
                {
                    $_SESSION["TL_INFO"] = array_merge($_SESSION["TL_INFO"], array($val => 'Please install the required file/extension <strong>' . $key . '</strong>'));
                }
                else
                {
                    if (is_array($_SESSION["TL_INFO"]) && key_exists($val, $_SESSION["TL_INFO"]))
                    {
                        unset($_SESSION["TL_INFO"][$val]);
                    }
                }
            }*/
        }
    
        return $strContent;
    } // checkExtension
    
} // class
