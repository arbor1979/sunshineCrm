ALTER TABLE `customer`
ADD COLUMN `avatar`  varchar(255) NOT NULL AFTER `minzhekou`;

ALTER TABLE `unit`
ADD COLUMN `logo`  varchar(255) NOT NULL AFTER `shortname`,
ADD COLUMN `backgroundColor`  varchar(10) NOT NULL AFTER `logo`,
ADD COLUMN `tabbarColor`  varchar(10) NOT NULL AFTER `backgroundColor`,
ADD COLUMN `navibarColor`  varchar(10) NOT NULL AFTER `tabbarColor`,
ADD COLUMN `menuColor`  varchar(10) NOT NULL AFTER `navibarColor`,
ADD COLUMN `listColor`  varchar(10) NOT NULL AFTER `menuColor`;

DROP TABLE IF EXISTS `mobile_message_main`;
CREATE TABLE `mobile_message_main` (
  `id` int(11) NOT NULL auto_increment,
  `fromUserId` int(11) NOT NULL,
  `fromUserType` smallint(6) NOT NULL,
  `content` varchar(500) NOT NULL,
  `contentType` smallint(6) NOT NULL,
  `sendTime` datetime NOT NULL,
  `destCount` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `mobile_message_detail`;
CREATE TABLE `mobile_message_detail` (
  `id` int(11) NOT NULL auto_increment,
  `mainId` int(11) NOT NULL,
  `toUserId` int(11) NOT NULL,
  `toUserType` smallint(6) NOT NULL,
  `readTime` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `mainId` (`mainId`),
  CONSTRAINT `mobile_message_detail_ibfk_1` FOREIGN KEY (`mainId`) REFERENCES `mobile_message_main` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

ALTER TABLE `product`
MODIFY COLUMN `mode`  varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL AFTER `measureid`,
MODIFY COLUMN `standard`  varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL AFTER `mode`;

ALTER TABLE  `sellplanmain` 
ADD  `jifenchongdi` int(11) NOT NULL DEFAULT  '0' AFTER `zengpinjine`,
ADD  `jifenchongdimoney` DOUBLE NOT NULL DEFAULT  '0' AFTER `jifenchongdi`;

ALTER TABLE  `huikuanrecord` 
ADD  `jifenchongdi` INT NOT NULL DEFAULT  '0' AFTER  `oddment`,
ADD  `jifenchongdimoney` DOUBLE NOT NULL DEFAULT  '0' AFTER `jifenchongdi`;

ALTER 
ALGORITHM=MERGE 
DEFINER=`root`@`127.0.0.1` 
SQL SECURITY DEFINER 
VIEW `v_sellone_search` AS 
select `sellplanmain`.`billid` AS `billid`,`sellplanmain`.`zhuti` AS `zhuti`,`sellplanmain`.`user_id` AS `user_id`,`sellplanmain`.`supplyid` AS `supplyid`,`sellplanmain`.`chanceid` AS `chanceid`,`sellplanmain`.`sellplanno` AS `sellplanno`,`sellplanmain`.`totalmoney` AS `totalmoney`,`sellplanmain`.`paytype` AS `paytype`,`sellplanmain`.`huikuanjine` AS `huikuanjine`,`sellplanmain`.`fahuojine` AS `fahuojine`,`sellplanmain`.`kaipiaojine` AS `kaipiaojine`,`sellplanmain`.`plandate` AS `plandate`,`sellplanmain`.`zuiwanfahuodate` AS `zuiwanfahuodate`,`sellplanmain`.`qianyueren` AS `qianyueren`,`sellplanmain`.`user_flag` AS `user_flag`,`sellplanmain`.`beizhu` AS `beizhu`,`sellplanmain`.`fileaddress` AS `fileaddress`,`sellplanmain`.`fahuostate` AS `fahuostate`,`sellplanmain`.`gaiyao` AS `gaiyao`,`sellplanmain`.`storeid` AS `storeid`,`sellplanmain`.`linkman` AS `linkman`,`sellplanmain`.`address` AS `address`,`sellplanmain`.`mobile` AS `mobile`,`sellplanmain`.`createtime` AS `createtime`,`sellplanmain`.`billtype` AS `billtype`,`sellplanmain`.`ifpay` AS `ifpay`,`sellplanmain`.`beiyong` AS `beiyong`,`sellplanmain`.`kaipiaostate` AS `kaipiaostate`,`sellplanmain`.`fapiaoneirong` AS `fapiaoneirong`,`sellplanmain`.`fapiaotype` AS `fapiaotype`,`sellplanmain`.`fapiaono` AS `fapiaono`,`sellplanmain`.`fahuotype` AS `fahuotype`,`sellplanmain`.`fahuodan` AS `fahuodan`,`sellplanmain`.`fahuoyunfei` AS `fahuoyunfei`,`sellplanmain`.`yunfeitype` AS `yunfeitype`,`sellplanmain`.`oddment` AS `oddment`,`sellplanmain`.`integral` AS `integral`,`sellplanmain`.`totalnum` AS `totalnum`,`sellplanmain`.`tuihuojine` AS `tuihuojine`,`sellplanmain`.`zengpinjine` AS `zengpinjine`,jifenchongdi,jifenchongdimoney from `sellplanmain` where ((`sellplanmain`.`billtype` = 3) and (`sellplanmain`.`user_flag` > 0));

ALTER TABLE  `exchange` CHANGE  `ROWID`  `ROWID` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `exchange` CHANGE  `exchangenum`  `exchangenum` DOUBLE NULL DEFAULT NULL;
ALTER TABLE  `exchange` ADD  `guanlianbillid` INT NOT NULL ;
ALTER TABLE  `exchange` ADD  `remainjifen` INT NOT NULL ;

ALTER TABLE  `huikuanrecord` CHANGE  `paydate`  `paydate` DATETIME NOT NULL;

CREATE TABLE `sellplanmain_detail_delete` (
  `id` int(11) NOT NULL auto_increment,
  `prodid` varchar(255) NOT NULL,
  `prodname` varchar(255) NOT NULL,
  `prodguige` varchar(255) default NULL,
  `prodxinghao` varchar(255) default NULL,
  `proddanwei` varchar(255) default NULL,
  `price` float NOT NULL,
  `zhekou` float NOT NULL,
  `num` double(11,0) NOT NULL,
  `beizhu` varchar(255) default NULL,
  `mainrowid` int(11) NOT NULL,
  `jine` double NOT NULL,
  `chukunum` double NOT NULL,
  `plandate` date default NULL,
  `qici` varchar(50) default NULL,
  `yaoqiu` varchar(255) default NULL,
  `iftixing` varchar(2) default NULL,
  `createtime` datetime default NULL,
  `lirun` double NOT NULL,
  `oldprodid` varchar(50) default NULL,
  `opertype` smallint(6) NOT NULL default '1',
  `orderid` int(11) NOT NULL default '0',
  `inputtime` datetime default NULL,
  `sellprice` double default NULL,
  `zengpinzhekou` float NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `prodid` USING BTREE (`prodid`,`mainrowid`,`opertype`),
  KEY `mainrowid` (`mainrowid`),
  KEY `inputtime` (`inputtime`)
) ENGINE=InnoDB  DEFAULT CHARSET=gbk ;

ALTER TABLE `sellplanmain_detail_delete`
  ADD CONSTRAINT `sellplanmain_detail_delete_ibfk_1` FOREIGN KEY (`mainrowid`) REFERENCES `sellplanmain` (`billid`) ON DELETE CASCADE ON UPDATE CASCADE;

  ALTER TABLE `product`
DROP INDEX `supplyid_2` ,
ADD UNIQUE INDEX `supplyid_2` USING BTREE (`supplyid`, `oldproductid`, `standard`);

CREATE TABLE `baiduUserid` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`uid` INT NOT NULL ,
`utype` INT NOT NULL ,
`baidu_userid` VARCHAR( 50 ) NOT NULL ,
`baidu_channelid` VARCHAR( 50 ) NOT NULL ,
`bindTime` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) 
) ENGINE = innodb;

CREATE TABLE `userDevices` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`utype` INT NOT NULL ,
`deviceid` VARCHAR( 50 ) NOT NULL ,
`devicename` VARCHAR( 50 ) NOT NULL ,
`devicetype` VARCHAR( 20 ) NOT NULL ,
`devicemode` VARCHAR( 20 ) NOT NULL ,
`systemname` VARCHAR( 20 ) NOT NULL ,
`systemversion` VARCHAR( 20 ) NOT NULL ,
`screensize` VARCHAR( 20 ) NOT NULL ,
`createtime` DATETIME NOT NULL 
) ENGINE = innodb;

ALTER TABLE `baiduuserid` ADD UNIQUE (
`uid` ,
`utype` 
);
ALTER TABLE `userdevices` ADD UNIQUE (
`uid` ,
`utype` ,
`deviceid` 
);
