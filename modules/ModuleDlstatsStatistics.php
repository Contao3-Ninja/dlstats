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
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\DLStats;

/**
 * Class ModuleDlstatsStatistics
 *
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 */
class ModuleDlstatsStatistics extends \BackendModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_dlstats_be_statistics';
    
    /**
     * Detailed Statistic
     * @var boolean
     */
    protected $boolDetails = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (\Input::get('act',true)=='zero') 
        {
            $this->setZero();
        }
    }
    
    /**
     * Generate module
     */
    protected function compile()
    {
        $this->loadLanguageFile('tl_dlstatstatistics_stat');
        
        $this->Template->href   = $this->getReferer(true);
        $this->Template->status_counting = $this->getStatusCounting();
        $this->Template->status_detailed = $this->getStatusDetailed();
        $this->Template->status_anonymization = $this->getStatusAnonymization();
        $this->Template->boolDetails = $this->boolDetails;
        
        $this->Template->theme  = $this->getTheme();

        $this->Template->arrStatMonth     = $this->getMonth();
        $this->Template->arrStatYear      = $this->getYear();
        $this->Template->totalDownloads   = $this->getTotalDownloads();
        $this->Template->startdate        = $this->getStartDate();
        $this->Template->arrTopDownloads  = $this->getTopDownloads();
        $this->Template->arrLastDownloads = $this->getLastDownloads();
        
        $this->Template->dlstats_version  = $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['modname'] . ' ' . DLSTATS_VERSION .'.'. DLSTATS_BUILD;

    }
    
    /**
     * Statistic, set on zero
     */
    protected function setZero()
    {
        $this->Database->prepare("TRUNCATE TABLE tl_dlstatdets")->execute();
        $this->Database->prepare("TRUNCATE TABLE tl_dlstats")->execute();
        return ;
    }
    
    /**
     * Get Counting Status
     * @return string
     */
    protected function getStatusCounting()
    {
        if ( isset($GLOBALS['TL_CONFIG']['dlstats']) 
                && $GLOBALS['TL_CONFIG']['dlstats'] == true  
           ) 
        {
            return '<span class="tl_green">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_activated'].'</span>';
        }
        return '<span class="tl_red">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_deactivated'].'</span>';
    }
    
    /**
     * Get Detailed Logging Status
     * @return string
     */
    protected function getStatusDetailed()
    {
        if ( isset($GLOBALS['TL_CONFIG']['dlstats']) 
                && $GLOBALS['TL_CONFIG']['dlstats'] == true
          && isset($GLOBALS['TL_CONFIG']['dlstatdets'])
                && $GLOBALS['TL_CONFIG']['dlstatdets'] == true
           )
        {
            return '<span class="tl_green">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_activated'].'</span>';
        }
        $this->boolDetails = false;
        return '<span class="">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_deactivated'].'</span>';
    }
    
    /**
     * Get Status Anonymization
     * @return string
     */
    protected function getStatusAnonymization()
    {
        if ( isset($GLOBALS['TL_CONFIG']['privacyAnonymizeIp'])
                && $GLOBALS['TL_CONFIG']['privacyAnonymizeIp'] == true
        )
        {
            return $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_activated'];
        }
        return $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['status_deactivated'];
    }
    
    /**
     * Monthly Statistics, last 12 Months
     * @return array
     */
    protected function getMonth()
    {
        $arrMonth = array();
        $objMonth = $this->Database->prepare("SELECT 
                                                FROM_UNIXTIME(`tstamp`,'%Y-%m')  AS YM
                                              , COUNT(`id`) AS SUMDL
                                              FROM `tl_dlstatdets` 
                                              WHERE 1 
                                              GROUP BY YM
                                              ORDER BY YM DESC")
                                   ->limit(12)
                                   ->execute();
        $intRows = $objMonth->numRows;
        if ($intRows>0) 
        {
            while ($objMonth->next()) 
            {
                $Y = substr($objMonth->YM, 0,4);
                $M = (int)substr($objMonth->YM, -2);
                $arrMonth[] = array($Y.' '.$GLOBALS['TL_LANG']['MONTHS'][($M - 1)], $this->getFormattedNumber($objMonth->SUMDL,0) );
            }
        }
        
        return $arrMonth;
    }
    
    /**
     * Years Statistic, last 12 years
     * @return array
     */
    protected function getYear()
    {
        $arrYear = array();
        $objYear = $this->Database->prepare("SELECT
                                                FROM_UNIXTIME(`tstamp`,'%Y')  AS Y
                                              , COUNT(`id`) AS SUMDL
                                              FROM `tl_dlstatdets`
                                              WHERE 1
                                              GROUP BY Y
                                              ORDER BY Y DESC")
                                  ->limit(12)
                                  ->execute();
        $intRows = $objYear->numRows;
        if ($intRows>0)
        {
            while ($objYear->next())
            {
                // Y, formatierte Zahl, unformatierte Zahl
                $arrYear[] = array($objYear->Y, $this->getFormattedNumber($objYear->SUMDL,0),$objYear->SUMDL );
            }
        }
    
        return $arrYear;
    }
    
    /**
     * Total Downloads
     * @return number
     */
    protected function getTotalDownloads()
    {
        $totalDownloads = 0;
        $objTODL = $this->Database->prepare("SELECT
                                             SUM( `downloads` ) AS TOTALDOWNLOADS
                                             FROM `tl_dlstats`
                                             WHERE 1")
                                  ->execute();
        $intRows = $objTODL->numRows;
        if ($intRows>0)
        {
            $totalDownloads = $this->getFormattedNumber($objTODL->TOTALDOWNLOADS,0);
        }
        
        return $totalDownloads;
    }
    
    /**
     * Get Startdate of detailed logging
     * @return string    Date
     */
    protected function getStartDate()
    {
        $StartDate = false;
        $objStartDate = $this->Database->prepare("SELECT 
                                                  MIN(`tstamp`) AS YMD
                                                  FROM `tl_dlstatdets`
                                                  WHERE 1")
                                       ->execute();
        if ($objStartDate->YMD != null)
        {
            $StartDate = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objStartDate->YMD);
            
        }
        
        return $StartDate;
    }
    
    /**
     * Get TOP Downloadlist
     * @param number $limit    optional
     * @return array    $arrTopDownloads
     */
    protected function getTopDownloads($limit=20)
    {
        $arrTopDownloads = array();
        $objTopDownloads = $this->Database->prepare("SELECT `tstamp`, `filename`, `downloads`, `id`
                                                     FROM `tl_dlstats`
                                                     ORDER BY `downloads` DESC")
                                          ->limit($limit)
                                          ->execute();
        $intRows = $objTopDownloads->numRows;
        if ($intRows>0)
        {
            while ($objTopDownloads->next())
            {
                $c4d = $this->check4details($objTopDownloads->id);
                $arrTopDownloads[] = array( $objTopDownloads->filename
                                          , $this->getFormattedNumber($objTopDownloads->downloads,0)
                                          , $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objTopDownloads->tstamp)
                                          , $objTopDownloads->id
                                          , $c4d
                                          );
            }
        }
        
        return $arrTopDownloads;
    }
    
    /**
     * Get Last Downloadslist
     * @param numbner $limit    optional
     * @return array    $arrLastDownloads
     */
    protected function getLastDownloads($limit=20)
    {
        $newDate = '02.02.1971';
        $oldDate = '01.01.1970';
        $viewDate = false;
        $arrLastDownloads = array();
        $objLastDownloads = $this->Database->prepare("SELECT `tstamp`, `filename`, `downloads`, `id`
                                                     FROM `tl_dlstats`
                                                     ORDER BY `tstamp` DESC, `filename`")
                                          ->limit($limit)
                                          ->execute();
        $intRows = $objLastDownloads->numRows;
        if ($intRows>0)
        {
            while ($objLastDownloads->next())
            {
                $viewDate = false;
                if ($oldDate != $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objLastDownloads->tstamp)) 
                {
                    $newDate = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objLastDownloads->tstamp);
                    $viewDate = $newDate;
                }
                $c4d = $this->check4details($objLastDownloads->id);
                $arrLastDownloads[] = array( $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objLastDownloads->tstamp)
                                           , $objLastDownloads->filename
                                           , $this->getFormattedNumber($objLastDownloads->downloads,0)
                                           , $viewDate
                                           , $objLastDownloads->id
                                           , $c4d
                                           );
                $oldDate = $newDate;
            }
        }
        
        return $arrLastDownloads;
    }
    
    /**
     * Get Number of Logged Details
     * @param number $id    pid of file
     * @return number
     */
    protected function check4details($id)
    {
        $objC4D = $this->Database->prepare("SELECT count(`id`)  AS num
                                            FROM `tl_dlstatdets`
                                            WHERE `pid`=?")
                                 ->execute($id);
        return $objC4D->num;
    }
    
}
