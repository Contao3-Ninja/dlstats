<?php
/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Module Download Statistics
 *
 * PHP version 5
 * @copyright  Glen Langer 2011..2015 <http://contao.ninja>
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
 * Class ModuleDlstatsStatistics
 *
 * @copyright  Glen Langer 2011..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
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

    protected $intTopDownloadLimit  = 20;
    protected $intLastDownloadLimit = 20;
    protected $intCalendarDaysLimit = 30;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ( isset($GLOBALS['TL_CONFIG']['dlstatTopDownloads'])
         && intval($GLOBALS['TL_CONFIG']['dlstatTopDownloads']) >0)
        {
            $this->intTopDownloadLimit = intval($GLOBALS['TL_CONFIG']['dlstatTopDownloads']);
        }
        if ( isset($GLOBALS['TL_CONFIG']['dlstatLastDownloads'])
                && intval($GLOBALS['TL_CONFIG']['dlstatLastDownloads']) >0)
        {
            $this->intLastDownloadLimit = intval($GLOBALS['TL_CONFIG']['dlstatLastDownloads']);
        }

        if (\Input::get('act',true)=='zero')
        {
            $this->setZero();
        }
        if (\Input::get('act',true)=='delete')
        {
            $this->deleteCounter();
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
        $this->Template->arrTopDownloads  = $this->getTopDownloads($this->intTopDownloadLimit);
        $this->Template->arrLastDownloads = $this->getLastDownloads($this->intLastDownloadLimit);
        $this->Template->arrCalendarDayDownloads = $this->getCalendarDayDownloads($this->intCalendarDaysLimit);

        $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['downloads_top20']   =
            sprintf($GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['downloads_top20']  , $this->intTopDownloadLimit);
        $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_20_downloads'] =
            sprintf($GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_20_downloads'], $this->intLastDownloadLimit);
        $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_30_calendar_days'] =
            sprintf($GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_30_calendar_days'], $this->intCalendarDaysLimit);

        $this->Template->dlstats_version  = $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['modname'] . ' ' . DLSTATS_VERSION .'.'. DLSTATS_BUILD;

        $this->Template->dlstats_hook_panels = $this->addStatisticPanelLineHook();

    }

    /**
     * Statistic, set on zero
     */
    protected function setZero()
    {
        \Database::getInstance()->prepare("TRUNCATE TABLE tl_dlstatdets")->execute();
        \Database::getInstance()->prepare("TRUNCATE TABLE tl_dlstats")->execute();
        return ;
    }

    /**
     * Delete a counter
     */
    protected function deleteCounter()
    {
        if ( is_null( \Input::get('dlstatsid',true) ) )
        {
            return ;
        }
        \Database::getInstance()->prepare("DELETE FROM tl_dlstatdets WHERE pid=?")
                                ->execute(\Input::get('dlstatsid',true));
        \Database::getInstance()->prepare("DELETE FROM tl_dlstats    WHERE  id=?")
                                ->execute(\Input::get('dlstatsid',true));
        return ;
    }

    /**
     * Get Counting Status
     * @return string
     */
    protected function getStatusCounting()
    {
        if ( isset($GLOBALS['TL_CONFIG']['dlstats'])
                && (bool) $GLOBALS['TL_CONFIG']['dlstats'] === true
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
                && (bool) $GLOBALS['TL_CONFIG']['dlstats'] === true
          && isset($GLOBALS['TL_CONFIG']['dlstatdets'])
                && (bool) $GLOBALS['TL_CONFIG']['dlstatdets'] === true
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
                && (bool) $GLOBALS['TL_CONFIG']['privacyAnonymizeIp'] === true
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
        $objMonth = \Database::getInstance()->prepare("SELECT
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
        $objYear = \Database::getInstance()->prepare("SELECT
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
        $objTODL = \Database::getInstance()->prepare("SELECT
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
        $objStartDate = \Database::getInstance()->prepare("SELECT
                                                           MIN(`tstamp`) AS YMD
                                                           FROM `tl_dlstatdets`
                                                           WHERE 1")
                                                ->execute();
        if ($objStartDate->YMD !== null)
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
        $objTopDownloads = \Database::getInstance()->prepare("SELECT `tstamp`, `filename`, `downloads`, `id`
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
                                          , $objTopDownloads->downloads //no formatted number for sorting
                                          , $objTopDownloads->tstamp //for sorting
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
        $objLastDownloads = \Database::getInstance()->prepare("SELECT `tstamp`, `filename`, `downloads`, `id`
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
                    $newDate  = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objLastDownloads->tstamp);
                    $viewDate = $newDate;
                }
                $c4d = $this->check4details($objLastDownloads->id);
                $arrLastDownloads[] = array( $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objLastDownloads->tstamp)
                                           , $objLastDownloads->filename
                                           , $this->getFormattedNumber($objLastDownloads->downloads,0)
                                           , $viewDate
                                           , $objLastDownloads->id
                                           , $c4d
                                           , $objLastDownloads->downloads // for sorting
                                           , $objLastDownloads->tstamp // for sorting
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
        $objC4D = \Database::getInstance()->prepare("SELECT count(`id`)  AS num
                                                     FROM `tl_dlstatdets`
                                                     WHERE `pid`=?")
                                          ->execute($id);
        return $objC4D->num;
    }

    /**
     * Get Calendar Day Downloads
     *
     * @param number $limit optional
     * @return array $arrCalendarDayDownloads
     */
    protected function getCalendarDayDownloads($limit=30)
    {
        $arrCalendarDayDownloads = array();
        $CalendarDays = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-$limit, date("Y") ) );
        $objCalendarDayDownloads = \Database::getInstance()
                                    ->prepare("SELECT dl.`id`
                                                    , FROM_UNIXTIME(det.`tstamp`,GET_FORMAT(DATE,'ISO')) as datum
                                                    , count(dl.`filename`) as downloads
                                                    , dl.`filename`
                                                FROM `tl_dlstats` dl
                                                INNER JOIN `tl_dlstatdets` det on dl.id = det.pid
                                                WHERE FROM_UNIXTIME(det.`tstamp`,GET_FORMAT(DATE,'ISO')) >=?
                                                GROUP BY dl.`id`, datum
                                                ORDER BY datum DESC, `filename`")
                                    ->execute($CalendarDays);

        while ($objCalendarDayDownloads->next())
        {
            $viewDate = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($objCalendarDayDownloads->datum) );
            $c4d = $this->check4details($objCalendarDayDownloads->id);
            $arrCalendarDayDownloads[] = array(
                                      $viewDate
                                    , $objCalendarDayDownloads->filename
                                    , $this->getFormattedNumber($objCalendarDayDownloads->downloads,0)
                                    , $objCalendarDayDownloads->id
                                    , $c4d
                                    , $objCalendarDayDownloads->downloads
                                    , strtotime($objCalendarDayDownloads->datum)
                                );
        }

        return $arrCalendarDayDownloads;
    }

    /**
     * Hook: addStatisticPanelLine
     * Search for registered DLSTATS HOOK: addStatisticPanelLine
     *
     * @return    string    HTML5 sourcecode | false
     * <code>
     * <!-- output minimum -->
     * <div class="tl_panel">
     *  <!-- <p>hello world</p> -->
     * </div>
     * </code>
     */
    protected function addStatisticPanelLineHook()
    {
        if (isset($GLOBALS['TL_DLSTATS_HOOKS']['addStatisticPanelLine'])
            && is_array($GLOBALS['TL_DLSTATS_HOOKS']['addStatisticPanelLine']))
        {
            foreach ($GLOBALS['TL_DLSTATS_HOOKS']['addStatisticPanelLine'] as $callback)
            {
                $this->import($callback[0]);
                $result[] = $this->{$callback[0]}->{$callback[1]}();
            }
            return $result;
        }
        return false;
    }
}
