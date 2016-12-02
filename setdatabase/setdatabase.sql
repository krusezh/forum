drop database forumdatabase;
create database forumdatabase DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

use forumdatabase;

create table userinfo(
	user_id int unsigned not null auto_increment primary key,
	user_name char(50) not null,
	password char(255) not null,
	reg_time datetime not null
);

create table aritle(
	aritle_id int unsigned not null auto_increment primary key,
	parent_id int unsigned not null,
	author_id int unsigned not null,
	post_time datetime not null
);

create table aritle_content(
	aritle_id int unsigned not null auto_increment primary key,
	title char(100) not null,
	hits int unsigned not null,
	node_id int unsigned not null,
	aritle_content text not null
);

create table node(
	node_id int unsigned not null auto_increment primary key,
	node_name char(20) not null
);

create table node_related(
	parent_node_id int unsigned not null,
	son_node_id int unsigned not null
);

grant select,insert
	on forumdatabase.userinfo
	to registeruser identified by '1234567890,.?';
