drop database forumdatabase;
create database forumdatabase DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

use forumdatabase;

create table userinfo(
	user_id int unsigned not null auto_increment primary key,
	user_name char(50) not null,
	password char(255) not null,
	reg_time datetime not null
);

create table article(
	article_id int unsigned not null auto_increment primary key,
	parent_id int unsigned not null,
	author_id int unsigned not null,
	post_time datetime not null
);

create table article_info(
	article_id int unsigned not null auto_increment primary key,
	title char(100) not null,
	hits int unsigned not null,
	node_id int unsigned not null
);

create table article_content(
	article_id int unsigned not null auto_increment primary key,
	article_content text not null
);

create table tab(
	tab_id int unsigned not null,
	tab_name char(20) not null,
	node_id int unsigned not null
);

create table node(
	node_id int unsigned not null auto_increment primary key,
	node_name char(20) not null
);

create table node_related(
	parent_node_id int unsigned not null,
	son_node_id int unsigned not null
);

grant select,insert,update
	on forumdatabase.*
	to registeruser identified by '1234567890,.?';

insert into tab values
(1,'技术',1),
(1,'技术',2),
(1,'技术',3),
(1,'技术',4),
(1,'技术',5),
(1,'技术',6),
(1,'技术',7),
(1,'技术',8),
(2,'创意',9),
(2,'创意',10),
(2,'创意',11),
(3,'好玩',12),
(3,'好玩',13),
(3,'好玩',14),
(3,'好玩',15),
(3,'好玩',16),
(3,'好玩',17),
(3,'好玩',4),
(3,'好玩',18),
(4,'Apple',29),
(4,'Apple',20),
(4,'Apple',21),
(4,'Apple',22),
(4,'Apple',23),
(4,'Apple',24),
(4,'Apple',25),
(5,'酷工作',26),
(5,'酷工作',27),
(5,'酷工作',28),
(5,'酷工作',29),
(6,'交易',30),
(6,'交易',31),
(6,'交易',32),
(6,'交易',33),
(6,'交易',34),
(6,'交易',35),
(7,'城市',36),
(7,'城市',37),
(7,'城市',38),
(7,'城市',39),
(7,'城市',40),
(7,'城市',41),
(7,'城市',42),
(7,'城市',43),
(7,'城市',44),
(8,'问与答',45);

insert into node values
(1,'程序员'),
(2,'Python'),
(3,'iDev'),
(4,'Android'),
(5,'Linux'),
(6,'Node.js'),
(7,'云计算'),
(8,'宽带症候群'),
(9,'分享创造'),
(10,'设计'),
(11,'奇思妙想'),
(12,'分享发现'),
(13,'电子游戏'),
(14,'电影'),
(15,'剧集'),
(16,'音乐'),
(17,'旅游'),
(18,'分享发现'),
(19,'午夜俱乐部'),
(20,'macOS'),
(21,'iPhone'),
(22,'iPad'),
(23,'MBP'),
(24,'iMac'),
(25,' WATCH'),
(26,'Apple'),
(27,'酷工作'),
(28,'求职'),
(29,'职场话题'),
(30,'外包'),
(31,'二手交易'),
(32,'物物交换'),
(33,'免费赠送'),
(34,'域名'),
(35,'团购'),
(36,'北京'),
(37,'上海'),
(38,'深圳'),
(39,'广州'),
(40,'杭州'),
(41,'成都'),
(42,'昆明'),
(43,'纽约'),
(44,'洛杉矶'),
(45,'问与答');
