<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Download Statistics Helper
 *
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * Class ModuleDlstatsStatisticsHelper
 *
 * @copyright  Glen Langer (BugBuster) 2011..2013
 * @author     BugBuster
 * @package    GLDLStats
 */
class ModuleDlstatsStatisticsHelper extends BackendModule
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
        $this->import('BackendUser', 'User');
        parent::__construct();
    }
    
    
    protected function compile()
    {
    
    }
    /**
     * Return the current object instance (Singleton)
     * @return BotStatisticsHelper
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new ModuleDlstatsStatisticsHelper();
        }
    
        return self::$instance;
    }
    
    protected function getDlstats($dlstatsid)
    {
        $objDlstats = $this->Database->prepare("SELECT *
                                                 FROM `tl_dlstats`
                                                 WHERE `id`=?")
                           ->execute($dlstatsid);
        return array('tstamp'    => $objDlstats->tstamp,
                     'filename'  => $objDlstats->filename,
                     'downloads' => $objDlstats->downloads);
    }
    
    protected function getDlstatsDetailsTopLastDownloads($action,$dlstatsid)
    {
        $arrDlstats = $this->getDlstats($dlstatsid);
        
        $this->TemplatePartial = new BackendTemplate('mod_dlstats_be_partial_details');
        
        $this->TemplatePartial->DlstatsDetailList  = '<div class="tl_header" style="">'."\n";
        
        $this->TemplatePartial->DlstatsDetailList .= '<table class="tl_header_table">
    <tbody>
        <tr>
            <td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['filename'].':</span> </td>
            <td>'.$arrDlstats['filename'].'</td>
        </tr>
        <tr>
            <td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_download'].':</span> </td>
            <td>'.$this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrDlstats['tstamp']).'</td>
        </tr>
        <tr>
            <td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['downloads'].':</span> </td>
            <td>'.$arrDlstats['downloads'].'</td>
        </tr>
    </tbody>
    </table>
</div>'
;
        
        $this->TemplatePartial->DlstatsDetailList .= '<div class="tl_content" style="">
     <div class="dlstatdets">
        <span class="dlstats-timestamp dlstats-left" style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['tstamp'].'</span>
        <span class="dlstats-ip dlstats-left"        style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['ip'].'</span>
        <span class="dlstats-username dlstats-left"  style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['username'].'</span>
        <span class="clear"></span>
    </div>
</div>'
;
        
        $this->TemplatePartial->DlstatsDetailList .= '<div class="dlstatdetailcontent" style="">';
        $objDetails = $this->Database->prepare("SELECT `tstamp` , `ip` , `domain` , `username`
                                                FROM `tl_dlstatdets`
                                                WHERE `pid`=?
                                                ORDER BY `id` DESC")
                                     ->limit(1000)
                                     ->execute($dlstatsid);
        $intRows = $objDetails->numRows;
        if ($intRows>0)
        {
            while ($objDetails->next())
            {
                if ($objDetails->username == '')
                {
                    $un = "&nbsp;";
                }
                else
                {
                    $un = $objDetails->username;
                } 
                $this->TemplatePartial->DlstatsDetailList .=  '<div class="dlstatdetaillist">
    <span class="dlstats-timestamp dlstats-left">'.$this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objDetails->tstamp).'</span>
    <span class="dlstats-ip        dlstats-left">'.$objDetails->ip.'<br>'.$objDetails->domain.'</span>
    <span class="dlstats-username  dlstats-left">'.$un.'</span>
    <span class="clear"></span>
</div>'
;
            }
        }
        
        $this->TemplatePartial->DlstatsDetailList .= '</div>'."\n";
        
        
        
        return $this->TemplatePartial->parse();
    }
    
    
    
    
}
