<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 * 
 * Modul Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, 
 * and show statistics in the backend. 
 *
 *
 * ----- Derived from dlstats 1.0.0 (2009-06-11) -----
 * ---------- Peter Koch (acenes) 2007-2009 ----------
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */


/**
 * Class Dlstats
 * 
 * @copyright  Glen Langer 2011
 * @author     Glen Langer 
 * @package    GLDLStats
 * @license    LGPL
 */
class Dlstats extends Controller
{
	/**
	 * Log the download
	 * @param	string	$fileName	Filename, Hook Parameter
	 * @return void
	 */
	public function logDownload($fileName)
	{
		if ( isset($GLOBALS['TL_CONFIG']['dlstats']) && $GLOBALS['TL_CONFIG']['dlstats'] === true ) 
		{
			$this->import('Database');
			$q = $this->Database->prepare("SELECT * FROM `tl_dlstats` WHERE `filename`=?")
							    ->execute($fileName);
			if ($q->next()) {
				$statId = $q->id;
				$this->Database->prepare("UPDATE `tl_dlstats` SET `tstamp`=?, `downloads`=`downloads`+1 WHERE `id`=?")
							   ->execute(time(), $statId);
			} else {
				$q = $this->Database->prepare("INSERT INTO `tl_dlstats` %s")
						  ->set(array('tstamp'=>time(), 'filename'=>$fileName, 'downloads'=>1))
						  ->execute();
				$statId = $q->insertId;
			} // if			
			if ( isset($GLOBALS['TL_CONFIG']['dlstatdets']) && $GLOBALS['TL_CONFIG']['dlstatdets'] === true ) 
			{
				$ip = $this->Environment->ip;
				$username = '';
				$ckie = 'FE_USER_AUTH';
				$sid  = session_id();
				$hash = sha1($sid.$ip.$ckie);
				if ($this->Input->cookie($ckie) == $hash) 
				{
					$qs = $this->Database->prepare("SELECT * FROM `tl_session` WHERE `hash`=? AND `name`=?")
										 ->execute($hash, $ckie);
					if ($qs->next() && 
						$qs->sessionID == $sid && 
						$qs->ip == $ip && 
						($qs->tstamp+$GLOBALS['TL_CONFIG']['sessionTimeout']) > time() ) 
					{
						$qm = $this->Database->prepare("SELECT `username` FROM `tl_member` WHERE id=?")
											 ->execute($qs->pid);
						if ($qm->next()) {
							$username = $qm->username;
						}
					} // if
				} // if
				$this->Database->prepare("INSERT INTO `tl_dlstatdets` %s")
							   ->set(array('tstamp'=>time(), 'pid'=>$statId, 'ip'=>$ip, 'username'=>$username))
							   ->execute();
			} // if
		} // if
	} // logDownload
	
} // class Dlstats

?>