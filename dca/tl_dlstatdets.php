<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 * 
 * Module Download Statistics
 *
 * Log file downloads done by the content elements Download and Downloads, and 
 * show statistics in the backend. 
 *
 *
 * ----- Derived from dlstats 1.0.0 (2009-06-11) -----
 * ---------- Peter Koch (acenes) 2007-2009 ----------
 * 
 * This is the data container array for table tl_dlstatdets.
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_dlstatdets, Deprecated
 */
$GLOBALS['TL_DCA']['tl_dlstatdets'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'			=> 'Table',
		'ptable'				=> 'tl_dlstats',
		'closed'				=> true,
		'notEditable'			=> true
	),

	// List
	'list' => array
	(	
		'sorting' => array
		(
			'mode'					=> 4,
			'fields'				=> array('tstamp DESC','ip'),
			'headerFields'			=> array('filename', 'tstamp', 'downloads'),
			'panelLayout'			=> 'search,limit',
			'child_record_callback'	=> array('tl_dlstatdets', 'listRecords'),
			'disableGrouping' => true
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'			=> 'act=select',
				'class'			=> 'header_edit_all',
				'attributes'	=> 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'delete' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_dlstatdets']['delete'],
				'href'			=> 'act=delete',
				'icon'			=> 'delete.gif',
				'attributes'	=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'tstamp,ip,username'
	),

	// Fields
	'fields' => array
	(
		'tstamp' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstatdets']['tstamp'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>20, 'rgxp'=>'datim')
		),
		'ip' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstatdets']['ip'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>40, 'nospace'=>true)
		),
		'username' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstatdets']['username'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>64, 'nospace'=>true)
		),
		'domain' => array
		(
		        'label'			=> &$GLOBALS['TL_LANG']['tl_dlstatdets']['domain'],
		        'exclude'		=> true,
		        'search'		=> true,
		        'inputType'		=> 'text',
		        'eval'			=> array('mandatory'=>true, 'maxlength'=>64, 'nospace'=>true)
		)
	)
);

/**
 * Class tl_dlstatdets
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_dlstatdets extends Backend
{
	/**
	 * List a particular record
	 */
	public function listRecords($row)
	{
	    $this->import('String');
		return
			'<div class="dlstatdets">'
		  . '<span class="dlstats-timestamp dlstats-left">'.date($GLOBALS['TL_CONFIG']['datimFormat'],$row['tstamp']).'</span>'
		  . '<span class="dlstats-ip dlstats-left">'.$row['ip'].'<br>'.$this->String->substr($row['domain'],50).'</span>'
		  . '<span class="dlstats-username dlstats-left">'.$this->String->substr($row['username'],30).'</span>'
		  . '</div>';
	} // listRecords
	
} // class tl_dlstatdets

?>