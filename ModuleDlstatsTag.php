<?php

if (! defined('TL_ROOT'))
	die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Modul Dlstats Tag - Frontend for InsertTags
 *
 * PHP version 5
 * @copyright  Glen Langer 2011
 * @author     Glen Langer 
 * @package    GLDLStats 
 * @license    LGPL 
 * @filesource
 */

/**
 * Class ModuleDlstatsTag 
 *
 * @copyright  Glen Langer 2011
 * @author     Glen Langer 
 * @package    GLDLStats
 * @license    LGPL 
 */
class ModuleDlstatsTag extends Frontend
{

	/**
	 * replaceInsertTags
	 * 
	 * From TL 2.8 you can use prefix "cache_". Thus the InserTag will be not cached. (when "cache" is enabled)
	 * 
	 *       dlstats::totaldownloads::filename - Total downloads for filename
	 * cache_dlstats::totaldownloads::filename - Total downloads for filename (not cached)
	 * 
	 * <code>
	 * {{cache_dlstats::totaldownloads::tl_files/cdc2010.pdf}}
	 * {{cache_dlstats::totaldownloads::CDC_2010.html?file=tl_files/cdc2010.pdf}}
	 * // in the ce_download template:
	 * {{cache_dlstats::totaldownloads::<?php echo $this->href; ?>}}
	 * // in the ce_downloads template:
	 * {{cache_dlstats::totaldownloads::<?php echo $file['href']; ?>}}
	 * </code>
	 * 
	 * @param string    $strTag Insert-Tag
	 * @return mixed    integer on downloads, false on wrong Insert-Tag or wrong parameters
	 * @access public
	 */
	public function DlstatsReplaceInsertTags($strTag)
	{
		$arrTag = trimsplit('::', $strTag);
		if ($arrTag[0] != 'dlstats')
		{
			if ($arrTag[0] != 'cache_dlstats')
			{
				return false; // not for us
			}
		}
		$this->loadLanguageFile('tl_dlstats');
		if (! isset($arrTag[2]))
		{
			$this->log($GLOBALS['TL_LANG']['tl_dlstats']['no_key'], 'ModuleDlstatsTag ReplaceInsertTags ', TL_ERROR);
			return false; // da fehlt was
		}
		// filename with article alias?
		if (strpos($arrTag[2], 'file=') !== false)
		{
			$arrTag[2] = substr($arrTag[2], strpos($arrTag[2], 'file=') + 5);
		}
		$this->import('Database');
		if ($arrTag[1] == 'totaldownloads')
		{
			$objDlstats = $this->Database->prepare("SELECT downloads" 
												. " FROM tl_dlstats" 
												. " WHERE filename=?")
										->executeUncached($arrTag[2]);
			if ($objDlstats->numRows < 1)
			{
				return 0;
			}
			$objDlstats->next();
			return $objDlstats->downloads;
		}
		// Tag is wrong 
		$this->log($GLOBALS['TL_LANG']['tl_dlstats']['wrong_key'], 'ModuleDlstatsTag ReplaceInsertTags ', TL_ERROR);
		return false; // wrong tag
	} //function
} // class


?>