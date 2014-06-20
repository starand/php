create table categories (
  `catId` int(10) unsigned NOT NULL auto_increment,
  `catName` varchar(100) NOT NULL,
  `catDescription` varchar(255) NOT NULL,
  PRIMARY KEY  (`catId`)
);

create table items (
  `itId` int(10) unsigned NOT NULL auto_increment,
  `itName` varchar(255) NOT NULL,
  `itCatId` int(10) unsigned NOT NULL,
  `itDesc` text NOT NULL,
  `itCount` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`itId`)
);

CREATE TABLE `files` (
  `fileId` int(10) unsigned NOT NULL auto_increment,
  `fileName` varchar(255) NOT NULL,
  `fileCont` mediumblob NOT NULL,
  `fileMd5` varchar(32) NOT NULL default '0',
  `fileDesc` varchar(255) NOT NULL,
  `fileItemId` int(10) unsigned NOT NULL,
  `fileType` varchar(255) NOT NULL,
  PRIMARY KEY  (`fileId`),
  UNIQUE KEY `fileName` (`fileName`),
  UNIQUE KEY `fileMd5` (`fileMd5`)
);

CREATE TABLE `transistors` (
	`trId` int(10) unsigned NOT NULL auto_increment,
	`trName` varchar(32) NOT NULL,
	`trAnalogue` varchar(32) NOT NULL,
	`trReplacement` varchar(32) default NULL,
	PRIMARY KEY  (`trId`)
);