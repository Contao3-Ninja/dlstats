<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 * 
 * Modul Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, 
 * and show statistics in the backend. 
 *
 * 
 * PHP version 5
 * @copyright  Glen Langer 2011..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @author     Peter Koch (acenes) 2007-2009
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
 * Class Dlstats
 * 
 * @copyright  Glen Langer 2011..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLDLStats
 * @license    LGPL
 */
class Dlstats extends \DLStats\DlstatsHelper
{

	/**
	 * tl_dlstats.id
	 * @var integer
	 */
	private $_statId = 0;

	/**
	 * File name for logging
	 * @var string
	 */
	private $_filename = '';

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Log the download over $GLOBALS['TL_HOOKS']['postDownload']
	 * @param	string	$fileName	Filename, Hook Parameter
	 * @return void
	 */
	public function logDownload($fileName)
	{
		$this->_filename = $fileName;
		
		if (isset($GLOBALS['TL_CONFIG']['dlstats']) && $GLOBALS['TL_CONFIG']['dlstats'] == true)
		{
			if ($this->DL_LOG === true)
			{
				$this->logDLStats();
				$this->logDLStatDetails();
			}
		}
	}

	/**
	 * Helper function log file name
	 * @return void
	 */
	protected function logDLStats()
	{
		$q = \Database::getInstance()->prepare("SELECT id FROM `tl_dlstats` WHERE `filename`=?")
                                     ->execute($this->_filename);
		if ($q->next())
		{
			$this->_statId = $q->id;
			\Database::getInstance()->prepare("UPDATE `tl_dlstats` SET `tstamp`=?, `downloads`=`downloads`+1 WHERE `id`=?")
                                    ->execute(time(), $this->_statId);
		}
		else
		{
			$q = \Database::getInstance()->prepare("INSERT IGNORE INTO `tl_dlstats` %s")
                                         ->set(array('tstamp' => time(), 
                                                     'filename' => $this->_filename, 
                                                     'downloads' => 1)
                                              )
                                         ->execute();
			$this->_statId = $q->insertId;
		} // if
	}

	/**
	 * Helper function log details
	 * @return void
	 */
	protected function logDLStatDetails()
	{
	    //Host / Page ID ermitteln
	    global $objPage;
	    $pageId = $objPage->id; // ID der grad aufgerufenden Seite.
	    $pageHost = \Environment::get('host'); // Host der grad aufgerufenden Seite.
	    
	    if (isset($GLOBALS['TL_CONFIG']['dlstatdets']) 
	           && $GLOBALS['TL_CONFIG']['dlstatdets'] == true
	       )
	    {
	        //Maximum details for year & month statistic
            $username = '';
    		$strCookie = 'FE_USER_AUTH';

    		$hash = sha1(session_id() . (!$GLOBALS['TL_CONFIG']['disableIpCheck'] ? $this->IP : '') . $strCookie);
    		if (\Input::cookie($strCookie) == $hash)
    		{
    			$qs = \Database::getInstance()->prepare("SELECT pid, tstamp, sessionID, ip 
                                                         FROM `tl_session` WHERE `hash`=? AND `name`=?")
                                              ->execute($hash, $strCookie);
    			if ($qs->next() && 
    				$qs->sessionID == session_id() && 
    				($GLOBALS['TL_CONFIG']['disableIpCheck'] || $qs->ip == $this->IP) && 
    				($qs->tstamp + $GLOBALS['TL_CONFIG']['sessionTimeout']) > time())
    			{
    				$qm = \Database::getInstance()->prepare("SELECT `username` 
                                                             FROM `tl_member` WHERE id=?")
                                                  ->execute($qs->pid);
    				if ($qm->next())
    				{
    					$username = $qm->username;
    				}
    			} // if
    		} // if

    		\Database::getInstance()->prepare("INSERT INTO `tl_dlstatdets` %s")
            						->set(array('tstamp'    => time(), 
            						            'pid'       => $this->_statId, 
            						            'ip'        => $this->dlstatsAnonymizeIP(), 
            						            'domain'    => $this->dlstatsAnonymizeDomain(), 
            						            'username'  => $username,
            						            'page_host' => $pageHost,
            						            'page_id'   => $pageId,
            						            'browser_lang' => $this->dlstatsGetLang()
            						            )
            						        )
                                    ->execute();
	    }
	    else
	    {
	        //Minimum details for year & month statistic
	        \Database::getInstance()->prepare("INSERT INTO `tl_dlstatdets` %s")
                                    ->set(array('tstamp'    => time(), 
                                                'pid'       => $this->_statId
                                               )
                                         )
                                    ->execute();
	    }
	}

} // class Dlstats
