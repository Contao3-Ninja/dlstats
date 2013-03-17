<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 * 
 * Module Download Statistics
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require('../../initialize.php');

/**
 * Class ModuleDlstatsStatisticsDetails
 *
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 */
class ModuleDlstatsStatisticsDetails extends ModuleDlstatsStatisticsHelper
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
        if ( is_null( $this->Input->get('action'   ,true) ) ||
             is_null( $this->Input->get('dlstatsid',true) ) )
        {
            echo '<html><body><p class="tl_error">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['wrong_parameter'].'</p></body></html>';
            return ;
        }
        
        switch ($this->Input->get('action',true))
        {
            case 'TopLastDownloads' :
                $DetailFunction = 'getDlstatsDetails'.$this->Input->get('action',true);
                echo $this->$DetailFunction( $this->Input->get('action',true), $this->Input->get('dlstatsid',true) );
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

?>