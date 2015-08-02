<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Module Download Statistics Helper
 *
 * PHP version 5
 * @copyright  Glen Langer 2012..2015 <http://contao.ninja>
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
 * Class ModuleDlstatsStatisticsHelper
 *
 * @copyright  Glen Langer 2012..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 */
class ModuleDlstatsStatisticsHelper extends \BackendModule
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
        $this->loadLanguageFile('default'); // for $GLOBALS['TL_LANG']['MONTHS'][..]
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
        if (self::$instance === null)
        {
            self::$instance = new ModuleDlstatsStatisticsHelper();
        }
    
        return self::$instance;
    }
    
    protected function getDlstats($dlstatsid)
    {
        $objDlstats = \Database::getInstance()->prepare("SELECT *
                                                 FROM `tl_dlstats`
                                                 WHERE `id`=?")
                                              ->execute($dlstatsid);
        return array('tstamp'    => $objDlstats->tstamp,
                     'filename'  => $objDlstats->filename,
                     'downloads' => $objDlstats->downloads);
    }
    
    protected function getDlstatsMonth($dlstatsid)
    {
        $arrMonth = array();
        $objMonth = \Database::getInstance()->prepare("SELECT 
                                                        FROM_UNIXTIME(tstamp, '%Y-%m') AS YM
                                                        , COUNT(`id`) AS SUMDL
                                                      FROM
                                                        `tl_dlstatdets`
                                                      WHERE
                                                        `pid`=?
                                                      GROUP BY YM
                                                      ORDER BY YM DESC")
                                            ->limit(4)
                                            ->execute($dlstatsid);
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
    
    protected function getDlstatsDetailsTopLastDownloads($action,$dlstatsid)
    {
        $arrDlstats      = $this->getDlstats($dlstatsid);
        $arrDlstatsMonth = $this->getDlstatsMonth($dlstatsid);
        
        $this->TemplatePartial = new \BackendTemplate('mod_dlstats_be_partial_details');
        
        $this->TemplatePartial->DlstatsDetailList  = '<div class="tl_header" style="width:800px">'."\n";
        
        $this->TemplatePartial->DlstatsDetailList .= '<table class="tl_header_table">
	<tbody>
		<tr>
			<td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['filename'].':</span> </td>
			<td colspan="3">'.$arrDlstats['filename'].'</td>
		</tr>
		<tr>
			<td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['last_download'].':</span> </td>
			<td>'.$this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrDlstats['tstamp']).'</td>
			<td><span class="tl_label" style="padding-left: 16px; margin-right: 6px;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['total_dl'].':</span></td>
			<td>'.$arrDlstats['downloads'].'</td>
		</tr>
        <tr><td style="line-height: 6px;" colspan="4">&nbsp;</td></tr>
	    <tr>
            <td><span class="tl_label">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['downloads'].':&nbsp;<span title="'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['total_dl_month'].'"><sup style="font-weight:normal;">(?)</sup></span></span></td>
			<td class="tl_label" style="width:     120px; padding-left:  2px; text-align: left;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['period'].':</td>
			<td class="tl_label" style="min-width: 120px; padding-right: 6px; text-align: right;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['downloads'].':</td>
            <td>&nbsp;</td>
		</tr>
';
	foreach ($arrDlstatsMonth AS $Month)
		{
			$this->TemplatePartial->DlstatsDetailList .= '<tr>
			    <td>&nbsp;</td>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list">'.$Month[0].'</td>
			    <td style="padding-left: 2px; padding-right: 6px; text-align: right;" class="tl_file_list">'.$Month[1].'</td>
                <td>&nbsp;</td>
			</tr>
';
        }
        $this->TemplatePartial->DlstatsDetailList .= '
    </tbody>
	</table>
</div>
';

        $this->TemplatePartial->DlstatsDetailList .= '<div class="tl_content" style="margin-top: 10px;width: 800px;">
	 <div class="dlstatdets">
		<span class="dlstats-timestamp dlstats-left" style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['tstamp'].'</span>
		<span class="dlstats-ip dlstats-left"        style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['ip'].'<span title="'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['clientside'].'"><sup style="font-weight:normal;">(?)</sup></span></span>
		<span class="dlstats-hostalias dlstats-left" style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['hostalias'].'<span title="'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['serverside'].'"><sup style="font-weight:normal;">(?)</sup></span></span>
		<span class="dlstats-username dlstats-left"  style="font-weight: bold;">'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['username'].'<span title="'.$GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['browserlang'].'"><sup style="font-weight:normal;">(?)</sup></span></span>
	</div>
</div>
';
        $this->TemplatePartial->DlstatsDetailList .= '<div class="dlstatdetailcontent" style="">';
        $objDetails = \Database::getInstance()->prepare("SELECT `tstamp` , `ip` , `domain` , `username`, `page_host`, `page_id`, `browser_lang`
                                                         FROM `tl_dlstatdets`
                                                         WHERE `pid`=?
                                                         ORDER BY `id` DESC")
                                              ->limit(1000)
                                              ->execute($dlstatsid);
        $intRows = $objDetails->numRows;
        if ($intRows>0)
        {
            $languages = array();
            include_once TL_ROOT . '/system/config/languages.php';
            $languages['unknown'] = 'unknown language';
            
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
                //Alias Name holen über ID
                $page_alias = $this->getPageAliasById($objDetails->page_id);
                // Kürzel in Name übersetzen
              
                if (array_key_exists($objDetails->browser_lang, $languages))
                {
                    $objDetails->browser_lang = $languages[$objDetails->browser_lang];
                }
                
                $this->TemplatePartial->DlstatsDetailList .=  '<div class="dlstatdetaillist">
	<span class="dlstats-timestamp dlstats-left">'.$this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objDetails->tstamp).'</span>
	<span class="dlstats-ip        dlstats-left">'.$objDetails->ip.'<br>'.$objDetails->domain.'</span>
	<span class="dlstats-hostalias dlstats-left">'.$objDetails->page_host.'<br>'.$page_alias.'</span>
	<span class="dlstats-username  dlstats-left"><span class="dlstats-wb">'.$un.'</span><br>'.$objDetails->browser_lang.'</span>
</div>
';
            }
        }
        
        $this->TemplatePartial->DlstatsDetailList .= '</div>'."\n";
        
        return $this->TemplatePartial->parse();
    }
    
    protected function getPageAliasById($page_id)
    {
        if ($page_id == 0) 
        {
            return '';
        }
        $objAlias = \Database::getInstance()->prepare("SELECT
                                                         `alias`
                                                       FROM
                                                         `tl_page`
                                                       WHERE
                                                         `id`=?")
                                            ->limit(1)
                                            ->execute($page_id);
        $intRows = $objAlias->numRows;
        if ($intRows>0)
        {
            return $objAlias->alias;
        }
        else 
        {
            return $GLOBALS['TL_LANG']['tl_dlstatstatistics_stat']['aliasnotfound'];
        }
    }
    
}
