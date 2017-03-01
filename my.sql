/*
 Navicat Premium Data Transfer

 Source Server         : x.hizh.cn
 Source Server Type    : MySQL
 Source Server Version : 50619
 Source Host           : localhost
 Source Database       : eduupload

 Target Server Type    : MySQL
 Target Server Version : 50619
 File Encoding         : utf-8

 Date: 02/22/2017 11:00:48 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `cms_channel`
-- ----------------------------
DROP TABLE IF EXISTS `cms_channel`;
CREATE TABLE `cms_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `parentid` int(11) DEFAULT '0',
  `thumb` varchar(100) DEFAULT NULL,
  `outlink` varchar(255) DEFAULT NULL,
  `contenttemplate` varchar(255) DEFAULT NULL,
  `channeltemplate` varchar(255) DEFAULT NULL,
  `visible` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cms_channel`
-- ----------------------------
BEGIN;
INSERT INTO `cms_channel` VALUES ('18', '上报栏目', '0', '', '', 'details', 'wordlist', '1');
COMMIT;

-- ----------------------------
--  Table structure for `cms_content`
-- ----------------------------
DROP TABLE IF EXISTS `cms_content`;
CREATE TABLE `cms_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `order` int(11) DEFAULT '1',
  `views` int(11) DEFAULT '0',
  `qrcodeid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `outlink` varchar(1000) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `thumb` varchar(255) DEFAULT NULL,
  `pos` varchar(50) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cms_content`
-- ----------------------------
BEGIN;
INSERT INTO `cms_content` VALUES ('15', '56', '6456', null, '0', '0', null, '18', '1487648270', 'test', null, null, '1', '', '', '', null), ('16', 'saf', 'sadfsa', '<p>safs</p>', '1', '0', null, '18', '1487662393', 'admin', null, null, '1', '', null, null, '8'), ('17', 'sdfs', 'sdfa', '<p>sadfasf</p>', '1', '0', null, '18', '1487662499', 'admin', null, null, '1', '', null, null, '8'), ('18', 'sadfa', 'sdfasd', '<p>fsdf</p>', '1', '0', null, '18', '1487662519', 'admin', null, null, '1', '', null, null, '8');
COMMIT;

-- ----------------------------
--  Table structure for `cms_systemsetting`
-- ----------------------------
DROP TABLE IF EXISTS `cms_systemsetting`;
CREATE TABLE `cms_systemsetting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module` varchar(20) DEFAULT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cms_systemsetting`
-- ----------------------------
BEGIN;
INSERT INTO `cms_systemsetting` VALUES ('1', 'systemsetting', '0');
COMMIT;

-- ----------------------------
--  Table structure for `cms_tag`
-- ----------------------------
DROP TABLE IF EXISTS `cms_tag`;
CREATE TABLE `cms_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `cms_user`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `authority` tinyint(4) DEFAULT '4',
  `cityid` int(11) DEFAULT NULL,
  `districtid` int(11) DEFAULT NULL,
  `unitid` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `cms_user`
-- ----------------------------
BEGIN;
INSERT INTO `cms_user` VALUES ('1', 'sohenk', 'sohenk', '202cb962ac59075b964b07152d234b70', '2', null, null, null, '1'), ('8', 'admin', 'admin', '202cb962ac59075b964b07152d234b70', '4', null, null, null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(255) NOT NULL,
  `menu_controller` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_show` tinyint(1) DEFAULT '1',
  `menuclass` varchar(100) DEFAULT NULL,
  `menu_method` varchar(50) DEFAULT NULL,
  `menu_param` varchar(255) DEFAULT NULL,
  `menu_action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `menu`
-- ----------------------------
BEGIN;
INSERT INTO `menu` VALUES ('1', '系统管理', 'admin', '0', '1', 'glyphicon glyphicon-star', null, null, null), ('3', '菜单管理', 'admin', '1', '1', null, 'menulist', null, null), ('4', '角色管理', 'admin', '1', '1', null, 'rolelist', null, null), ('5', '管理员管理', 'admin', '1', '1', null, 'adminuserlist', null, null), ('13', '菜单action', 'admin', '1', '0', null, 'menuprofile', null, null), ('14', '角色action', 'admin', '1', '0', null, 'roleprofile', null, null), ('15', '管理员action', 'admin', '1', '0', null, 'adminuserprofile', null, null), ('16', '角色权限分配', 'admin', '1', '0', '', 'roleprivilege', null, null), ('19', '内容管理', 'cms', '0', '1', '', '', '', ''), ('20', '内容列表', 'cms', '19', '1', '', 'contentlist', '', ''), ('21', '控制台', 'admin', '0', '0', '', 'index', null, null), ('22', '栏目列表', 'cms', '19', '1', '', 'channellists', '', 'comm_cms_channel_list'), ('27', '新增栏目', 'cms', '19', '0', '', 'addchannel', '', ''), ('30', '栏目管理', 'cms', '19', '1', '', 'channellist', '', ''), ('31', '编辑栏目', 'cms', '19', '0', '', 'editchannel', '', ''), ('32', '删除栏目', 'cms', '19', '0', '', 'delchannel', '', ''), ('33', '新增内容', 'cms', '19', '0', '', 'addcontent', '', ''), ('34', '编辑内容', 'cms', '19', '0', '', 'editcontent', '', ''), ('35', '删除内容', 'cms', '19', '0', '', 'delcontent', '', ''), ('44', '删除所有选中项', 'cms', '19', '0', '', 'delAll', '', '');
COMMIT;

-- ----------------------------
--  Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(25) NOT NULL,
  `role_shortname` varchar(25) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `role`
-- ----------------------------
BEGIN;
INSERT INTO `role` VALUES ('1', '管理员', 'admin'), ('2', '编辑', 'editor');
COMMIT;

-- ----------------------------
--  Table structure for `roleprivilege`
-- ----------------------------
DROP TABLE IF EXISTS `roleprivilege`;
CREATE TABLE `roleprivilege` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `roleprivilege`
-- ----------------------------
BEGIN;
INSERT INTO `roleprivilege` VALUES ('5', '16'), ('5', '15'), ('5', '14'), ('5', '5'), ('5', '4'), ('5', '3'), ('5', '1'), ('1', '28'), ('1', '21'), ('1', '44'), ('1', '35'), ('1', '34'), ('1', '33'), ('1', '32'), ('1', '31'), ('1', '30'), ('1', '27'), ('1', '22'), ('1', '20'), ('1', '19'), ('1', '16'), ('1', '15'), ('1', '14'), ('1', '13'), ('1', '5'), ('1', '4'), ('1', '3'), ('1', '1'), ('2', '21'), ('2', '44'), ('2', '35'), ('2', '34'), ('2', '33'), ('2', '20'), ('2', '19');
COMMIT;

-- ----------------------------
--  Table structure for `system_setting`
-- ----------------------------
DROP TABLE IF EXISTS `system_setting`;
CREATE TABLE `system_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `authority` tinyint(4) DEFAULT '4',
  `role_id` int(11) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `isctrother` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否可以看别人的数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'sohenk', 'sohenk', '202cb962ac59075b964b07152d234b70', '2', '1', '1', '0'), ('8', 'admin', 'admin', '202cb962ac59075b964b07152d234b70', '4', '1', '1', '0'), ('12', 'zhnews', 'zhnews', '202cb962ac59075b964b07152d234b70', '4', '2', '1', '1'), ('13', 'test', 'test', '202cb962ac59075b964b07152d234b70', '4', '2', '1', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
