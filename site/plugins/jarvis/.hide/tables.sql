create table notifications
(
	nId int unsigned not null auto_increment,
	nMsg varchar(128) not null,
	nTheme varchar(64) not null,
	nLevel tinyint not null default 1,
	nTime datetime not null,
	primary key(nId)
);

create table modules
(
	mId int unsigned not null auto_increment,
	mName varchar(20) not null,
	mPath varchar(128) not null,
	primary key(mId)
);