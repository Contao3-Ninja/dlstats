-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- --------------------------------------------------------

-- 
-- Table `tl_dlstats`
-- 

CREATE TABLE `tl_dlstats` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `downloads` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `filename` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_dlstatdets`
-- 

CREATE TABLE `tl_dlstatdets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `pid` int(10) unsigned NOT NULL default '0',
  `ip` varchar(64) NOT NULL default '',
  `domain` varchar(64) NOT NULL default '',
  `username` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
