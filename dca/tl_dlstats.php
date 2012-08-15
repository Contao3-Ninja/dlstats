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
 * This is the data container array for table tl_dlstats.
 * 
 * PHP version 5
 * @copyright  Glen Langer (BugBuster) 2011
 * @author     BugBuster
 * @package    GLDLStats
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_dlstats
 */
$GLOBALS['TL_DCA']['tl_dlstats'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'			=> 'Table',
		'ctable'				=> array('tl_dlstatdets'),
		'closed'				=> true
	),

	// List
	'list' => array
	(	
		'sorting' => array
		(
			'mode'				=> 2,
			'fields'			=> array('downloads desc','filename','tstamp'),
			'panelLayout'		=> 'sort,search,limit'
		),
		'label' => array(
			'fields'			=>	array('tstamp','downloads','filename'),
			'format'			=>	'%s %s %s',
			'label_callback'	=>	array('tl_dlstats', 'listRecords')
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
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_dlstats']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_dlstats']['delete'],
				'href'			=> 'act=delete',
				'icon'			=> 'delete.gif',
				'attributes'	=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'			=> &$GLOBALS['TL_LANG']['tl_dlstats']['details'],
				'href'			=> 'table=tl_dlstatdets',
				'icon'			=> 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'filename,downloads'
	),

	// Fields
	'fields' => array
	(
		'filename' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstats']['filename'],
			'exclude'		=> true,
			'search'		=> true,
			'sorting'		=> true,
			'flag'			=> 1,
			'inputType'		=> 'fileTree',
			'eval'			=> array('fieldType'=>'radio', 'files'=>true, 'mandatory'=>true)
		),
		'tstamp' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstats']['tstamp'],
			'exclude'		=> true,
			'sorting'		=> true,
			'flag'			=> 6,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>20, 'rgxp'=>'datim')
		),
		'downloads' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_dlstats']['downloads'],
			'exclude'		=> true,
			'sorting'		=> true,
			'flag'			=> 12,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxlength'=>10, 'rgxp'=>'digit')
		)
	)
);

/**
 * Class tl_dlstats
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_dlstats extends Backend
{
	/**
	 * List a particular record
	 */
	public function listRecords($row)
	{
		return 
			'<span class="dlstats-timestamp dlstats-left">'.date($GLOBALS['TL_CONFIG']['datimFormat'],$row['tstamp']).'</span> '
		  .	'<span class="dlstats-downloads dlstats-left">'.$row['downloads'].'</span> '
		  .	'<span class="dlstats-filename">'.$row['filename'].'</span>';
	} // listRecords
	
} // class tl_dlstats

?>