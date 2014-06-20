create table users (
  uId int unsigned not null auto_increment,
  uNick char(15) not null,
  uPswd char(32) not null,
  uMail char(30) not null,
  uRegDate  datetime not null,
  uLastDate datetime not null,
  uIp char(15) not null,
  uStyle tinyint not null default 0,
  uLevel tinyint unsigned not null default 0,
  uSignature varchar(255) not null default '',
  primary key(uId),
  unique key(uMail),
  unique key(uNick)
);


create table styles (
  stId tinyint not null auto_increment,
  stName char(20) not null,
  stPrefix char(10),
  primary key(stId)
);


create table notepad (
  npId int unsigned not null auto_increment,
  npText text not null,
  npUid int unsigned not null,
  npDate datetime not null default '2009-01-01 00:00:00',
  primary key(npId)
);


CREATE TABLE hashes (
  pass varchar(30) NOT NULL default '',
  md5 varchar(32) NOT NULL default '',
  mysql varchar(41) NOT NULL default ''
);


CREATE TABLE peoples (
  psId int(10) unsigned NOT NULL default '0',
  psName varchar(20) NOT NULL default '',
  psMiddleName varchar(20) NOT NULL default '',
  psLastName varchar(20) NOT NULL default '',
  psBirthday varchar(10) NOT NULL default '',
  psBirthPlace varchar(255) NOT NULL default '',
  psTown varchar(13) NOT NULL default '',
  psStreet varchar(35) NOT NULL default '',
  psHouse varchar(4) NOT NULL default '',
  psFlat char(3) default NULL
);


CREATE TABLE t (
  hash char(41) NOT NULL default ''
);


CREATE TABLE forums (
  fId tinyint(3) unsigned NOT NULL auto_increment,
  fName char(30) NOT NULL default 'forum',
  fDesc varchar(255),
  fLTime datetime not null default '',
  PRIMARY KEY  (fId)
);

CREATE TABLE msgs (
  mId int(10) unsigned NOT NULL auto_increment,
  mUid smallint(5) unsigned NOT NULL default '0',
  mDate datetime NOT NULL default '0000-00-00 00:00:00',
  mFid tinyint(3) unsigned NOT NULL default '0',
  mPmsg int(10) unsigned NOT NULL default '0',
  mTheme varchar(100) NOT NULL default 'no theme',
  mMsg mediumtext NOT NULL,
  mOrigMsg mediumtext NOT NULL,
  mIp varchar(15) default NULL,
  mType tinyint(4) NOT NULL default '0',
  mLevel tinyint(3) unsigned NOT NULL default '0',
  mCount int(10) unsigned NOT NULL default '0',
  mStyle tinyint not null default 0,
  PRIMARY KEY  (mId),
  FULLTEXT KEY mMsg (mMsg)
);

create table links (
  lnkId int unsigned not null auto_increment,
  lnkTitle char(50) not null,
  lnkLink varchar(50) not null,
  lnkUid int unsigned not null,
  primary key(lnkId)
);

create table tels (
  tId int unsigned not null auto_increment,
  tName char(50) not null,
  tTel varchar(20) not null,
  tUid int unsigned not null,
  primary key(tId)
);

create table pages
(
pId int not null auto_increment,
pPage varchar(30) not null,
pPath varchar(100) not null,
primary key(pId),
unique key(pPage)
);

CREATE TABLE chat (
  cId int unsigned NOT NULL auto_increment,
  cUid int unsigned NOT NULL default '0',
  cDate datetime NOT NULL default '0000-00-00 00:00:00',
  cMsg text NOT NULL,
  cIp varchar(15) default NULL,
  PRIMARY KEY  (cId)
);

CREATE TABLE links_cat (
  lcId int unsigned NOT NULL auto_increment PRIMARY KEY,
  lcName varchar(100)
);

create table pass (
  pwdId int not null auto_increment primary key,
  pwdPass varchar(30) not null,
  pwdLogin varchar(30) not null,
  pwdHost varchar(30) not null
  unique key(pwdPass, pwdLogin)
);

CREATE TABLE files (
  fileId int(10) unsigned NOT NULL auto_increment,
  filePath varchar(255) NOT NULL,
  fileDesc varchar(255) NOT NULL,
  fileCat tinyint(4) NOT NULL default '1',
  fileCount int unsigned not null
  PRIMARY KEY  (fileId),
  UNIQUE KEY filePath (filePath)
);

create table file_cats (
  fcId tinyint auto_increment primary key,
  fcPid tinyint not null,
  fcDesc varchar(255) not null
);

create table log (
	logId int unsigned auto_increment,
	logUid int unsigned not null,
	logTime datetime not null,
	logMsg varchar(100),
	primary key(logId)
);


CREATE TABLE karma (
  krmId int(10) unsigned NOT NULL auto_increment,
  krmUid int(10) unsigned NOT NULL,
  krmMark tinyint(3) unsigned NOT NULL,
  krmFuid int(10) unsigned NOT NULL,
  krmMid int(10) unsigned NOT NULL,
  PRIMARY KEY  (krmId),
  UNIQUE KEY krmFuid (krmFuid,krmMid)
);


CREATE TABLE attached_files (
  afId int(10) unsigned NOT NULL auto_increment,
  afMid int(10) unsigned NOT NULL,
  afFid int(10) unsigned NOT NULL,
  PRIMARY KEY  (afId),
  UNIQUE KEY afMid (afMid,afFid)
);

CREATE TABLE books (
  bookId int(10) unsigned NOT NULL auto_increment,
  bookPath varchar(255) NOT NULL,
  bookDesc varchar(255) NOT NULL,
  bookCat tinyint(4) NOT NULL default '1',
  bookCount int(10) unsigned NOT NULL,
  bookImage varchar(30) default '',
  PRIMARY KEY  (bookId),
  UNIQUE KEY bookPath (bookPath)
);

CREATE TABLE book_cats (
  bcId tinyint(4) NOT NULL auto_increment,
  bcPid tinyint(4) NOT NULL,
  bcDesc varchar(255) NOT NULL,
  PRIMARY KEY  (bcId)
);

create table copypaste (
  cpId int unsigned not null auto_increment,
  cpUid int unsigned not null,
  cpDate datetime not null,
  cpMsg mediumtext not null,
  primary key(cpId)
);

create table reminders (
  rId int(10) unsigned NOT NULL auto_increment,
  rMsg text NOT NULL,
  rUid int(10) unsigned NOT NULL,
  rTime datetime NOT NULL,
  primary key(rId)
);

CREATE TABLE likes (
  likeMid int(10) unsigned NOT NULL,
  likeUid int(10) unsigned NOT NULL,
  likeType enum('l','d') NOT NULL
);