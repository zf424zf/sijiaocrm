/*
Navicat MySQL Data Transfer

Source Server         : Sport
Source Server Version : 50173
Source Host           : localhost:3306
Source Database       : train

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2017-05-10 14:01:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for train_action
-- ----------------------------
DROP TABLE IF EXISTS `train_action`;
CREATE TABLE `train_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of train_action
-- ----------------------------
INSERT INTO `train_action` VALUES ('1', 'user_login', '用户登录', '积分+10，每天一次', 'table:member|field:score|condition:uid={$self} AND status>-1|rule:score+10|cycle:24|max:1;', '[user|get_nickname]在[time|time_format]登录了后台', '1', '1', '1387181220');
INSERT INTO `train_action` VALUES ('2', 'add_article', '发布文章', '积分+5，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:5', '', '2', '0', '1380173180');
INSERT INTO `train_action` VALUES ('3', 'review', '评论', '评论积分+1，无限制', 'table:member|field:score|condition:uid={$self}|rule:score+1', '', '2', '1', '1383285646');
INSERT INTO `train_action` VALUES ('4', 'add_document', '发表文档', '积分+10，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+10|cycle:24|max:5', '[user|get_nickname]在[time|time_format]发表了一篇文章。\r\n表[model]，记录编号[record]。', '2', '0', '1386139726');
INSERT INTO `train_action` VALUES ('5', 'add_document_topic', '发表讨论', '积分+5，每天上限10次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:10', '', '2', '0', '1383285551');
INSERT INTO `train_action` VALUES ('6', 'update_config', '更新配置', '新增或修改或删除配置', '', '', '1', '1', '1383294988');
INSERT INTO `train_action` VALUES ('7', 'update_model', '更新模型', '新增或修改模型', '', '', '1', '1', '1383295057');
INSERT INTO `train_action` VALUES ('8', 'update_attribute', '更新属性', '新增或更新或删除属性', '', '', '1', '1', '1383295963');
INSERT INTO `train_action` VALUES ('9', 'update_channel', '更新导航', '新增或修改或删除导航', '', '', '1', '1', '1383296301');
INSERT INTO `train_action` VALUES ('10', 'update_menu', '更新菜单', '新增或修改或删除菜单', '', '', '1', '1', '1383296392');
INSERT INTO `train_action` VALUES ('11', 'update_category', '更新分类', '新增或修改或删除分类', '', '', '1', '1', '1383296765');

-- ----------------------------
-- Table structure for train_action_log
-- ----------------------------
DROP TABLE IF EXISTS `train_action_log`;
CREATE TABLE `train_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of train_action_log
-- ----------------------------
INSERT INTO `train_action_log` VALUES ('1', '1', '1', '2045084103', 'member', '1', 'admin在2017-04-07 14:01登录了后台', '1', '1491544869');
INSERT INTO `train_action_log` VALUES ('2', '1', '1', '2045084103', 'member', '1', 'admin在2017-04-07 15:27登录了后台', '1', '1491550065');
INSERT INTO `train_action_log` VALUES ('3', '1', '1', '1993270357', 'member', '1', 'admin在2017-04-07 15:30登录了后台', '1', '1491550247');
INSERT INTO `train_action_log` VALUES ('4', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-10 09:28登录了后台', '1', '1491787710');
INSERT INTO `train_action_log` VALUES ('5', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-10 15:08登录了后台', '1', '1491808138');
INSERT INTO `train_action_log` VALUES ('6', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-10 15:16登录了后台', '1', '1491808573');
INSERT INTO `train_action_log` VALUES ('7', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-10 16:17登录了后台', '1', '1491812224');
INSERT INTO `train_action_log` VALUES ('8', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-11 14:26登录了后台', '1', '1491891990');
INSERT INTO `train_action_log` VALUES ('9', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-11 14:33登录了后台', '1', '1491892406');
INSERT INTO `train_action_log` VALUES ('10', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-11 15:33登录了后台', '1', '1491896000');
INSERT INTO `train_action_log` VALUES ('11', '1', '1', '3027082774', 'member', '1', 'admin在2017-04-11 17:16登录了后台', '1', '1491902198');
INSERT INTO `train_action_log` VALUES ('12', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-12 11:17登录了后台', '1', '1491967048');
INSERT INTO `train_action_log` VALUES ('13', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-12 14:06登录了后台', '1', '1491977161');
INSERT INTO `train_action_log` VALUES ('14', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-12 14:50登录了后台', '1', '1491979843');
INSERT INTO `train_action_log` VALUES ('15', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-12 17:55登录了后台', '1', '1491990919');
INSERT INTO `train_action_log` VALUES ('16', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-12 17:55登录了后台', '1', '1491990931');
INSERT INTO `train_action_log` VALUES ('17', '1', '1', '1780909581', 'member', '1', 'admin在2017-04-12 17:56登录了后台', '1', '1491990993');
INSERT INTO `train_action_log` VALUES ('18', '1', '1', '1780909581', 'member', '1', 'admin在2017-04-13 09:24登录了后台', '1', '1492046687');
INSERT INTO `train_action_log` VALUES ('19', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-13 11:06登录了后台', '1', '1492052771');
INSERT INTO `train_action_log` VALUES ('20', '1', '1', '2045575777', 'member', '1', 'admin在2017-04-13 11:46登录了后台', '1', '1492055195');
INSERT INTO `train_action_log` VALUES ('21', '1', '1', '3730730046', 'member', '1', 'admin在2017-04-14 14:04登录了后台', '1', '1492149841');
INSERT INTO `train_action_log` VALUES ('22', '1', '1', '987067706', 'member', '1', 'admin在2017-04-17 09:38登录了后台', '1', '1492393100');
INSERT INTO `train_action_log` VALUES ('23', '1', '1', '2045062122', 'member', '1', 'admin在2017-04-17 13:37登录了后台', '1', '1492407424');
INSERT INTO `train_action_log` VALUES ('24', '1', '1', '2045062122', 'member', '1', 'admin在2017-04-18 09:25登录了后台', '1', '1492478704');
INSERT INTO `train_action_log` VALUES ('25', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 13:58登录了后台', '1', '1492581493');
INSERT INTO `train_action_log` VALUES ('26', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 14:18登录了后台', '1', '1492582714');
INSERT INTO `train_action_log` VALUES ('27', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 14:19登录了后台', '1', '1492582798');
INSERT INTO `train_action_log` VALUES ('28', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 14:26登录了后台', '1', '1492583166');
INSERT INTO `train_action_log` VALUES ('29', '1', '1', '1786333899', 'member', '1', 'admin在2017-04-19 15:42登录了后台', '1', '1492587763');
INSERT INTO `train_action_log` VALUES ('30', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 15:44登录了后台', '1', '1492587886');
INSERT INTO `train_action_log` VALUES ('31', '1', '1', '1786333899', 'member', '1', 'admin在2017-04-19 15:45登录了后台', '1', '1492587933');
INSERT INTO `train_action_log` VALUES ('32', '1', '1', '1786333899', 'member', '1', 'admin在2017-04-19 17:04登录了后台', '1', '1492592685');
INSERT INTO `train_action_log` VALUES ('33', '1', '1', '1786333899', 'member', '1', 'admin在2017-04-19 17:05登录了后台', '1', '1492592745');
INSERT INTO `train_action_log` VALUES ('34', '1', '1', '1786333899', 'member', '1', 'admin在2017-04-19 17:13登录了后台', '1', '1492593224');
INSERT INTO `train_action_log` VALUES ('35', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-19 18:08登录了后台', '1', '1492596487');
INSERT INTO `train_action_log` VALUES ('36', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 09:25登录了后台', '1', '1492651522');
INSERT INTO `train_action_log` VALUES ('37', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 09:25登录了后台', '1', '1492651539');
INSERT INTO `train_action_log` VALUES ('38', '1', '1', '3549427034', 'member', '1', 'admin在2017-04-20 09:28登录了后台', '1', '1492651707');
INSERT INTO `train_action_log` VALUES ('39', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 09:29登录了后台', '1', '1492651753');
INSERT INTO `train_action_log` VALUES ('40', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 09:29登录了后台', '1', '1492651789');
INSERT INTO `train_action_log` VALUES ('41', '1', '1', '3549427034', 'member', '1', 'admin在2017-04-20 13:13登录了后台', '1', '1492665211');
INSERT INTO `train_action_log` VALUES ('42', '1', '1', '3549427034', 'member', '1', 'admin在2017-04-20 13:37登录了后台', '1', '1492666639');
INSERT INTO `train_action_log` VALUES ('43', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 14:02登录了后台', '1', '1492668147');
INSERT INTO `train_action_log` VALUES ('44', '1', '17', '3549427034', 'member', '17', '881在2017-04-20 14:31登录了后台', '1', '1492669866');
INSERT INTO `train_action_log` VALUES ('45', '1', '21', '3549427034', 'member', '21', '885在2017-04-20 14:32登录了后台', '1', '1492669945');
INSERT INTO `train_action_log` VALUES ('46', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 15:02登录了后台', '1', '1492671738');
INSERT INTO `train_action_log` VALUES ('47', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 17:16登录了后台', '1', '1492679771');
INSERT INTO `train_action_log` VALUES ('48', '1', '1', '3027082332', 'member', '1', 'admin在2017-04-20 18:21登录了后台', '1', '1492683684');
INSERT INTO `train_action_log` VALUES ('49', '1', '20', '3549427034', 'member', '20', '884在2017-04-21 06:52登录了后台', '1', '1492728758');
INSERT INTO `train_action_log` VALUES ('50', '1', '1', '826372153', 'member', '1', 'admin在2017-04-21 09:47登录了后台', '1', '1492739251');
INSERT INTO `train_action_log` VALUES ('51', '1', '20', '3549427034', 'member', '20', '884在2017-04-21 10:07登录了后台', '1', '1492740452');
INSERT INTO `train_action_log` VALUES ('52', '1', '1', '826372153', 'member', '1', 'admin在2017-04-21 10:36登录了后台', '1', '1492742204');
INSERT INTO `train_action_log` VALUES ('53', '1', '20', '3549427034', 'member', '20', '884在2017-04-21 13:14登录了后台', '1', '1492751654');
INSERT INTO `train_action_log` VALUES ('54', '1', '17', '3549427034', 'member', '17', '881在2017-04-22 10:28登录了后台', '1', '1492828129');
INSERT INTO `train_action_log` VALUES ('55', '1', '1', '987002507', 'member', '1', 'admin在2017-04-24 01:00登录了后台', '1', '1492966817');
INSERT INTO `train_action_log` VALUES ('56', '1', '18', '3549427034', 'member', '18', '882在2017-04-24 06:36登录了后台', '1', '1492986964');
INSERT INTO `train_action_log` VALUES ('57', '1', '1', '3730730260', 'member', '1', 'admin在2017-04-24 11:36登录了后台', '1', '1493004970');
INSERT INTO `train_action_log` VALUES ('58', '1', '1', '3730730260', 'member', '1', 'admin在2017-04-24 11:49登录了后台', '1', '1493005761');
INSERT INTO `train_action_log` VALUES ('59', '1', '1', '3730730260', 'member', '1', 'admin在2017-04-24 13:35登录了后台', '1', '1493012149');
INSERT INTO `train_action_log` VALUES ('60', '1', '1', '3730730260', 'member', '1', 'admin在2017-04-24 15:19登录了后台', '1', '1493018359');
INSERT INTO `train_action_log` VALUES ('61', '1', '19', '3549427034', 'member', '19', '883在2017-04-25 11:30登录了后台', '1', '1493091004');
INSERT INTO `train_action_log` VALUES ('62', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 09:17登录了后台', '1', '1493255852');
INSERT INTO `train_action_log` VALUES ('63', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 09:20登录了后台', '1', '1493256014');
INSERT INTO `train_action_log` VALUES ('64', '10', '1', '1968728163', 'Menu', '122', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493256063');
INSERT INTO `train_action_log` VALUES ('65', '10', '1', '1968728163', 'Menu', '123', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493256113');
INSERT INTO `train_action_log` VALUES ('66', '10', '1', '1968728163', 'Menu', '124', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493256131');
INSERT INTO `train_action_log` VALUES ('67', '10', '1', '1968728163', 'Menu', '125', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493256164');
INSERT INTO `train_action_log` VALUES ('68', '10', '1', '1968728163', 'Menu', '126', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493256182');
INSERT INTO `train_action_log` VALUES ('69', '10', '1', '1968728163', 'Menu', '126', '操作url：/index.php?s=/Admin/Menu/edit.html', '1', '1493256209');
INSERT INTO `train_action_log` VALUES ('70', '10', '1', '1968728163', 'Menu', '122', '操作url：/index.php?s=/Admin/Menu/edit.html', '1', '1493256248');
INSERT INTO `train_action_log` VALUES ('71', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 10:17登录了后台', '1', '1493259445');
INSERT INTO `train_action_log` VALUES ('72', '1', '20', '3549427034', 'member', '20', '884在2017-04-27 13:43登录了后台', '1', '1493271785');
INSERT INTO `train_action_log` VALUES ('73', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 13:49登录了后台', '1', '1493272192');
INSERT INTO `train_action_log` VALUES ('74', '1', '20', '3549427034', 'member', '20', '884在2017-04-27 13:53登录了后台', '1', '1493272406');
INSERT INTO `train_action_log` VALUES ('75', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 15:02登录了后台', '1', '1493276578');
INSERT INTO `train_action_log` VALUES ('76', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-27 15:03登录了后台', '1', '1493276602');
INSERT INTO `train_action_log` VALUES ('77', '1', '1', '1786318195', 'member', '1', 'admin在2017-04-27 16:46登录了后台', '1', '1493282783');
INSERT INTO `train_action_log` VALUES ('78', '1', '1', '1786318195', 'member', '1', 'admin在2017-04-27 17:06登录了后台', '1', '1493284009');
INSERT INTO `train_action_log` VALUES ('79', '1', '1', '1999082148', 'member', '1', 'admin在2017-04-27 21:54登录了后台', '1', '1493301261');
INSERT INTO `train_action_log` VALUES ('80', '1', '1', '1999082148', 'member', '1', 'admin在2017-04-27 22:59登录了后台', '1', '1493305193');
INSERT INTO `train_action_log` VALUES ('81', '1', '1', '1999082148', 'member', '1', 'admin在2017-04-27 23:01登录了后台', '1', '1493305291');
INSERT INTO `train_action_log` VALUES ('82', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 09:22登录了后台', '1', '1493342561');
INSERT INTO `train_action_log` VALUES ('83', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 09:22登录了后台', '1', '1493342564');
INSERT INTO `train_action_log` VALUES ('84', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 10:55登录了后台', '1', '1493348140');
INSERT INTO `train_action_log` VALUES ('85', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 11:20登录了后台', '1', '1493349626');
INSERT INTO `train_action_log` VALUES ('86', '1', '19', '3549427034', 'member', '19', '883在2017-04-28 11:30登录了后台', '1', '1493350235');
INSERT INTO `train_action_log` VALUES ('87', '1', '19', '3549427034', 'member', '19', '883在2017-04-28 11:31登录了后台', '1', '1493350277');
INSERT INTO `train_action_log` VALUES ('88', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 13:34登录了后台', '1', '1493357644');
INSERT INTO `train_action_log` VALUES ('89', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 13:34登录了后台', '1', '1493357674');
INSERT INTO `train_action_log` VALUES ('90', '1', '17', '3549427034', 'member', '17', '881在2017-04-28 14:26登录了后台', '1', '1493360813');
INSERT INTO `train_action_log` VALUES ('91', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 14:47登录了后台', '1', '1493362034');
INSERT INTO `train_action_log` VALUES ('92', '1', '17', '1968728163', 'member', '17', '881在2017-04-28 15:11登录了后台', '1', '1493363490');
INSERT INTO `train_action_log` VALUES ('93', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 15:24登录了后台', '1', '1493364298');
INSERT INTO `train_action_log` VALUES ('94', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 15:27登录了后台', '1', '1493364476');
INSERT INTO `train_action_log` VALUES ('95', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 15:31登录了后台', '1', '1493364685');
INSERT INTO `train_action_log` VALUES ('96', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 15:44登录了后台', '1', '1493365443');
INSERT INTO `train_action_log` VALUES ('97', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 17:09登录了后台', '1', '1493370599');
INSERT INTO `train_action_log` VALUES ('98', '1', '1', '1968728163', 'member', '1', 'admin在2017-04-28 17:50登录了后台', '1', '1493373052');
INSERT INTO `train_action_log` VALUES ('99', '1', '18', '3549427034', 'member', '18', '882在2017-04-29 10:13登录了后台', '1', '1493432014');
INSERT INTO `train_action_log` VALUES ('100', '1', '18', '3549427034', 'member', '18', '882在2017-04-29 11:02登录了后台', '1', '1493434926');
INSERT INTO `train_action_log` VALUES ('101', '1', '18', '3549427034', 'member', '18', '882在2017-04-29 11:17登录了后台', '1', '1493435846');
INSERT INTO `train_action_log` VALUES ('102', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-02 11:18登录了后台', '1', '1493695090');
INSERT INTO `train_action_log` VALUES ('103', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-02 11:36登录了后台', '1', '1493696185');
INSERT INTO `train_action_log` VALUES ('104', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-02 13:28登录了后台', '1', '1493702917');
INSERT INTO `train_action_log` VALUES ('105', '1', '19', '3549427034', 'member', '19', '883在2017-05-02 13:33登录了后台', '1', '1493703188');
INSERT INTO `train_action_log` VALUES ('106', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-02 13:48登录了后台', '1', '1493704136');
INSERT INTO `train_action_log` VALUES ('107', '1', '21', '3549427034', 'member', '21', '885在2017-05-02 14:25登录了后台', '1', '1493706304');
INSERT INTO `train_action_log` VALUES ('108', '1', '20', '3549427034', 'member', '20', '884在2017-05-02 14:25登录了后台', '1', '1493706313');
INSERT INTO `train_action_log` VALUES ('109', '1', '23', '1968357139', 'member', '23', '887在2017-05-02 15:39登录了后台', '1', '1493710790');
INSERT INTO `train_action_log` VALUES ('110', '1', '23', '1968357139', 'member', '23', '887在2017-05-02 15:41登录了后台', '1', '1493710860');
INSERT INTO `train_action_log` VALUES ('111', '1', '1', '2045064752', 'member', '1', 'admin在2017-05-03 08:59登录了后台', '1', '1493773164');
INSERT INTO `train_action_log` VALUES ('112', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 09:44登录了后台', '1', '1493775894');
INSERT INTO `train_action_log` VALUES ('113', '1', '1', '827144821', 'member', '1', 'admin在2017-05-03 10:00登录了后台', '1', '1493776853');
INSERT INTO `train_action_log` VALUES ('114', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 10:01登录了后台', '1', '1493776887');
INSERT INTO `train_action_log` VALUES ('115', '1', '1', '827144821', 'member', '1', 'admin在2017-05-03 12:02登录了后台', '1', '1493784171');
INSERT INTO `train_action_log` VALUES ('116', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-03 12:18登录了后台', '1', '1493785087');
INSERT INTO `train_action_log` VALUES ('117', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 13:10登录了后台', '1', '1493788249');
INSERT INTO `train_action_log` VALUES ('118', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-03 13:12登录了后台', '1', '1493788349');
INSERT INTO `train_action_log` VALUES ('119', '1', '17', '3549427034', 'member', '17', '881在2017-05-03 13:24登录了后台', '1', '1493789092');
INSERT INTO `train_action_log` VALUES ('120', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 13:26登录了后台', '1', '1493789179');
INSERT INTO `train_action_log` VALUES ('121', '1', '17', '3549427034', 'member', '17', '881在2017-05-03 13:29登录了后台', '1', '1493789360');
INSERT INTO `train_action_log` VALUES ('122', '1', '1', '3549427034', 'member', '1', 'admin在2017-05-03 13:29登录了后台', '1', '1493789394');
INSERT INTO `train_action_log` VALUES ('123', '10', '1', '3549427034', 'Menu', '127', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493789625');
INSERT INTO `train_action_log` VALUES ('124', '1', '17', '3549427034', 'member', '17', '881在2017-05-03 13:38登录了后台', '1', '1493789914');
INSERT INTO `train_action_log` VALUES ('125', '1', '24', '3549427034', 'member', '24', 'suzhou在2017-05-03 14:08登录了后台', '1', '1493791695');
INSERT INTO `train_action_log` VALUES ('126', '1', '1', '827144821', 'member', '1', 'admin在2017-05-03 14:17登录了后台', '1', '1493792270');
INSERT INTO `train_action_log` VALUES ('127', '1', '1', '827144821', 'member', '1', 'admin在2017-05-03 18:16登录了后台', '1', '1493806619');
INSERT INTO `train_action_log` VALUES ('128', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 18:27登录了后台', '1', '1493807267');
INSERT INTO `train_action_log` VALUES ('129', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 18:34登录了后台', '1', '1493807684');
INSERT INTO `train_action_log` VALUES ('130', '1', '18', '3549427034', 'member', '18', '882在2017-05-03 21:18登录了后台', '1', '1493817492');
INSERT INTO `train_action_log` VALUES ('131', '1', '1', '827144821', 'member', '1', 'admin在2017-05-04 09:11登录了后台', '1', '1493860260');
INSERT INTO `train_action_log` VALUES ('132', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 09:36登录了后台', '1', '1493861769');
INSERT INTO `train_action_log` VALUES ('133', '1', '1', '827144821', 'member', '1', 'admin在2017-05-04 15:38登录了后台', '1', '1493883531');
INSERT INTO `train_action_log` VALUES ('134', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 15:41登录了后台', '1', '1493883663');
INSERT INTO `train_action_log` VALUES ('135', '1', '1', '827144821', 'member', '1', 'admin在2017-05-04 16:53登录了后台', '1', '1493888000');
INSERT INTO `train_action_log` VALUES ('136', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 16:54登录了后台', '1', '1493888057');
INSERT INTO `train_action_log` VALUES ('137', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 17:05登录了后台', '1', '1493888712');
INSERT INTO `train_action_log` VALUES ('138', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 20:35登录了后台', '1', '1493901343');
INSERT INTO `train_action_log` VALUES ('139', '1', '19', '3549427034', 'member', '19', '883在2017-05-04 20:36登录了后台', '1', '1493901407');
INSERT INTO `train_action_log` VALUES ('140', '1', '1', '1968785743', 'member', '1', 'admin在2017-05-05 10:15登录了后台', '1', '1493950557');
INSERT INTO `train_action_log` VALUES ('141', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 10:41登录了后台', '1', '1493952066');
INSERT INTO `train_action_log` VALUES ('142', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 10:58登录了后台', '1', '1493953085');
INSERT INTO `train_action_log` VALUES ('143', '1', '1', '1968785743', 'member', '1', 'admin在2017-05-05 13:53登录了后台', '1', '1493963631');
INSERT INTO `train_action_log` VALUES ('144', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 16:16登录了后台', '1', '1493972174');
INSERT INTO `train_action_log` VALUES ('145', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 16:17登录了后台', '1', '1493972223');
INSERT INTO `train_action_log` VALUES ('146', '1', '1', '1968785743', 'member', '1', 'admin在2017-05-05 18:27登录了后台', '1', '1493980043');
INSERT INTO `train_action_log` VALUES ('147', '10', '1', '1968785743', 'Menu', '128', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493980157');
INSERT INTO `train_action_log` VALUES ('148', '10', '1', '1968785743', 'Menu', '129', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493980187');
INSERT INTO `train_action_log` VALUES ('149', '10', '1', '1968785743', 'Menu', '130', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493980202');
INSERT INTO `train_action_log` VALUES ('150', '10', '1', '1968785743', 'Menu', '129', '操作url：/index.php?s=/Admin/Menu/edit.html', '1', '1493980213');
INSERT INTO `train_action_log` VALUES ('151', '10', '1', '1968785743', 'Menu', '131', '操作url：/index.php?s=/Admin/Menu/add.html', '1', '1493980229');
INSERT INTO `train_action_log` VALUES ('152', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 20:58登录了后台', '1', '1493989121');
INSERT INTO `train_action_log` VALUES ('153', '1', '21', '3549427034', 'member', '21', '885在2017-05-05 21:11登录了后台', '1', '1493989897');
INSERT INTO `train_action_log` VALUES ('154', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 12:36登录了后台', '1', '1494045410');
INSERT INTO `train_action_log` VALUES ('155', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 13:40登录了后台', '1', '1494049250');
INSERT INTO `train_action_log` VALUES ('156', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 15:01登录了后台', '1', '1494054100');
INSERT INTO `train_action_log` VALUES ('157', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 16:46登录了后台', '1', '1494060385');
INSERT INTO `train_action_log` VALUES ('158', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 19:10登录了后台', '1', '1494069009');
INSERT INTO `train_action_log` VALUES ('159', '1', '21', '3549427034', 'member', '21', '885在2017-05-06 21:04登录了后台', '1', '1494075848');
INSERT INTO `train_action_log` VALUES ('160', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 12:12登录了后台', '1', '1494130360');
INSERT INTO `train_action_log` VALUES ('161', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 12:15登录了后台', '1', '1494130518');
INSERT INTO `train_action_log` VALUES ('162', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 13:54登录了后台', '1', '1494136470');
INSERT INTO `train_action_log` VALUES ('163', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 15:44登录了后台', '1', '1494143079');
INSERT INTO `train_action_log` VALUES ('164', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 15:46登录了后台', '1', '1494143204');
INSERT INTO `train_action_log` VALUES ('165', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 20:02登录了后台', '1', '1494158538');
INSERT INTO `train_action_log` VALUES ('166', '1', '19', '3549427034', 'member', '19', '883在2017-05-07 21:16登录了后台', '1', '1494162998');
INSERT INTO `train_action_log` VALUES ('167', '1', '18', '3549427034', 'member', '18', '882在2017-05-08 08:20登录了后台', '1', '1494202851');
INSERT INTO `train_action_log` VALUES ('168', '1', '18', '3549427034', 'member', '18', '882在2017-05-08 08:23登录了后台', '1', '1494203002');
INSERT INTO `train_action_log` VALUES ('169', '1', '18', '3549427034', 'member', '18', '882在2017-05-08 20:44登录了后台', '1', '1494247468');
INSERT INTO `train_action_log` VALUES ('170', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 09:34登录了后台', '1', '1494293660');
INSERT INTO `train_action_log` VALUES ('171', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 09:39登录了后台', '1', '1494293949');
INSERT INTO `train_action_log` VALUES ('172', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 11:45登录了后台', '1', '1494301536');
INSERT INTO `train_action_log` VALUES ('173', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 12:37登录了后台', '1', '1494304638');
INSERT INTO `train_action_log` VALUES ('174', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 12:41登录了后台', '1', '1494304876');
INSERT INTO `train_action_log` VALUES ('175', '1', '1', '3027055310', 'member', '1', 'admin在2017-05-09 13:42登录了后台', '1', '1494308572');
INSERT INTO `train_action_log` VALUES ('176', '1', '1', '3027055310', 'member', '1', 'admin在2017-05-09 14:24登录了后台', '1', '1494311061');
INSERT INTO `train_action_log` VALUES ('177', '1', '1', '3027055310', 'member', '1', 'admin在2017-05-09 15:54登录了后台', '1', '1494316497');
INSERT INTO `train_action_log` VALUES ('178', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 19:42登录了后台', '1', '1494330159');
INSERT INTO `train_action_log` VALUES ('179', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 20:53登录了后台', '1', '1494334433');
INSERT INTO `train_action_log` VALUES ('180', '1', '20', '3549427034', 'member', '20', '884在2017-05-09 21:37登录了后台', '1', '1494337026');
INSERT INTO `train_action_log` VALUES ('181', '1', '1', '3730730455', 'member', '1', 'admin在2017-05-10 10:08登录了后台', '1', '1494382115');
INSERT INTO `train_action_log` VALUES ('182', '1', '1', '3730730455', 'member', '1', 'admin在2017-05-10 10:09登录了后台', '1', '1494382157');
INSERT INTO `train_action_log` VALUES ('183', '1', '19', '3549427034', 'member', '19', '883在2017-05-10 10:12登录了后台', '1', '1494382339');
INSERT INTO `train_action_log` VALUES ('184', '1', '19', '3549427034', 'member', '19', '883在2017-05-10 10:12登录了后台', '1', '1494382351');
INSERT INTO `train_action_log` VALUES ('185', '1', '1', '3730730455', 'member', '1', 'admin在2017-05-10 10:57登录了后台', '1', '1494385060');
INSERT INTO `train_action_log` VALUES ('186', '1', '1', '3730730455', 'member', '1', 'admin在2017-05-10 10:58登录了后台', '1', '1494385091');
INSERT INTO `train_action_log` VALUES ('187', '1', '19', '3549427034', 'member', '19', '883在2017-05-10 12:39登录了后台', '1', '1494391183');
INSERT INTO `train_action_log` VALUES ('188', '1', '19', '3549427034', 'member', '19', '883在2017-05-10 12:49登录了后台', '1', '1494391779');
INSERT INTO `train_action_log` VALUES ('189', '1', '24', '3549427034', 'member', '24', 'suzhou在2017-05-10 13:00登录了后台', '1', '1494392425');
INSERT INTO `train_action_log` VALUES ('190', '1', '19', '3549427034', 'member', '19', '883在2017-05-10 13:00登录了后台', '1', '1494392453');
INSERT INTO `train_action_log` VALUES ('191', '1', '24', '3549427034', 'member', '24', 'suzhou在2017-05-10 13:22登录了后台', '1', '1494393763');
INSERT INTO `train_action_log` VALUES ('192', '1', '24', '3730730455', 'member', '24', 'suzhou在2017-05-10 13:47登录了后台', '1', '1494395258');
INSERT INTO `train_action_log` VALUES ('193', '1', '1', '3730730455', 'member', '1', 'admin在2017-05-10 13:51登录了后台', '1', '1494395473');
INSERT INTO `train_action_log` VALUES ('194', '1', '24', '3730730455', 'member', '24', 'suzhou在2017-05-10 14:00登录了后台', '1', '1494396033');

-- ----------------------------
-- Table structure for train_addons
-- ----------------------------
DROP TABLE IF EXISTS `train_addons`;
CREATE TABLE `train_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of train_addons
-- ----------------------------
INSERT INTO `train_addons` VALUES ('15', 'EditorForAdmin', '后台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"500px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1383126253', '0');
INSERT INTO `train_addons` VALUES ('2', 'SiteStat', '站点统计信息', '统计站点的基础信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"1\",\"display\":\"1\",\"status\":\"0\"}', 'thinkphp', '0.1', '1379512015', '0');
INSERT INTO `train_addons` VALUES ('3', 'DevTeam', '开发团队信息', '开发团队成员信息', '1', '{\"title\":\"OneThink\\u5f00\\u53d1\\u56e2\\u961f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512022', '0');
INSERT INTO `train_addons` VALUES ('4', 'SystemInfo', '系统环境信息', '用于显示一些服务器的信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512036', '0');
INSERT INTO `train_addons` VALUES ('5', 'Editor', '前台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"300px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1379830910', '0');
INSERT INTO `train_addons` VALUES ('6', 'Attachment', '附件', '用于文档模型上传附件', '1', 'null', 'thinkphp', '0.1', '1379842319', '1');
INSERT INTO `train_addons` VALUES ('9', 'SocialComment', '通用社交化评论', '集成了各种社交化评论插件，轻松集成到系统中。', '1', '{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}', 'thinkphp', '0.1', '1380273962', '0');

-- ----------------------------
-- Table structure for train_attachment
-- ----------------------------
DROP TABLE IF EXISTS `train_attachment`;
CREATE TABLE `train_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件显示名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `dir` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '上级目录ID',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of train_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for train_attribute
-- ----------------------------
DROP TABLE IF EXISTS `train_attribute`;
CREATE TABLE `train_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL,
  `validate_time` tinyint(1) unsigned NOT NULL,
  `error_info` varchar(100) NOT NULL,
  `validate_type` varchar(25) NOT NULL,
  `auto_rule` varchar(100) NOT NULL,
  `auto_time` tinyint(1) unsigned NOT NULL,
  `auto_type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- ----------------------------
-- Records of train_attribute
-- ----------------------------
INSERT INTO `train_attribute` VALUES ('1', 'uid', '用户ID', 'int(10) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1384508362', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('2', 'name', '标识', 'char(40) NOT NULL ', 'string', '', '同一根节点下标识不重复', '1', '', '1', '0', '1', '1383894743', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('3', 'title', '标题', 'char(80) NOT NULL ', 'string', '', '文档标题', '1', '', '1', '0', '1', '1383894778', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('4', 'category_id', '所属分类', 'int(10) unsigned NOT NULL ', 'string', '', '', '0', '', '1', '0', '1', '1384508336', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('5', 'description', '描述', 'char(140) NOT NULL ', 'textarea', '', '', '1', '', '1', '0', '1', '1383894927', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('6', 'root', '根节点', 'int(10) unsigned NOT NULL ', 'num', '0', '该文档的顶级文档编号', '0', '', '1', '0', '1', '1384508323', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('7', 'pid', '所属ID', 'int(10) unsigned NOT NULL ', 'num', '0', '父文档编号', '0', '', '1', '0', '1', '1384508543', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('8', 'model_id', '内容模型ID', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '该文档所对应的模型', '0', '', '1', '0', '1', '1384508350', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('9', 'type', '内容类型', 'tinyint(3) unsigned NOT NULL ', 'select', '2', '', '1', '1:目录\r\n2:主题\r\n3:段落', '1', '0', '1', '1384511157', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('10', 'position', '推荐位', 'smallint(5) unsigned NOT NULL ', 'checkbox', '0', '多个推荐则将其推荐值相加', '1', '1:列表推荐\r\n2:频道页推荐\r\n4:首页推荐', '1', '0', '1', '1383895640', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('11', 'link_id', '外链', 'int(10) unsigned NOT NULL ', 'num', '0', '0-非外链，大于0-外链ID,需要函数进行链接与编号的转换', '1', '', '1', '0', '1', '1383895757', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('12', 'cover_id', '封面', 'int(10) unsigned NOT NULL ', 'picture', '0', '0-无封面，大于0-封面图片ID，需要函数处理', '1', '', '1', '0', '1', '1384147827', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('13', 'display', '可见性', 'tinyint(3) unsigned NOT NULL ', 'radio', '1', '', '1', '0:不可见\r\n1:所有人可见', '1', '0', '1', '1386662271', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `train_attribute` VALUES ('14', 'deadline', '截至时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '0-永久有效', '1', '', '1', '0', '1', '1387163248', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `train_attribute` VALUES ('15', 'attach', '附件数量', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1387260355', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `train_attribute` VALUES ('16', 'view', '浏览量', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895835', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('17', 'comment', '评论数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895846', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('18', 'extend', '扩展统计字段', 'int(10) unsigned NOT NULL ', 'num', '0', '根据需求自行使用', '0', '', '1', '0', '1', '1384508264', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('19', 'level', '优先级', 'int(10) unsigned NOT NULL ', 'num', '0', '越高排序越靠前', '1', '', '1', '0', '1', '1383895894', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('20', 'create_time', '创建时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '1', '', '1', '0', '1', '1383895903', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('21', 'update_time', '更新时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '0', '', '1', '0', '1', '1384508277', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('22', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '0', '', '0', '-1:删除\r\n0:禁用\r\n1:正常\r\n2:待审核\r\n3:草稿', '1', '0', '1', '1384508496', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('23', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '2', '0', '1', '1384511049', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('24', 'content', '文章内容', 'text NOT NULL ', 'editor', '', '', '1', '', '2', '0', '1', '1383896225', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('25', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '参照display方法参数的定义', '1', '', '2', '0', '1', '1383896190', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('26', 'bookmark', '收藏数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '2', '0', '1', '1383896103', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('27', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '3', '0', '1', '1387260461', '1383891252', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `train_attribute` VALUES ('28', 'content', '下载详细描述', 'text NOT NULL ', 'editor', '', '', '1', '', '3', '0', '1', '1383896438', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('29', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '', '1', '', '3', '0', '1', '1383896429', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('30', 'file_id', '文件ID', 'int(10) unsigned NOT NULL ', 'file', '0', '需要函数处理', '1', '', '3', '0', '1', '1383896415', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('31', 'download', '下载次数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '3', '0', '1', '1383896380', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `train_attribute` VALUES ('32', 'size', '文件大小', 'bigint(20) unsigned NOT NULL ', 'num', '0', '单位bit', '1', '', '3', '0', '1', '1383896371', '1383891252', '', '0', '', '', '', '0', '');

-- ----------------------------
-- Table structure for train_auth_extend
-- ----------------------------
DROP TABLE IF EXISTS `train_auth_extend`;
CREATE TABLE `train_auth_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- ----------------------------
-- Records of train_auth_extend
-- ----------------------------
INSERT INTO `train_auth_extend` VALUES ('1', '1', '1');
INSERT INTO `train_auth_extend` VALUES ('1', '1', '2');
INSERT INTO `train_auth_extend` VALUES ('1', '2', '1');
INSERT INTO `train_auth_extend` VALUES ('1', '2', '2');
INSERT INTO `train_auth_extend` VALUES ('1', '3', '1');
INSERT INTO `train_auth_extend` VALUES ('1', '3', '2');
INSERT INTO `train_auth_extend` VALUES ('1', '4', '1');
INSERT INTO `train_auth_extend` VALUES ('1', '37', '1');

-- ----------------------------
-- Table structure for train_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `train_auth_group`;
CREATE TABLE `train_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_auth_group
-- ----------------------------
INSERT INTO `train_auth_group` VALUES ('1', 'admin', '1', '默认用户组', '', '1', '1,2,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,81,82,83,84,86,87,88,89,90,91,92,93,94,95,96,97,100,102,103,105,106');
INSERT INTO `train_auth_group` VALUES ('2', 'admin', '1', '测试用户', '测试用户', '1', '1,2,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,82,83,84,88,89,90,91,92,93,96,97,100,102,103,195');
INSERT INTO `train_auth_group` VALUES ('3', 'admin', '1', '前台客服', '可查看订单和报表', '1', '1,217,218,219,220,221,222');
INSERT INTO `train_auth_group` VALUES ('4', 'admin', '1', '场馆管理员', '', '1', '1,217,218,219,220,221,222,223,224,225,226');

-- ----------------------------
-- Table structure for train_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `train_auth_group_access`;
CREATE TABLE `train_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_auth_group_access
-- ----------------------------
INSERT INTO `train_auth_group_access` VALUES ('17', '3');
INSERT INTO `train_auth_group_access` VALUES ('18', '3');
INSERT INTO `train_auth_group_access` VALUES ('19', '3');
INSERT INTO `train_auth_group_access` VALUES ('20', '3');
INSERT INTO `train_auth_group_access` VALUES ('21', '3');
INSERT INTO `train_auth_group_access` VALUES ('22', '3');
INSERT INTO `train_auth_group_access` VALUES ('23', '3');
INSERT INTO `train_auth_group_access` VALUES ('24', '4');

-- ----------------------------
-- Table structure for train_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `train_auth_rule`;
CREATE TABLE `train_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=227 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_auth_rule
-- ----------------------------
INSERT INTO `train_auth_rule` VALUES ('1', 'admin', '2', 'Admin/Index/index', '首页', '1', '');
INSERT INTO `train_auth_rule` VALUES ('2', 'admin', '2', 'Admin/Article/mydocument', '内容', '1', '');
INSERT INTO `train_auth_rule` VALUES ('3', 'admin', '2', 'Admin/User/index', '用户', '1', '');
INSERT INTO `train_auth_rule` VALUES ('4', 'admin', '2', 'Admin/Addons/index', '扩展', '1', '');
INSERT INTO `train_auth_rule` VALUES ('5', 'admin', '2', 'Admin/Config/group', '系统', '1', '');
INSERT INTO `train_auth_rule` VALUES ('7', 'admin', '1', 'Admin/article/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('8', 'admin', '1', 'Admin/article/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('9', 'admin', '1', 'Admin/article/setStatus', '改变状态', '1', '');
INSERT INTO `train_auth_rule` VALUES ('10', 'admin', '1', 'Admin/article/update', '保存', '1', '');
INSERT INTO `train_auth_rule` VALUES ('11', 'admin', '1', 'Admin/article/autoSave', '保存草稿', '1', '');
INSERT INTO `train_auth_rule` VALUES ('12', 'admin', '1', 'Admin/article/move', '移动', '1', '');
INSERT INTO `train_auth_rule` VALUES ('13', 'admin', '1', 'Admin/article/copy', '复制', '1', '');
INSERT INTO `train_auth_rule` VALUES ('14', 'admin', '1', 'Admin/article/paste', '粘贴', '1', '');
INSERT INTO `train_auth_rule` VALUES ('15', 'admin', '1', 'Admin/article/permit', '还原', '1', '');
INSERT INTO `train_auth_rule` VALUES ('16', 'admin', '1', 'Admin/article/clear', '清空', '1', '');
INSERT INTO `train_auth_rule` VALUES ('17', 'admin', '1', 'Admin/article/index', '文档列表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('18', 'admin', '1', 'Admin/article/recycle', '回收站', '1', '');
INSERT INTO `train_auth_rule` VALUES ('19', 'admin', '1', 'Admin/User/addaction', '新增用户行为', '1', '');
INSERT INTO `train_auth_rule` VALUES ('20', 'admin', '1', 'Admin/User/editaction', '编辑用户行为', '1', '');
INSERT INTO `train_auth_rule` VALUES ('21', 'admin', '1', 'Admin/User/saveAction', '保存用户行为', '1', '');
INSERT INTO `train_auth_rule` VALUES ('22', 'admin', '1', 'Admin/User/setStatus', '变更行为状态', '1', '');
INSERT INTO `train_auth_rule` VALUES ('23', 'admin', '1', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '1', '');
INSERT INTO `train_auth_rule` VALUES ('24', 'admin', '1', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '1', '');
INSERT INTO `train_auth_rule` VALUES ('25', 'admin', '1', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '1', '');
INSERT INTO `train_auth_rule` VALUES ('26', 'admin', '1', 'Admin/User/index', '用户信息', '1', '');
INSERT INTO `train_auth_rule` VALUES ('27', 'admin', '1', 'Admin/User/action', '用户行为', '1', '');
INSERT INTO `train_auth_rule` VALUES ('28', 'admin', '1', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('29', 'admin', '1', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '1', '');
INSERT INTO `train_auth_rule` VALUES ('30', 'admin', '1', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '1', '');
INSERT INTO `train_auth_rule` VALUES ('31', 'admin', '1', 'Admin/AuthManager/createGroup', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('32', 'admin', '1', 'Admin/AuthManager/editGroup', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('33', 'admin', '1', 'Admin/AuthManager/writeGroup', '保存用户组', '1', '');
INSERT INTO `train_auth_rule` VALUES ('34', 'admin', '1', 'Admin/AuthManager/group', '授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('35', 'admin', '1', 'Admin/AuthManager/access', '访问授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('36', 'admin', '1', 'Admin/AuthManager/user', '成员授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('37', 'admin', '1', 'Admin/AuthManager/removeFromGroup', '解除授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('38', 'admin', '1', 'Admin/AuthManager/addToGroup', '保存成员授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('39', 'admin', '1', 'Admin/AuthManager/category', '分类授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('40', 'admin', '1', 'Admin/AuthManager/addToCategory', '保存分类授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('41', 'admin', '1', 'Admin/AuthManager/index', '权限管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('42', 'admin', '1', 'Admin/Addons/create', '创建', '1', '');
INSERT INTO `train_auth_rule` VALUES ('43', 'admin', '1', 'Admin/Addons/checkForm', '检测创建', '1', '');
INSERT INTO `train_auth_rule` VALUES ('44', 'admin', '1', 'Admin/Addons/preview', '预览', '1', '');
INSERT INTO `train_auth_rule` VALUES ('45', 'admin', '1', 'Admin/Addons/build', '快速生成插件', '1', '');
INSERT INTO `train_auth_rule` VALUES ('46', 'admin', '1', 'Admin/Addons/config', '设置', '1', '');
INSERT INTO `train_auth_rule` VALUES ('47', 'admin', '1', 'Admin/Addons/disable', '禁用', '1', '');
INSERT INTO `train_auth_rule` VALUES ('48', 'admin', '1', 'Admin/Addons/enable', '启用', '1', '');
INSERT INTO `train_auth_rule` VALUES ('49', 'admin', '1', 'Admin/Addons/install', '安装', '1', '');
INSERT INTO `train_auth_rule` VALUES ('50', 'admin', '1', 'Admin/Addons/uninstall', '卸载', '1', '');
INSERT INTO `train_auth_rule` VALUES ('51', 'admin', '1', 'Admin/Addons/saveconfig', '更新配置', '1', '');
INSERT INTO `train_auth_rule` VALUES ('52', 'admin', '1', 'Admin/Addons/adminList', '插件后台列表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('53', 'admin', '1', 'Admin/Addons/execute', 'URL方式访问插件', '1', '');
INSERT INTO `train_auth_rule` VALUES ('54', 'admin', '1', 'Admin/Addons/index', '插件管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('55', 'admin', '1', 'Admin/Addons/hooks', '钩子管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('56', 'admin', '1', 'Admin/model/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('57', 'admin', '1', 'Admin/model/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('58', 'admin', '1', 'Admin/model/setStatus', '改变状态', '1', '');
INSERT INTO `train_auth_rule` VALUES ('59', 'admin', '1', 'Admin/model/update', '保存数据', '1', '');
INSERT INTO `train_auth_rule` VALUES ('60', 'admin', '1', 'Admin/Model/index', '模型管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('61', 'admin', '1', 'Admin/Config/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('62', 'admin', '1', 'Admin/Config/del', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('63', 'admin', '1', 'Admin/Config/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('64', 'admin', '1', 'Admin/Config/save', '保存', '1', '');
INSERT INTO `train_auth_rule` VALUES ('65', 'admin', '1', 'Admin/Config/group', '网站设置', '1', '');
INSERT INTO `train_auth_rule` VALUES ('66', 'admin', '1', 'Admin/Config/index', '配置管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('67', 'admin', '1', 'Admin/Channel/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('68', 'admin', '1', 'Admin/Channel/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('69', 'admin', '1', 'Admin/Channel/del', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('70', 'admin', '1', 'Admin/Channel/index', '导航管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('71', 'admin', '1', 'Admin/Category/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('72', 'admin', '1', 'Admin/Category/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('73', 'admin', '1', 'Admin/Category/remove', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('74', 'admin', '1', 'Admin/Category/index', '分类管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('75', 'admin', '1', 'Admin/file/upload', '上传控件', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('76', 'admin', '1', 'Admin/file/uploadPicture', '上传图片', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('77', 'admin', '1', 'Admin/file/download', '下载', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('94', 'admin', '1', 'Admin/AuthManager/modelauth', '模型授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('79', 'admin', '1', 'Admin/article/batchOperate', '导入', '1', '');
INSERT INTO `train_auth_rule` VALUES ('80', 'admin', '1', 'Admin/Database/index?type=export', '备份数据库', '1', '');
INSERT INTO `train_auth_rule` VALUES ('81', 'admin', '1', 'Admin/Database/index?type=import', '还原数据库', '1', '');
INSERT INTO `train_auth_rule` VALUES ('82', 'admin', '1', 'Admin/Database/export', '备份', '1', '');
INSERT INTO `train_auth_rule` VALUES ('83', 'admin', '1', 'Admin/Database/optimize', '优化表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('84', 'admin', '1', 'Admin/Database/repair', '修复表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('86', 'admin', '1', 'Admin/Database/import', '恢复', '1', '');
INSERT INTO `train_auth_rule` VALUES ('87', 'admin', '1', 'Admin/Database/del', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('88', 'admin', '1', 'Admin/User/add', '新增用户', '1', '');
INSERT INTO `train_auth_rule` VALUES ('89', 'admin', '1', 'Admin/Attribute/index', '属性管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('90', 'admin', '1', 'Admin/Attribute/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('91', 'admin', '1', 'Admin/Attribute/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('92', 'admin', '1', 'Admin/Attribute/setStatus', '改变状态', '1', '');
INSERT INTO `train_auth_rule` VALUES ('93', 'admin', '1', 'Admin/Attribute/update', '保存数据', '1', '');
INSERT INTO `train_auth_rule` VALUES ('95', 'admin', '1', 'Admin/AuthManager/addToModel', '保存模型授权', '1', '');
INSERT INTO `train_auth_rule` VALUES ('96', 'admin', '1', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('97', 'admin', '1', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('98', 'admin', '1', 'Admin/Config/menu', '后台菜单管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('99', 'admin', '1', 'Admin/Article/mydocument', '内容', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('100', 'admin', '1', 'Admin/Menu/index', '菜单管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('101', 'admin', '1', 'Admin/other', '其他', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('102', 'admin', '1', 'Admin/Menu/add', '新增', '1', '');
INSERT INTO `train_auth_rule` VALUES ('103', 'admin', '1', 'Admin/Menu/edit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('104', 'admin', '1', 'Admin/Think/lists?model=article', '文章管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('105', 'admin', '1', 'Admin/Think/lists?model=download', '下载管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('106', 'admin', '1', 'Admin/Think/lists?model=config', '配置管理', '1', '');
INSERT INTO `train_auth_rule` VALUES ('107', 'admin', '1', 'Admin/Action/actionlog', '行为日志', '1', '');
INSERT INTO `train_auth_rule` VALUES ('108', 'admin', '1', 'Admin/User/updatePassword', '修改密码', '1', '');
INSERT INTO `train_auth_rule` VALUES ('109', 'admin', '1', 'Admin/User/updateNickname', '修改昵称', '1', '');
INSERT INTO `train_auth_rule` VALUES ('110', 'admin', '1', 'Admin/action/edit', '查看行为日志', '1', '');
INSERT INTO `train_auth_rule` VALUES ('205', 'admin', '1', 'Admin/think/add', '新增数据', '1', '');
INSERT INTO `train_auth_rule` VALUES ('111', 'admin', '2', 'Admin/article/index', '文档列表', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('112', 'admin', '2', 'Admin/article/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('113', 'admin', '2', 'Admin/article/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('114', 'admin', '2', 'Admin/article/setStatus', '改变状态', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('115', 'admin', '2', 'Admin/article/update', '保存', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('116', 'admin', '2', 'Admin/article/autoSave', '保存草稿', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('117', 'admin', '2', 'Admin/article/move', '移动', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('118', 'admin', '2', 'Admin/article/copy', '复制', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('119', 'admin', '2', 'Admin/article/paste', '粘贴', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('120', 'admin', '2', 'Admin/article/batchOperate', '导入', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('121', 'admin', '2', 'Admin/article/recycle', '回收站', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('122', 'admin', '2', 'Admin/article/permit', '还原', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('123', 'admin', '2', 'Admin/article/clear', '清空', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('124', 'admin', '2', 'Admin/User/add', '新增用户', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('125', 'admin', '2', 'Admin/User/action', '用户行为', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('126', 'admin', '2', 'Admin/User/addAction', '新增用户行为', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('127', 'admin', '2', 'Admin/User/editAction', '编辑用户行为', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('128', 'admin', '2', 'Admin/User/saveAction', '保存用户行为', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('129', 'admin', '2', 'Admin/User/setStatus', '变更行为状态', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('130', 'admin', '2', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('131', 'admin', '2', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('132', 'admin', '2', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('133', 'admin', '2', 'Admin/AuthManager/index', '权限管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('134', 'admin', '2', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('135', 'admin', '2', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('136', 'admin', '2', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('137', 'admin', '2', 'Admin/AuthManager/createGroup', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('138', 'admin', '2', 'Admin/AuthManager/editGroup', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('139', 'admin', '2', 'Admin/AuthManager/writeGroup', '保存用户组', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('140', 'admin', '2', 'Admin/AuthManager/group', '授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('141', 'admin', '2', 'Admin/AuthManager/access', '访问授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('142', 'admin', '2', 'Admin/AuthManager/user', '成员授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('143', 'admin', '2', 'Admin/AuthManager/removeFromGroup', '解除授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('144', 'admin', '2', 'Admin/AuthManager/addToGroup', '保存成员授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('145', 'admin', '2', 'Admin/AuthManager/category', '分类授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('146', 'admin', '2', 'Admin/AuthManager/addToCategory', '保存分类授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('147', 'admin', '2', 'Admin/AuthManager/modelauth', '模型授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('148', 'admin', '2', 'Admin/AuthManager/addToModel', '保存模型授权', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('149', 'admin', '2', 'Admin/Addons/create', '创建', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('150', 'admin', '2', 'Admin/Addons/checkForm', '检测创建', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('151', 'admin', '2', 'Admin/Addons/preview', '预览', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('152', 'admin', '2', 'Admin/Addons/build', '快速生成插件', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('153', 'admin', '2', 'Admin/Addons/config', '设置', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('154', 'admin', '2', 'Admin/Addons/disable', '禁用', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('155', 'admin', '2', 'Admin/Addons/enable', '启用', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('156', 'admin', '2', 'Admin/Addons/install', '安装', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('157', 'admin', '2', 'Admin/Addons/uninstall', '卸载', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('158', 'admin', '2', 'Admin/Addons/saveconfig', '更新配置', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('159', 'admin', '2', 'Admin/Addons/adminList', '插件后台列表', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('160', 'admin', '2', 'Admin/Addons/execute', 'URL方式访问插件', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('161', 'admin', '2', 'Admin/Addons/hooks', '钩子管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('162', 'admin', '2', 'Admin/Model/index', '模型管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('163', 'admin', '2', 'Admin/model/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('164', 'admin', '2', 'Admin/model/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('165', 'admin', '2', 'Admin/model/setStatus', '改变状态', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('166', 'admin', '2', 'Admin/model/update', '保存数据', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('167', 'admin', '2', 'Admin/Attribute/index', '属性管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('168', 'admin', '2', 'Admin/Attribute/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('169', 'admin', '2', 'Admin/Attribute/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('170', 'admin', '2', 'Admin/Attribute/setStatus', '改变状态', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('171', 'admin', '2', 'Admin/Attribute/update', '保存数据', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('172', 'admin', '2', 'Admin/Config/index', '配置管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('173', 'admin', '2', 'Admin/Config/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('174', 'admin', '2', 'Admin/Config/del', '删除', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('175', 'admin', '2', 'Admin/Config/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('176', 'admin', '2', 'Admin/Config/save', '保存', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('177', 'admin', '2', 'Admin/Menu/index', '菜单管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('178', 'admin', '2', 'Admin/Channel/index', '导航管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('179', 'admin', '2', 'Admin/Channel/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('180', 'admin', '2', 'Admin/Channel/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('181', 'admin', '2', 'Admin/Channel/del', '删除', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('182', 'admin', '2', 'Admin/Category/index', '分类管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('183', 'admin', '2', 'Admin/Category/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('184', 'admin', '2', 'Admin/Category/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('185', 'admin', '2', 'Admin/Category/remove', '删除', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('186', 'admin', '2', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('187', 'admin', '2', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('188', 'admin', '2', 'Admin/Database/index?type=export', '备份数据库', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('189', 'admin', '2', 'Admin/Database/export', '备份', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('190', 'admin', '2', 'Admin/Database/optimize', '优化表', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('191', 'admin', '2', 'Admin/Database/repair', '修复表', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('192', 'admin', '2', 'Admin/Database/index?type=import', '还原数据库', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('193', 'admin', '2', 'Admin/Database/import', '恢复', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('194', 'admin', '2', 'Admin/Database/del', '删除', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('195', 'admin', '2', 'Admin/other', '其他', '1', '');
INSERT INTO `train_auth_rule` VALUES ('196', 'admin', '2', 'Admin/Menu/add', '新增', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('197', 'admin', '2', 'Admin/Menu/edit', '编辑', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('198', 'admin', '2', 'Admin/Think/lists?model=article', '应用', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('199', 'admin', '2', 'Admin/Think/lists?model=download', '下载管理', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('200', 'admin', '2', 'Admin/Think/lists?model=config', '应用', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('201', 'admin', '2', 'Admin/Action/actionlog', '行为日志', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('202', 'admin', '2', 'Admin/User/updatePassword', '修改密码', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('203', 'admin', '2', 'Admin/User/updateNickname', '修改昵称', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('204', 'admin', '2', 'Admin/action/edit', '查看行为日志', '-1', '');
INSERT INTO `train_auth_rule` VALUES ('206', 'admin', '1', 'Admin/think/edit', '编辑数据', '1', '');
INSERT INTO `train_auth_rule` VALUES ('207', 'admin', '1', 'Admin/Menu/import', '导入', '1', '');
INSERT INTO `train_auth_rule` VALUES ('208', 'admin', '1', 'Admin/Model/generate', '生成', '1', '');
INSERT INTO `train_auth_rule` VALUES ('209', 'admin', '1', 'Admin/Addons/addHook', '新增钩子', '1', '');
INSERT INTO `train_auth_rule` VALUES ('210', 'admin', '1', 'Admin/Addons/edithook', '编辑钩子', '1', '');
INSERT INTO `train_auth_rule` VALUES ('211', 'admin', '1', 'Admin/Article/sort', '文档排序', '1', '');
INSERT INTO `train_auth_rule` VALUES ('212', 'admin', '1', 'Admin/Config/sort', '排序', '1', '');
INSERT INTO `train_auth_rule` VALUES ('213', 'admin', '1', 'Admin/Menu/sort', '排序', '1', '');
INSERT INTO `train_auth_rule` VALUES ('214', 'admin', '1', 'Admin/Channel/sort', '排序', '1', '');
INSERT INTO `train_auth_rule` VALUES ('215', 'admin', '1', 'Admin/Category/operate/type/move', '移动', '1', '');
INSERT INTO `train_auth_rule` VALUES ('216', 'admin', '1', 'Admin/Category/operate/type/merge', '合并', '1', '');
INSERT INTO `train_auth_rule` VALUES ('217', 'admin', '1', 'Admin/Sport/order', '订单列表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('218', 'admin', '1', 'Admin/Report/ticketReport', '订单流水', '1', '');
INSERT INTO `train_auth_rule` VALUES ('219', 'admin', '1', 'Admin/Sport/orderEdit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('220', 'admin', '1', 'Admin/Sport/orderDelete', '删除', '1', '');
INSERT INTO `train_auth_rule` VALUES ('221', 'admin', '2', 'Admin/Sport/order', '培训', '1', '');
INSERT INTO `train_auth_rule` VALUES ('222', 'admin', '1', 'Admin/Excel/everySales', '日报表导出', '1', '');
INSERT INTO `train_auth_rule` VALUES ('223', 'admin', '1', 'Admin/Course/index', '课程列表', '1', '');
INSERT INTO `train_auth_rule` VALUES ('224', 'admin', '1', 'Admin/Course/indexEdit', '编辑', '1', '');
INSERT INTO `train_auth_rule` VALUES ('225', 'admin', '1', 'Admin/Course/indexAdd', '添加', '1', '');
INSERT INTO `train_auth_rule` VALUES ('226', 'admin', '1', 'Admin/Course/indexDel', '删除', '1', '');

-- ----------------------------
-- Table structure for train_category
-- ----------------------------
DROP TABLE IF EXISTS `train_category`;
CREATE TABLE `train_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '关联模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` text NOT NULL COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类图标',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of train_category
-- ----------------------------
INSERT INTO `train_category` VALUES ('1', 'blog', '博客', '0', '0', '10', '', '', '', '', '', '', '', '2', '2,1', '0', '0', '1', '0', '0', '1', '', '1379474947', '1382701539', '1', '0');
INSERT INTO `train_category` VALUES ('2', 'default_blog', '默认分类', '1', '1', '10', '', '', '', '', '', '', '', '2', '2,1,3', '0', '1', '1', '0', '1', '1', '', '1379475028', '1386839751', '1', '31');

-- ----------------------------
-- Table structure for train_channel
-- ----------------------------
DROP TABLE IF EXISTS `train_channel`;
CREATE TABLE `train_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_channel
-- ----------------------------
INSERT INTO `train_channel` VALUES ('1', '0', '首页', 'Index/index', '1', '1379475111', '1379923177', '1', '0');
INSERT INTO `train_channel` VALUES ('2', '0', '博客', 'Article/index?category=blog', '2', '1379475131', '1379483713', '1', '0');
INSERT INTO `train_channel` VALUES ('3', '0', '官网', 'http://www.onethink.cn', '3', '1379475154', '1387163458', '1', '0');

-- ----------------------------
-- Table structure for train_class
-- ----------------------------
DROP TABLE IF EXISTS `train_class`;
CREATE TABLE `train_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '教练ID',
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `starttime` int(11) NOT NULL DEFAULT '0' COMMENT '课程开始时间',
  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '课程结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0->未开始，1->上课中，2->已结束，3->请假',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生课表';

-- ----------------------------
-- Records of train_class
-- ----------------------------

-- ----------------------------
-- Table structure for train_coach
-- ----------------------------
DROP TABLE IF EXISTS `train_coach`;
CREATE TABLE `train_coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户openid',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `headimg` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `cardnum` varchar(255) NOT NULL DEFAULT '' COMMENT '卡号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '教练姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0->男，1->女',
  `age` int(11) NOT NULL DEFAULT '0' COMMENT '年龄',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系方式',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教练表';

-- ----------------------------
-- Records of train_coach
-- ----------------------------

-- ----------------------------
-- Table structure for train_config
-- ----------------------------
DROP TABLE IF EXISTS `train_config`;
CREATE TABLE `train_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_config
-- ----------------------------
INSERT INTO `train_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1379235274', '1', 'OneThink内容管理框架', '0');
INSERT INTO `train_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', 'OneThink内容管理框架', '1');
INSERT INTO `train_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', 'ThinkPHP,OneThink', '8');
INSERT INTO `train_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1379235296', '1', '1', '1');
INSERT INTO `train_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '4', '', '主要用于数据解析和页面表单的生成', '1378898976', '1379235348', '1', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', '2');
INSERT INTO `train_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1379235859', '1', '', '9');
INSERT INTO `train_config` VALUES ('11', 'DOCUMENT_POSITION', '3', '文档推荐位', '2', '', '文档推荐位，推荐到多个位置KEY值相加即可', '1379053380', '1379235329', '1', '1:列表页推荐\r\n2:频道页推荐\r\n4:网站首页推荐', '3');
INSERT INTO `train_config` VALUES ('12', 'DOCUMENT_DISPLAY', '3', '文档可见性', '2', '', '文章可见性仅影响前台显示，后台不收影响', '1379056370', '1379235322', '1', '0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见', '4');
INSERT INTO `train_config` VALUES ('13', 'COLOR_STYLE', '4', '后台色系', '1', 'default_color:默认\r\nblue_color:紫罗兰', '后台颜色风格', '1379122533', '1379235904', '1', 'default_color', '10');
INSERT INTO `train_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '配置分组', '1379228036', '1384418383', '1', '1:基本\r\n2:内容\r\n3:用户\r\n4:系统', '4');
INSERT INTO `train_config` VALUES ('21', 'HOOKS_TYPE', '3', '钩子的类型', '4', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1379313397', '1379313407', '1', '1:视图\r\n2:控制器', '6');
INSERT INTO `train_config` VALUES ('22', 'AUTH_CONFIG', '3', 'Auth配置', '4', '', '自定义Auth.class.php类配置', '1379409310', '1379409564', '1', 'AUTH_ON:1\r\nAUTH_TYPE:2', '8');
INSERT INTO `train_config` VALUES ('23', 'OPEN_DRAFTBOX', '4', '是否开启草稿功能', '2', '0:关闭草稿功能\r\n1:开启草稿功能\r\n', '新增文章时的草稿功能配置', '1379484332', '1379484591', '1', '1', '1');
INSERT INTO `train_config` VALUES ('24', 'DRAFT_AOTOSAVE_INTERVAL', '0', '自动保存草稿时间', '2', '', '自动保存草稿的时间间隔，单位：秒', '1379484574', '1386143323', '1', '60', '2');
INSERT INTO `train_config` VALUES ('25', 'LIST_ROWS', '0', '后台每页记录数', '2', '', '后台数据每页显示记录数', '1379503896', '1380427745', '1', '10', '10');
INSERT INTO `train_config` VALUES ('26', 'USER_ALLOW_REGISTER', '4', '是否允许用户注册', '3', '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '1379504487', '1379504580', '1', '1', '3');
INSERT INTO `train_config` VALUES ('27', 'CODEMIRROR_THEME', '4', '预览插件的CodeMirror主题', '4', '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', '1379814385', '1384740813', '1', 'ambiance', '3');
INSERT INTO `train_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1381482411', '1', './Data/', '5');
INSERT INTO `train_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '7');
INSERT INTO `train_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1381729544', '1', '1', '9');
INSERT INTO `train_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1381713408', '1', '9', '10');
INSERT INTO `train_config` VALUES ('32', 'DEVELOP_MODE', '4', '开启开发者模式', '4', '0:关闭\r\n1:开启', '是否开启开发者模式', '1383105995', '1383291877', '1', '1', '11');
INSERT INTO `train_config` VALUES ('33', 'ALLOW_VISIT', '3', '不受限控制器方法', '0', '', '', '1386644047', '1386644741', '1', '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', '0');
INSERT INTO `train_config` VALUES ('34', 'DENY_VISIT', '3', '超管专限控制器方法', '0', '', '仅超级管理员可访问的控制器方法', '1386644141', '1386644659', '1', '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', '0');
INSERT INTO `train_config` VALUES ('35', 'REPLY_LIST_ROWS', '0', '回复列表每页条数', '2', '', '', '1386645376', '1387178083', '1', '10', '0');
INSERT INTO `train_config` VALUES ('36', 'ADMIN_ALLOW_IP', '2', '后台允许访问IP', '4', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '1387165454', '1387165553', '1', '', '12');
INSERT INTO `train_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace', '4', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '1', '0', '1');

-- ----------------------------
-- Table structure for train_document
-- ----------------------------
DROP TABLE IF EXISTS `train_document`;
CREATE TABLE `train_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(40) NOT NULL DEFAULT '' COMMENT '标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `description` char(140) NOT NULL DEFAULT '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  PRIMARY KEY (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of train_document
-- ----------------------------
INSERT INTO `train_document` VALUES ('1', '1', '', 'OneThink1.0正式版发布', '2', '大家期待的OneThink正式版发布', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '9', '0', '0', '0', '1387260660', '1387263112', '1');

-- ----------------------------
-- Table structure for train_document_article
-- ----------------------------
DROP TABLE IF EXISTS `train_document_article`;
CREATE TABLE `train_document_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `bookmark` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of train_document_article
-- ----------------------------
INSERT INTO `train_document_article` VALUES ('1', '0', '<h1>\r\n	OneThink1.0正式版发布&nbsp;\r\n</h1>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink是一个开源的内容管理框架，基于最新的ThinkPHP3.2版本开发，提供更方便、更安全的WEB应用开发体验，采用了全新的架构设计和命名空间机制，融合了模块化、驱动化和插件化的设计理念于一体，开启了国内WEB应用傻瓜式开发的新潮流。&nbsp;</strong> \r\n</p>\r\n<h2>\r\n	主要特性：\r\n</h2>\r\n<p>\r\n	1. 基于ThinkPHP最新3.2版本。\r\n</p>\r\n<p>\r\n	2. 模块化：全新的架构和模块化的开发机制，便于灵活扩展和二次开发。&nbsp;\r\n</p>\r\n<p>\r\n	3. 文档模型/分类体系：通过和文档模型绑定，以及不同的文档类型，不同分类可以实现差异化的功能，轻松实现诸如资讯、下载、讨论和图片等功能。\r\n</p>\r\n<p>\r\n	4. 开源免费：OneThink遵循Apache2开源协议,免费提供使用。&nbsp;\r\n</p>\r\n<p>\r\n	5. 用户行为：支持自定义用户行为，可以对单个用户或者群体用户的行为进行记录及分享，为您的运营决策提供有效参考数据。\r\n</p>\r\n<p>\r\n	6. 云端部署：通过驱动的方式可以轻松支持平台的部署，让您的网站无缝迁移，内置已经支持SAE和BAE3.0。\r\n</p>\r\n<p>\r\n	7. 云服务支持：即将启动支持云存储、云安全、云过滤和云统计等服务，更多贴心的服务让您的网站更安心。\r\n</p>\r\n<p>\r\n	8. 安全稳健：提供稳健的安全策略，包括备份恢复、容错、防止恶意攻击登录，网页防篡改等多项安全管理功能，保证系统安全，可靠、稳定的运行。&nbsp;\r\n</p>\r\n<p>\r\n	9. 应用仓库：官方应用仓库拥有大量来自第三方插件和应用模块、模板主题，有众多来自开源社区的贡献，让您的网站“One”美无缺。&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>&nbsp;OneThink集成了一个完善的后台管理体系和前台模板标签系统，让你轻松管理数据和进行前台网站的标签式开发。&nbsp;</strong> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<h2>\r\n	后台主要功能：\r\n</h2>\r\n<p>\r\n	1. 用户Passport系统\r\n</p>\r\n<p>\r\n	2. 配置管理系统&nbsp;\r\n</p>\r\n<p>\r\n	3. 权限控制系统\r\n</p>\r\n<p>\r\n	4. 后台建模系统&nbsp;\r\n</p>\r\n<p>\r\n	5. 多级分类系统&nbsp;\r\n</p>\r\n<p>\r\n	6. 用户行为系统&nbsp;\r\n</p>\r\n<p>\r\n	7. 钩子和插件系统\r\n</p>\r\n<p>\r\n	8. 系统日志系统&nbsp;\r\n</p>\r\n<p>\r\n	9. 数据备份和还原\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp;[ 官方下载：&nbsp;<a href=\"http://www.onethink.cn/download.html\" target=\"_blank\">http://www.onethink.cn/download.html</a>&nbsp;&nbsp;开发手册：<a href=\"http://document.onethink.cn/\" target=\"_blank\">http://document.onethink.cn/</a>&nbsp;]&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>OneThink开发团队 2013</strong> \r\n</p>', '', '0');

-- ----------------------------
-- Table structure for train_document_download
-- ----------------------------
DROP TABLE IF EXISTS `train_document_download`;
CREATE TABLE `train_document_download` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '下载详细描述',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型下载表';

-- ----------------------------
-- Records of train_document_download
-- ----------------------------

-- ----------------------------
-- Table structure for train_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `train_evaluate`;
CREATE TABLE `train_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '教练ID',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '评分',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评价内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '评价时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评价表';

-- ----------------------------
-- Records of train_evaluate
-- ----------------------------

-- ----------------------------
-- Table structure for train_exchange
-- ----------------------------
DROP TABLE IF EXISTS `train_exchange`;
CREATE TABLE `train_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `old_oid` int(11) NOT NULL DEFAULT '0' COMMENT '旧的订单ID',
  `new_oid` int(11) NOT NULL DEFAULT '0' COMMENT '新的订单ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '学生ID',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '教练ID',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '差额',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '退换课原因',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退换课申请表';

-- ----------------------------
-- Records of train_exchange
-- ----------------------------

-- ----------------------------
-- Table structure for train_file
-- ----------------------------
DROP TABLE IF EXISTS `train_file`;
CREATE TABLE `train_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of train_file
-- ----------------------------

-- ----------------------------
-- Table structure for train_gym
-- ----------------------------
DROP TABLE IF EXISTS `train_gym`;
CREATE TABLE `train_gym` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '体育馆名称',
  `province` varchar(255) NOT NULL DEFAULT '江苏省' COMMENT '省份',
  `city` varchar(255) NOT NULL DEFAULT '南京市' COMMENT '市区',
  `area` varchar(255) NOT NULL DEFAULT '南京市区' COMMENT '区县',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '具体地址',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo图标地址',
  `linkman` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人',
  `telephone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `adminids` varchar(255) NOT NULL DEFAULT '' COMMENT '从属管理员的ID列表',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '场馆类型',
  `orderconfigid` int(11) NOT NULL DEFAULT '0' COMMENT '预定配置表',
  `priceconfigid` int(11) NOT NULL DEFAULT '0' COMMENT '价格配置表',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '场馆描述',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='体育馆表';

-- ----------------------------
-- Records of train_gym
-- ----------------------------
INSERT INTO `train_gym` VALUES ('1', '苏州市市民健身中心', '江苏省', '苏州市', '姑苏区', '民治路277号', '', '', '', '', '6', '0', '0', '0', '0', '', '');
INSERT INTO `train_gym` VALUES ('2', '苏州市市民健身中心（锦帆路）', '江苏省', '苏州市', '姑苏区', '民治路277号', '', '', '', '', '6', '0', '0', '0', '0', '', '');

-- ----------------------------
-- Table structure for train_hooks
-- ----------------------------
DROP TABLE IF EXISTS `train_hooks`;
CREATE TABLE `train_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_hooks
-- ----------------------------
INSERT INTO `train_hooks` VALUES ('1', 'pageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '1', '0', '');
INSERT INTO `train_hooks` VALUES ('2', 'pageFooter', '页面footer钩子，一般用于加载插件JS文件和JS代码', '1', '0', 'ReturnTop');
INSERT INTO `train_hooks` VALUES ('3', 'documentEditForm', '添加编辑表单的 扩展内容钩子', '1', '0', 'Attachment');
INSERT INTO `train_hooks` VALUES ('4', 'documentDetailAfter', '文档末尾显示', '1', '0', 'Attachment,SocialComment');
INSERT INTO `train_hooks` VALUES ('5', 'documentDetailBefore', '页面内容前显示用钩子', '1', '0', '');
INSERT INTO `train_hooks` VALUES ('6', 'documentSaveComplete', '保存文档数据后的扩展钩子', '2', '0', 'Attachment');
INSERT INTO `train_hooks` VALUES ('7', 'documentEditFormContent', '添加编辑表单的内容显示钩子', '1', '0', 'Editor');
INSERT INTO `train_hooks` VALUES ('8', 'adminArticleEdit', '后台内容编辑页编辑器', '1', '1378982734', 'EditorForAdmin');
INSERT INTO `train_hooks` VALUES ('13', 'AdminIndex', '首页小格子个性化显示', '1', '1382596073', 'SiteStat,SystemInfo,DevTeam');
INSERT INTO `train_hooks` VALUES ('14', 'topicComment', '评论提交方式扩展钩子。', '1', '1380163518', 'Editor');
INSERT INTO `train_hooks` VALUES ('16', 'app_begin', '应用开始', '2', '1384481614', '');

-- ----------------------------
-- Table structure for train_member
-- ----------------------------
DROP TABLE IF EXISTS `train_member`;
CREATE TABLE `train_member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` char(10) NOT NULL DEFAULT '' COMMENT 'qq号',
  `score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of train_member
-- ----------------------------
INSERT INTO `train_member` VALUES ('1', 'admin', '0', '0000-00-00', '', '90', '104', '0', '1487828308', '3730730455', '1494395473', '1');
INSERT INTO `train_member` VALUES ('17', '881', '0', '0000-00-00', '', '300', '115', '0', '0', '3549427034', '1493789914', '1');
INSERT INTO `train_member` VALUES ('18', '882', '0', '0000-00-00', '', '310', '260', '0', '0', '3549427034', '1494247468', '1');
INSERT INTO `train_member` VALUES ('19', '883', '0', '0000-00-00', '', '510', '233', '0', '0', '3549427034', '1494392453', '1');
INSERT INTO `train_member` VALUES ('20', '884', '0', '0000-00-00', '', '330', '132', '0', '0', '3549427034', '1494337026', '1');
INSERT INTO `train_member` VALUES ('21', '885', '0', '0000-00-00', '', '420', '225', '0', '0', '3549427034', '1494075848', '1');
INSERT INTO `train_member` VALUES ('22', '886', '0', '0000-00-00', '', '20', '2', '0', '0', '3657746734', '1478947825', '1');
INSERT INTO `train_member` VALUES ('23', '887', '0', '0000-00-00', '', '30', '4', '0', '0', '1968357139', '1493710860', '1');
INSERT INTO `train_member` VALUES ('24', 'suzhou', '0', '0000-00-00', '', '20', '5', '0', '0', '3730730455', '1494396033', '1');

-- ----------------------------
-- Table structure for train_menu
-- ----------------------------
DROP TABLE IF EXISTS `train_menu`;
CREATE TABLE `train_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_menu
-- ----------------------------
INSERT INTO `train_menu` VALUES ('1', '首页', '0', '1', 'Index/index', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('2', '内容', '0', '2', 'Article/mydocument', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('3', '文档列表', '2', '0', 'article/index', '1', '', '内容', '0');
INSERT INTO `train_menu` VALUES ('4', '新增', '3', '0', 'article/add', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('5', '编辑', '3', '0', 'article/edit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('6', '改变状态', '3', '0', 'article/setStatus', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('7', '保存', '3', '0', 'article/update', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('8', '保存草稿', '3', '0', 'article/autoSave', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('9', '移动', '3', '0', 'article/move', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('10', '复制', '3', '0', 'article/copy', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('11', '粘贴', '3', '0', 'article/paste', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('12', '导入', '3', '0', 'article/batchOperate', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('13', '回收站', '2', '0', 'article/recycle', '1', '', '内容', '0');
INSERT INTO `train_menu` VALUES ('14', '还原', '13', '0', 'article/permit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('15', '清空', '13', '0', 'article/clear', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('16', '用户', '0', '3', 'User/index', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('17', '用户信息', '16', '0', 'User/index', '0', '', '用户管理', '0');
INSERT INTO `train_menu` VALUES ('18', '新增用户', '17', '0', 'User/add', '0', '添加新用户', '', '0');
INSERT INTO `train_menu` VALUES ('19', '用户行为', '16', '0', 'User/action', '0', '', '行为管理', '0');
INSERT INTO `train_menu` VALUES ('20', '新增用户行为', '19', '0', 'User/addaction', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('21', '编辑用户行为', '19', '0', 'User/editaction', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('22', '保存用户行为', '19', '0', 'User/saveAction', '0', '\"用户->用户行为\"保存编辑和新增的用户行为', '', '0');
INSERT INTO `train_menu` VALUES ('23', '变更行为状态', '19', '0', 'User/setStatus', '0', '\"用户->用户行为\"中的启用,禁用和删除权限', '', '0');
INSERT INTO `train_menu` VALUES ('24', '禁用会员', '19', '0', 'User/changeStatus?method=forbidUser', '0', '\"用户->用户信息\"中的禁用', '', '0');
INSERT INTO `train_menu` VALUES ('25', '启用会员', '19', '0', 'User/changeStatus?method=resumeUser', '0', '\"用户->用户信息\"中的启用', '', '0');
INSERT INTO `train_menu` VALUES ('26', '删除会员', '19', '0', 'User/changeStatus?method=deleteUser', '0', '\"用户->用户信息\"中的删除', '', '0');
INSERT INTO `train_menu` VALUES ('27', '权限管理', '16', '0', 'AuthManager/index', '0', '', '用户管理', '0');
INSERT INTO `train_menu` VALUES ('28', '删除', '27', '0', 'AuthManager/changeStatus?method=deleteGroup', '0', '删除用户组', '', '0');
INSERT INTO `train_menu` VALUES ('29', '禁用', '27', '0', 'AuthManager/changeStatus?method=forbidGroup', '0', '禁用用户组', '', '0');
INSERT INTO `train_menu` VALUES ('30', '恢复', '27', '0', 'AuthManager/changeStatus?method=resumeGroup', '0', '恢复已禁用的用户组', '', '0');
INSERT INTO `train_menu` VALUES ('31', '新增', '27', '0', 'AuthManager/createGroup', '0', '创建新的用户组', '', '0');
INSERT INTO `train_menu` VALUES ('32', '编辑', '27', '0', 'AuthManager/editGroup', '0', '编辑用户组名称和描述', '', '0');
INSERT INTO `train_menu` VALUES ('33', '保存用户组', '27', '0', 'AuthManager/writeGroup', '0', '新增和编辑用户组的\"保存\"按钮', '', '0');
INSERT INTO `train_menu` VALUES ('34', '授权', '27', '0', 'AuthManager/group', '0', '\"后台 \\ 用户 \\ 用户信息\"列表页的\"授权\"操作按钮,用于设置用户所属用户组', '', '0');
INSERT INTO `train_menu` VALUES ('35', '访问授权', '27', '0', 'AuthManager/access', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"访问授权\"操作按钮', '', '0');
INSERT INTO `train_menu` VALUES ('36', '成员授权', '27', '0', 'AuthManager/user', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"成员授权\"操作按钮', '', '0');
INSERT INTO `train_menu` VALUES ('37', '解除授权', '27', '0', 'AuthManager/removeFromGroup', '0', '\"成员授权\"列表页内的解除授权操作按钮', '', '0');
INSERT INTO `train_menu` VALUES ('38', '保存成员授权', '27', '0', 'AuthManager/addToGroup', '0', '\"用户信息\"列表页\"授权\"时的\"保存\"按钮和\"成员授权\"里右上角的\"添加\"按钮)', '', '0');
INSERT INTO `train_menu` VALUES ('39', '分类授权', '27', '0', 'AuthManager/category', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"分类授权\"操作按钮', '', '0');
INSERT INTO `train_menu` VALUES ('40', '保存分类授权', '27', '0', 'AuthManager/addToCategory', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0');
INSERT INTO `train_menu` VALUES ('41', '模型授权', '27', '0', 'AuthManager/modelauth', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"模型授权\"操作按钮', '', '0');
INSERT INTO `train_menu` VALUES ('42', '保存模型授权', '27', '0', 'AuthManager/addToModel', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0');
INSERT INTO `train_menu` VALUES ('43', '扩展', '0', '7', 'Addons/index', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('44', '插件管理', '43', '1', 'Addons/index', '0', '', '扩展', '0');
INSERT INTO `train_menu` VALUES ('45', '创建', '44', '0', 'Addons/create', '0', '服务器上创建插件结构向导', '', '0');
INSERT INTO `train_menu` VALUES ('46', '检测创建', '44', '0', 'Addons/checkForm', '0', '检测插件是否可以创建', '', '0');
INSERT INTO `train_menu` VALUES ('47', '预览', '44', '0', 'Addons/preview', '0', '预览插件定义类文件', '', '0');
INSERT INTO `train_menu` VALUES ('48', '快速生成插件', '44', '0', 'Addons/build', '0', '开始生成插件结构', '', '0');
INSERT INTO `train_menu` VALUES ('49', '设置', '44', '0', 'Addons/config', '0', '设置插件配置', '', '0');
INSERT INTO `train_menu` VALUES ('50', '禁用', '44', '0', 'Addons/disable', '0', '禁用插件', '', '0');
INSERT INTO `train_menu` VALUES ('51', '启用', '44', '0', 'Addons/enable', '0', '启用插件', '', '0');
INSERT INTO `train_menu` VALUES ('52', '安装', '44', '0', 'Addons/install', '0', '安装插件', '', '0');
INSERT INTO `train_menu` VALUES ('53', '卸载', '44', '0', 'Addons/uninstall', '0', '卸载插件', '', '0');
INSERT INTO `train_menu` VALUES ('54', '更新配置', '44', '0', 'Addons/saveconfig', '0', '更新插件配置处理', '', '0');
INSERT INTO `train_menu` VALUES ('55', '插件后台列表', '44', '0', 'Addons/adminList', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('56', 'URL方式访问插件', '44', '0', 'Addons/execute', '0', '控制是否有权限通过url访问插件控制器方法', '', '0');
INSERT INTO `train_menu` VALUES ('57', '钩子管理', '43', '2', 'Addons/hooks', '0', '', '扩展', '0');
INSERT INTO `train_menu` VALUES ('58', '模型管理', '68', '3', 'Model/index', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('59', '新增', '58', '0', 'model/add', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('60', '编辑', '58', '0', 'model/edit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('61', '改变状态', '58', '0', 'model/setStatus', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('62', '保存数据', '58', '0', 'model/update', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('63', '属性管理', '68', '0', 'Attribute/index', '1', '网站属性配置。', '', '0');
INSERT INTO `train_menu` VALUES ('64', '新增', '63', '0', 'Attribute/add', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('65', '编辑', '63', '0', 'Attribute/edit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('66', '改变状态', '63', '0', 'Attribute/setStatus', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('67', '保存数据', '63', '0', 'Attribute/update', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('68', '系统', '0', '4', 'Config/group', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('69', '网站设置', '68', '1', 'Config/group', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('70', '配置管理', '68', '4', 'Config/index', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('71', '编辑', '70', '0', 'Config/edit', '0', '新增编辑和保存配置', '', '0');
INSERT INTO `train_menu` VALUES ('72', '删除', '70', '0', 'Config/del', '0', '删除配置', '', '0');
INSERT INTO `train_menu` VALUES ('73', '新增', '70', '0', 'Config/add', '0', '新增配置', '', '0');
INSERT INTO `train_menu` VALUES ('74', '保存', '70', '0', 'Config/save', '0', '保存配置', '', '0');
INSERT INTO `train_menu` VALUES ('75', '菜单管理', '68', '5', 'Menu/index', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('76', '导航管理', '68', '6', 'Channel/index', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('77', '新增', '76', '0', 'Channel/add', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('78', '编辑', '76', '0', 'Channel/edit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('79', '删除', '76', '0', 'Channel/del', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('80', '分类管理', '68', '2', 'Category/index', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('81', '编辑', '80', '0', 'Category/edit', '0', '编辑和保存栏目分类', '', '0');
INSERT INTO `train_menu` VALUES ('82', '新增', '80', '0', 'Category/add', '0', '新增栏目分类', '', '0');
INSERT INTO `train_menu` VALUES ('83', '删除', '80', '0', 'Category/remove', '0', '删除栏目分类', '', '0');
INSERT INTO `train_menu` VALUES ('84', '移动', '80', '0', 'Category/operate/type/move', '0', '移动栏目分类', '', '0');
INSERT INTO `train_menu` VALUES ('85', '合并', '80', '0', 'Category/operate/type/merge', '0', '合并栏目分类', '', '0');
INSERT INTO `train_menu` VALUES ('86', '备份数据库', '68', '0', 'Database/index?type=export', '0', '', '数据备份', '0');
INSERT INTO `train_menu` VALUES ('87', '备份', '86', '0', 'Database/export', '0', '备份数据库', '', '0');
INSERT INTO `train_menu` VALUES ('88', '优化表', '86', '0', 'Database/optimize', '0', '优化数据表', '', '0');
INSERT INTO `train_menu` VALUES ('89', '修复表', '86', '0', 'Database/repair', '0', '修复数据表', '', '0');
INSERT INTO `train_menu` VALUES ('90', '还原数据库', '68', '0', 'Database/index?type=import', '0', '', '数据备份', '0');
INSERT INTO `train_menu` VALUES ('91', '恢复', '90', '0', 'Database/import', '0', '数据库恢复', '', '0');
INSERT INTO `train_menu` VALUES ('92', '删除', '90', '0', 'Database/del', '0', '删除备份文件', '', '0');
INSERT INTO `train_menu` VALUES ('93', '其他', '0', '5', 'other', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('96', '新增', '75', '0', 'Menu/add', '0', '', '系统设置', '0');
INSERT INTO `train_menu` VALUES ('98', '编辑', '75', '0', 'Menu/edit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('104', '下载管理', '102', '0', 'Think/lists?model=download', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('105', '配置管理', '102', '0', 'Think/lists?model=config', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('106', '行为日志', '16', '0', 'Action/actionlog', '0', '', '行为管理', '0');
INSERT INTO `train_menu` VALUES ('108', '修改密码', '16', '0', 'User/updatePassword', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('109', '修改昵称', '16', '0', 'User/updateNickname', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('110', '查看行为日志', '106', '0', 'action/edit', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('112', '新增数据', '58', '0', 'think/add', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('113', '编辑数据', '58', '0', 'think/edit', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('114', '导入', '75', '0', 'Menu/import', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('115', '生成', '58', '0', 'Model/generate', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('116', '新增钩子', '57', '0', 'Addons/addHook', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('117', '编辑钩子', '57', '0', 'Addons/edithook', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('118', '文档排序', '3', '0', 'Article/sort', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('119', '排序', '70', '0', 'Config/sort', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('120', '排序', '75', '0', 'Menu/sort', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('121', '排序', '76', '0', 'Channel/sort', '1', '', '', '0');
INSERT INTO `train_menu` VALUES ('122', '培训', '0', '2', 'Sport/order', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('123', '订单列表', '122', '0', 'Sport/order', '0', '', '订单管理', '0');
INSERT INTO `train_menu` VALUES ('124', '订单流水', '122', '0', 'Report/ticketReport', '0', '', '报表管理', '0');
INSERT INTO `train_menu` VALUES ('125', '编辑', '123', '0', 'Sport/orderEdit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('126', '删除', '123', '0', 'Sport/orderDelete', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('127', '日报表导出', '122', '0', 'Excel/everySales', '1', '', '报表管理', '0');
INSERT INTO `train_menu` VALUES ('128', '课程列表', '122', '0', 'Course/index', '0', '', '课程管理', '0');
INSERT INTO `train_menu` VALUES ('129', '编辑', '128', '0', 'Course/indexEdit', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('130', '添加', '128', '0', 'Course/indexAdd', '0', '', '', '0');
INSERT INTO `train_menu` VALUES ('131', '删除', '128', '0', 'Course/indexDel', '0', '', '', '0');

-- ----------------------------
-- Table structure for train_model
-- ----------------------------
DROP TABLE IF EXISTS `train_model`;
CREATE TABLE `train_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text NOT NULL COMMENT '属性列表（表的字段）',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text NOT NULL COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of train_model
-- ----------------------------
INSERT INTO `train_model` VALUES ('1', 'document', '基础文档', '0', '', '1', '{\"1\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', '1:基础', '', '', '', '', 'id:编号\r\ntitle:标题:article/index?cate_id=[category_id]&pid=[id]\r\ntype|get_document_type:类型\r\nlevel:优先级\r\nupdate_time|time_format:最后更新\r\nstatus_text:状态\r\nview:浏览\r\nid:操作:[EDIT]&cate_id=[category_id]|编辑,article/setstatus?status=-1&ids=[id]|删除', '0', '', '', '1383891233', '1384507827', '1', 'MyISAM');
INSERT INTO `train_model` VALUES ('2', 'article', '文章', '1', '', '1', '{\"1\":[\"3\",\"24\",\"2\",\"5\"],\"2\":[\"9\",\"13\",\"19\",\"10\",\"12\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', 'id:编号\r\ntitle:标题:article/edit?cate_id=[category_id]&id=[id]\r\ncontent:内容', '0', '', '', '1383891243', '1387260622', '1', 'MyISAM');
INSERT INTO `train_model` VALUES ('3', 'download', '下载', '1', '', '1', '{\"1\":[\"3\",\"28\",\"30\",\"32\",\"2\",\"5\",\"31\"],\"2\":[\"13\",\"10\",\"27\",\"9\",\"12\",\"16\",\"17\",\"19\",\"11\",\"20\",\"14\",\"29\"]}', '1:基础,2:扩展', '', '', '', '', 'id:编号\r\ntitle:标题', '0', '', '', '1383891252', '1387260449', '1', 'MyISAM');

-- ----------------------------
-- Table structure for train_order
-- ----------------------------
DROP TABLE IF EXISTS `train_order`;
CREATE TABLE `train_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '学生ID',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '课程ID',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '教练ID',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `reduceamount` int(11) NOT NULL DEFAULT '0' COMMENT '优惠金额',
  `realamount` int(11) NOT NULL DEFAULT '0' COMMENT '实付金额',
  `reducecode` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠码',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->首次，1->续班',
  `paytype` varchar(255) NOT NULL DEFAULT '' COMMENT '支付方式 1-微信 2-现金 3-阳光卡 4-工商银行',
  `paytime` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态：0->否，1->是，2->取消，3->退换课',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `isget` tinyint(1) NOT NULL DEFAULT '0' COMMENT '领取状态：0->否，1->是',
  `reson` varchar(200) DEFAULT NULL COMMENT '转课原因',
  `imbalance` int(11) DEFAULT NULL COMMENT '差价',
  `imstatus` tinyint(4) DEFAULT '0' COMMENT '1代表退款 2代表补交',
  `refundtime` int(11) DEFAULT NULL COMMENT '退款时间',
  `refundmoney` int(11) DEFAULT NULL COMMENT '退款金额',
  `refundnumber` int(11) DEFAULT NULL COMMENT '退款编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of train_order
-- ----------------------------
INSERT INTO `train_order` VALUES ('137', '2017051000', '75', '46', '0', '2040', '0', '2040', '', '0', '2', '1493706467', '1', '1493706467', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('138', '2017051001', '76', '1', '0', '1000', '0', '1000', '', '0', '2', '1493706629', '1', '1493706629', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('139', '2017051002', '77', '43', '0', '2040', '0', '2040', '', '0', '2', '1493706635', '3', '1493706635', '0', '', '0', '', null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('140', '2017051003', '78', '25', '0', '1540', '0', '1540', '', '0', '2', '1493706813', '3', '1493706813', '0', '', '0', '', null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('141', '2017051004', '79', '59', '0', '3080', '0', '3080', '', '0', '2', '1493706934', '1', '1493706934', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('142', '2017051005', '80', '70', '0', '1000', '0', '1000', '', '1', '2', '1493707020', '1', '1493707020', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('143', '2017051006', '78', '29', '0', '1540', '0', '1540', '', '0', '2', '1493707323', '1', '1493707323', '0', '', '1', null, '0', '0', null, null, null);
INSERT INTO `train_order` VALUES ('144', '2017051007', '81', '56', '0', '3080', '0', '3080', '', '0', '2', '1493707573', '1', '1493707573', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('145', '2017051008', '82', '1', '0', '1000', '0', '1000', '', '0', '2', '1493707696', '1', '1493707696', '0', '许新叶，徐浩冉，徐舒馨，许新卉', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('146', '2017051009', '83', '1', '0', '1000', '0', '1000', '', '0', '2', '1493707816', '1', '1493707816', '0', '许新叶，徐浩冉，徐舒馨，许新卉', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('147', '2017051010', '84', '1', '0', '1000', '0', '1000', '', '0', '2', '1493707883', '1', '1493707883', '0', '许新叶，徐浩冉，徐舒馨，许新卉', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('148', '2017051011', '85', '1', '0', '1000', '0', '1000', '', '0', '2', '1493707931', '1', '1493707931', '0', '许新叶，徐浩冉，徐舒馨，许新卉', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('149', '2017051012', '86', '15', '0', '1540', '0', '1540', '', '0', '2', '1493708044', '1', '1493708044', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('150', '2017051013', '87', '8', '0', '1000', '0', '1000', '', '0', '2', '1493708110', '1', '1493708110', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('151', '2017051014', '88', '8', '0', '1000', '0', '1000', '', '0', '2', '1493708218', '1', '1493708218', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('152', '2017051015', '89', '17', '0', '1540', '0', '1540', '', '0', '2', '1493708309', '1', '1493708309', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('153', '2017051016', '90', '44', '0', '2040', '0', '2040', '', '0', '2', '1493708444', '1', '1493708444', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('154', '2017051017', '91', '45', '0', '2040', '0', '2040', '', '0', '2', '1493708527', '1', '1493708527', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('155', '2017051018', '92', '44', '0', '2040', '0', '2040', '', '0', '2', '1493708617', '1', '1493708617', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('156', '2017051019', '93', '46', '0', '2040', '0', '2040', '', '0', '2', '1493708730', '1', '1493708730', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('157', '2017051020', '94', '19', '0', '1540', '0', '1540', '', '0', '2', '1493708845', '1', '1493708845', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('158', '2017051021', '77', '46', '0', '2040', '0', '2040', '', '0', '2', '1493708988', '1', '1493708988', '0', '', '1', null, '0', '0', null, null, null);
INSERT INTO `train_order` VALUES ('159', '2017051022', '95', '46', '0', '2040', '0', '2040', '', '0', '2', '1493709094', '1', '1493709094', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('160', '2017051023', '96', '72', '0', '1540', '0', '1540', '', '1', '2', '1493709431', '1', '1493709431', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('161', '2017051024', '97', '1', '0', '1000', '0', '1000', '', '0', '2', '1493709650', '1', '1493709650', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('162', '2017051025', '98', '139', '0', '2040', '0', '2040', '', '0', '2', '1493709739', '1', '1493709739', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('163', '2017051026', '99', '46', '0', '2040', '0', '2040', '', '0', '2', '1493710157', '1', '1493710157', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('164', '2017051027', '100', '46', '0', '2040', '0', '2040', '', '0', '2', '1493710390', '1', '1493710390', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('165', '2017051028', '101', '11', '0', '1000', '0', '1000', '', '0', '2', '1493710479', '1', '1493710479', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('166', '2017051029', '102', '45', '0', '2040', '0', '2040', '', '0', '2', '1493710583', '1', '1493710583', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('167', '2017051030', '103', '43', '0', '2040', '0', '2040', '', '0', '2', '1493710617', '1', '1493710617', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('168', '2017051031', '104', '46', '0', '2040', '0', '2040', '', '0', '2', '1493710672', '1', '1493710672', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('169', '2017051032', '105', '45', '0', '2040', '0', '2040', '', '0', '2', '1493710684', '1', '1493710684', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('170', '2017051033', '106', '13', '0', '1540', '0', '1540', '', '0', '2', '1493710840', '1', '1493710840', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('171', '2017051034', '107', '19', '0', '1540', '0', '1540', '', '0', '2', '1493710899', '1', '1493710899', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('172', '2017051035', '108', '7', '0', '1000', '0', '1000', '', '0', '2', '1493710914', '1', '1493710914', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('173', '2017051036', '109', '43', '0', '2040', '0', '2040', '', '0', '2', '1493710998', '1', '1493710998', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('174', '2017051037', '110', '1', '0', '1000', '0', '1000', '', '0', '2', '1493711039', '1', '1493711039', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('175', '2017051038', '111', '7', '0', '1000', '0', '1000', '', '0', '2', '1493711139', '1', '1493711139', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('176', '2017051039', '112', '45', '0', '2040', '0', '2040', '', '0', '2', '1493711170', '1', '1493711170', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('177', '2017051040', '113', '5', '0', '1000', '0', '1000', '', '0', '2', '1493711236', '1', '1493711236', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('178', '2017051041', '114', '2', '0', '1000', '0', '1000', '', '0', '2', '1493711341', '1', '1493711341', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('179', '2017051042', '115', '2', '0', '1000', '0', '1000', '', '0', '2', '1493711381', '1', '1493711381', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('180', '2017051043', '116', '13', '0', '1540', '0', '1540', '', '0', '2', '1493711417', '1', '1493711417', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('181', '2017051044', '117', '13', '0', '1540', '0', '1540', '', '0', '2', '1493711505', '1', '1493711505', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('182', '2017051045', '118', '46', '0', '2040', '0', '2040', '', '0', '2', '1493711524', '1', '1493711524', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('183', '2017051046', '119', '38', '0', '2040', '0', '2040', '', '0', '2', '1493711593', '1', '1493711593', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('184', '2017051047', '120', '31', '0', '1540', '0', '1540', '', '0', '2', '1493711675', '1', '1493711675', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('185', '2017051048', '121', '51', '0', '2040', '0', '2040', '', '0', '2', '1493711842', '1', '1493711842', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('186', '2017051049', '122', '13', '0', '1540', '0', '1540', '', '0', '2', '1493711920', '1', '1493711920', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('187', '2017051050', '123', '32', '0', '1540', '0', '1540', '', '0', '2', '1493711989', '1', '1493711989', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('188', '2017051051', '124', '5', '0', '1000', '0', '1000', '', '0', '2', '1493712067', '1', '1493712067', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('189', '2017051052', '125', '75', '0', '1540', '0', '1540', '', '1', '2', '1493712087', '1', '1493712087', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('190', '2017051053', '126', '75', '0', '1540', '0', '1540', '', '1', '2', '1493712164', '1', '1493712164', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('191', '2017051054', '127', '46', '0', '2040', '0', '2040', '', '0', '2', '1493712204', '1', '1493712204', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('192', '2017051055', '128', '44', '0', '2040', '0', '2040', '', '0', '2', '1493712262', '1', '1493712262', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('193', '2017051056', '129', '45', '0', '2040', '0', '2040', '', '0', '2', '1493712323', '1', '1493712323', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('194', '2017051057', '130', '43', '0', '2040', '0', '2040', '', '0', '2', '1493712325', '1', '1493712325', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('195', '2017051058', '131', '16', '0', '1540', '0', '1540', '', '0', '2', '1493712431', '1', '1493712431', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('196', '2017051059', '132', '15', '0', '1540', '0', '1540', '', '0', '2', '1493712557', '1', '1493712557', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('197', '2017051060', '133', '15', '0', '1540', '0', '1540', '', '0', '2', '1493712620', '1', '1493712620', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('198', '2017051061', '134', '15', '0', '1540', '0', '1540', '', '0', '2', '1493712719', '1', '1493712719', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('199', '2017051062', '135', '15', '0', '1540', '0', '1540', '', '0', '2', '1493712781', '1', '1493712781', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('200', '2017051063', '136', '2', '0', '1000', '0', '1000', '', '0', '2', '1493712805', '1', '1493712805', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('201', '2017051064', '137', '15', '0', '1540', '0', '1540', '', '0', '2', '1493712868', '1', '1493712868', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('202', '2017051065', '138', '2', '0', '1000', '0', '1000', '', '0', '2', '1493712949', '1', '1493712949', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('203', '2017051066', '139', '45', '0', '2040', '0', '2040', '', '0', '2', '1493713153', '1', '1493713153', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('204', '2017051067', '140', '17', '0', '1540', '0', '1540', '', '0', '2', '1493713248', '1', '1493713248', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('205', '2017051068', '141', '45', '0', '2040', '0', '2040', '', '0', '2', '1493713498', '1', '1493713498', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('206', '2017051069', '142', '16', '0', '1540', '0', '1540', '', '0', '2', '1493713542', '1', '1493713542', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('207', '2017051070', '143', '46', '0', '2040', '0', '2040', '', '0', '2', '1493713583', '1', '1493713583', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('208', '2017051071', '144', '14', '0', '1540', '0', '1540', '', '0', '2', '1493713618', '1', '1493713618', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('209', '2017051072', '145', '45', '0', '2040', '0', '2040', '', '0', '2', '1493713701', '1', '1493713701', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('210', '2017051073', '146', '46', '0', '2040', '0', '2040', '', '0', '2', '1493713716', '1', '1493713716', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('211', '2017051074', '147', '45', '0', '2040', '0', '2040', '', '0', '2', '1493713951', '1', '1493713951', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('212', '2017051075', '148', '8', '0', '1000', '0', '1000', '', '0', '2', '1493713954', '1', '1493713954', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('213', '2017051076', '149', '40', '0', '2040', '0', '2040', '', '0', '2', '1493776153', '1', '1493776153', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('216', '2017051077', '152', '14', '0', '1540', '0', '1540', '', '0', '3', '1493788436', '1', '1493788436', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('217', '2017055553', '153', '1', '0', '1000', '0', '1000', '', '0', '0', '0', '0', '1493801094', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('218', '2017059059', '154', '67', '0', '1000', '0', '1000', '', '0', '0', '0', '0', '1493801798', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('219', '2017051078', '155', '45', '0', '2040', '0', '2040', '', '0', '4', '1493807463', '1', '1493807463', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('220', '2017057778', '156', '45', '0', '2040', '0', '2040', '', '0', '1', '1493868476', '1', '1493868452', '0', '初学', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('221', '2017059642', '157', '46', '0', '2040', '0', '2040', '', '0', '1', '1493870841', '1', '1493870805', '0', '初学', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('222', '2017051507', '158', '62', '0', '3680', '0', '3680', '', '0', '', '0', '0', '1493888948', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('223', '2017052227', '159', '38', '0', '2040', '0', '2040', '', '0', '', '0', '0', '1493906897', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('224', '2017055512', '159', '38', '0', '2040', '0', '2040', '', '0', '', '0', '0', '1493949541', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('225', '2017051079', '159', '38', '0', '2040', '0', '2040', '', '0', '4', '1493953283', '1', '1493953283', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('226', '2017051080', '160', '13', '0', '1540', '0', '1540', '', '0', '4', '1493955090', '1', '1493955090', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('227', '2017057797', '161', '70', '0', '1000', '0', '1000', '', '0', '', '0', '0', '1493967497', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('228', '2017051081', '162', '19', '0', '1540', '0', '1540', '', '0', '2', '1493990049', '1', '1493990049', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('229', '2017051082', '163', '2', '0', '1000', '0', '1000', '', '0', '2', '1494045525', '1', '1494045525', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('230', '2017051083', '164', '5', '0', '1000', '0', '1000', '', '0', '4', '1494049365', '1', '1494049365', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('231', '2017051084', '165', '23', '0', '1540', '0', '1540', '', '0', '4', '1494054285', '1', '1494054285', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('232', '2017051085', '166', '46', '0', '2040', '0', '2040', '', '0', '4', '1494060538', '1', '1494060538', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('233', '2017051086', '167', '29', '0', '1540', '0', '1540', '', '0', '4', '1494070143', '1', '1494070143', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('234', '2017051087', '168', '46', '0', '2040', '0', '2040', '', '0', '4', '1494130594', '1', '1494130594', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('235', '2017051088', '169', '138', '0', '2040', '0', '2040', '', '0', '4', '1494137296', '1', '1494137296', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('236', '2017051089', '170', '54', '0', '2040', '0', '2040', '', '0', '4', '1494143139', '1', '1494143139', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('237', '2017051090', '171', '45', '0', '2040', '0', '2040', '', '0', '4', '1494144576', '1', '1494144576', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('238', '2017051091', '172', '45', '0', '2040', '0', '2040', '', '0', '4', '1494146854', '1', '1494146854', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('239', '2017051092', '173', '45', '0', '2040', '0', '2040', '', '0', '4', '1494148378', '1', '1494148378', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('240', '2017052325', '174', '73', '0', '1540', '0', '1540', '', '0', '', '0', '0', '1494200909', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('241', '2017051093', '175', '2', '0', '1000', '0', '1000', '', '0', '2', '1494203182', '1', '1494203182', '0', '', '1', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('242', '2017050084', '176', '70', '0', '1000', '0', '1000', '', '0', '', '0', '0', '1494203709', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('243', '2017055226', '177', '69', '0', '1000', '0', '1000', '', '0', '', '0', '0', '1494245339', '0', '初学', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('244', '2017051094', '178', '26', '0', '1540', '0', '1540', '', '0', '2', '1494294091', '1', '1494294091', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('245', '2017051095', '179', '38', '0', '2040', '0', '2040', '', '0', '3', '1494304707', '1', '1494304707', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('246', '2017051096', '180', '35', '0', '1540', '0', '1540', '', '0', '4', '1494304829', '1', '1494304829', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('248', '2017051097', '182', '52', '0', '2040', '0', '2040', '', '0', '4', '1494330218', '1', '1494330218', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('249', '2017051098', '183', '46', '0', '2040', '0', '2040', '', '0', '4', '1494337179', '1', '1494337179', '0', '', '0', null, null, '0', null, null, null);
INSERT INTO `train_order` VALUES ('250', '2017051099', '184', '43', '0', '2040', '0', '2040', '', '0', '2', '1494384137', '1', '1494384137', '0', '', '1', null, null, '0', null, null, null);

-- ----------------------------
-- Table structure for train_picture
-- ----------------------------
DROP TABLE IF EXISTS `train_picture`;
CREATE TABLE `train_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_picture
-- ----------------------------

-- ----------------------------
-- Table structure for train_reduce
-- ----------------------------
DROP TABLE IF EXISTS `train_reduce`;
CREATE TABLE `train_reduce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL COMMENT '优惠码',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '所属用户姓名',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系方式',
  `startdate` int(255) NOT NULL DEFAULT '0' COMMENT '有效期开始时间',
  `enddate` int(255) NOT NULL DEFAULT '0' COMMENT '有效期截止时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0->正常,1->禁用',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0->否，1->是',
  `addtime` int(1) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `reduce` int(11) NOT NULL DEFAULT '0' COMMENT '优惠金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_reduce
-- ----------------------------

-- ----------------------------
-- Table structure for train_schedule
-- ----------------------------
DROP TABLE IF EXISTS `train_schedule`;
CREATE TABLE `train_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '场馆ID',
  `classtype` varchar(255) NOT NULL DEFAULT '' COMMENT '课程类型（暑期班、平时班）',
  `sportid` int(11) NOT NULL DEFAULT '0' COMMENT '运动类型ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '课程名称',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '教练ID',
  `cname` varchar(255) NOT NULL DEFAULT '' COMMENT '教练姓名',
  `startdate` varchar(255) NOT NULL DEFAULT '' COMMENT '开始日期',
  `enddate` varchar(255) NOT NULL DEFAULT '' COMMENT '结束日期',
  `weekinfo` varchar(255) NOT NULL DEFAULT '' COMMENT '上课周期（周一、三、五）',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '学费',
  `amount_follow` int(11) NOT NULL DEFAULT '0' COMMENT '续班价格',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->首次，1->续班',
  `nums` int(11) NOT NULL DEFAULT '0' COMMENT '课次',
  `hours` int(11) NOT NULL DEFAULT '0' COMMENT '课时',
  `hour_s` varchar(255) NOT NULL DEFAULT '' COMMENT '培训开始时间段',
  `hour_e` varchar(255) NOT NULL DEFAULT '' COMMENT '培训结束时间段',
  `num_min` int(11) NOT NULL DEFAULT '0' COMMENT '每班最少人数',
  `num_max` int(11) NOT NULL DEFAULT '0' COMMENT '每班最多人数',
  `reserve` int(11) NOT NULL DEFAULT '0' COMMENT '预留人数',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '授课内容',
  `students` varchar(255) NOT NULL DEFAULT '' COMMENT '招生对象',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '报名须知',
  `classnum` int(11) NOT NULL DEFAULT '1' COMMENT '班级数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COMMENT='培训课程表';

-- ----------------------------
-- Records of train_schedule
-- ----------------------------
INSERT INTO `train_schedule` VALUES ('1', '1', '七月', '1', '少儿启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1000', '0', '0', '12', '1', '08:30', '09:30', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('2', '1', '七月', '1', '少儿启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1000', '0', '0', '12', '1', '10:00', '11:00', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('4', '1', '七月', '1', '少儿启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1000', '0', '0', '12', '1', '08:30', '09:30', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('5', '1', '七月', '1', '少儿启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1000', '0', '0', '12', '1', '10:00', '11:00', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('7', '1', '七月', '1', '少儿提高班', '0', '', '2017.07.05', '', '周一、三、五', '1000', '0', '0', '12', '1', '08:30', '09:30', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '2');
INSERT INTO `train_schedule` VALUES ('8', '1', '七月', '1', '少儿提高班', '0', '', '2017.07.05', '', '周一、三、五', '1000', '0', '0', '12', '1', '10:00', '11:00', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '2');
INSERT INTO `train_schedule` VALUES ('10', '1', '七月', '1', '少儿提高班', '0', '', '2017.07.06', '', '周二、四、六', '1000', '0', '0', '12', '1', '08:30', '09:30', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '2');
INSERT INTO `train_schedule` VALUES ('11', '1', '七月', '1', '少儿提高班', '0', '', '2017.07.06', '', '周二、四、六', '1000', '0', '0', '12', '1', '10:00', '11:00', '8', '10', '4', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '2');
INSERT INTO `train_schedule` VALUES ('13', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('14', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('15', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('16', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('17', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('19', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('20', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('21', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('22', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('23', '1', '七月', '1', '贵宾启蒙班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('25', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('26', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('27', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('28', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('29', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.05', '', '周一、三、五', '1540', '0', '0', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('31', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('32', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('33', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('34', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('35', '1', '七月', '1', '贵宾提高班', '0', '', '2017.07.06', '', '周二、四、六', '1540', '0', '0', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('37', '1', '七月', '1', '中考初级班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '08:30', '09:30', '10', '12', '4', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('38', '1', '七月', '1', '中考初级班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '10:00', '11:00', '10', '12', '4', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('39', '1', '七月', '1', '中考初级班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '18:00', '19:00', '10', '12', '4', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('40', '1', '七月', '1', '中考初级班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '19:30', '20:30', '10', '12', '4', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('43', '1', '七月', '1', '中考冲刺班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '08:30', '09:30', '10', '12', '4', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('44', '1', '七月', '1', '中考冲刺班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '10:00', '11:00', '10', '12', '4', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('45', '1', '七月', '1', '中考冲刺班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '18:00', '19:00', '10', '12', '4', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('46', '1', '七月', '1', '中考冲刺班', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '19:30', '20:30', '10', '12', '4', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元', '2');
INSERT INTO `train_schedule` VALUES ('51', '1', '七月', '1', '一对三', '0', '', '2017.07.05', '', '周一、三、五', '2040', '0', '0', '12', '1', '18:00', '19:00', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('52', '1', '七月', '1', '一对三', '0', '', '2017.07.05', '', '周一、三、五', '2040', '0', '0', '12', '1', '19:30', '20:30', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('53', '1', '七月', '1', '一对三', '0', '', '2017.07.06', '', '周二、四、六', '2040', '0', '0', '12', '1', '18:00', '19:00', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('54', '1', '七月', '1', '一对三', '0', '', '2017.07.06', '', '周二、四、六', '2040', '0', '0', '12', '1', '19:30', '20:30', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('55', '1', '七月', '1', '亲子A班', '0', '', '2017.07.05', '', '周一、三、五', '3080', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('56', '1', '七月', '1', '亲子A班', '0', '', '2017.07.05', '', '周一、三、五', '3080', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('58', '1', '七月', '1', '亲子A班', '0', '', '2017.07.06', '', '周二、四、六', '3080', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('59', '1', '七月', '1', '亲子A班', '0', '', '2017.07.06', '', '周二、四、六', '3080', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('61', '1', '七月', '1', '亲子B班', '0', '', '2017.07.05', '', '周一、三、五', '3680', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('62', '1', '七月', '1', '亲子B班', '0', '', '2017.07.05', '', '周一、三、五', '3680', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('64', '1', '七月', '1', '亲子B班', '0', '', '2017.07.06', '', '周二、四、六', '3680', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('65', '1', '七月', '1', '亲子B班', '0', '', '2017.07.06', '', '周二、四、六', '3680', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '2');
INSERT INTO `train_schedule` VALUES ('67', '1', '八月', '1', '少儿启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1000', '800', '1', '12', '1', '08:30', '09:30', '8', '10', '2', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('68', '1', '八月', '1', '少儿启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1000', '800', '1', '12', '1', '10:00', '11:00', '8', '10', '2', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('69', '1', '八月', '1', '少儿提高班', '0', '', '2017.08.04', '', '周一至周六', '1000', '800', '1', '12', '1', '08:30', '09:30', '8', '10', '0', '自由泳', '7月老生班或有游泳基础', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('70', '1', '八月', '1', '少儿提高班', '0', '', '2017.08.04', '', '周一至周六', '1000', '800', '1', '12', '1', '10:00', '11:00', '8', '10', '0', '自由泳', '7月老生班或有游泳基础', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('71', '1', '八月', '1', '贵宾启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('72', '1', '八月', '1', '贵宾启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('73', '1', '八月', '1', '贵宾启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('74', '1', '八月', '1', '贵宾启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('75', '1', '八月', '1', '贵宾启蒙班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '3');
INSERT INTO `train_schedule` VALUES ('77', '1', '八月', '1', '贵宾提高班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '08:30', '09:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，提高班能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('78', '1', '八月', '1', '贵宾提高班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '10:00', '11:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，提高班能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('79', '1', '八月', '1', '贵宾提高班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '13:00', '14:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，提高班能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('80', '1', '八月', '1', '贵宾提高班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '14:30', '15:30', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，提高班能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('81', '1', '八月', '1', '贵宾提高班', '0', '', '2017.08.04', '', '周一至周六', '1540', '1340', '1', '12', '1', '16:00', '17:00', '5', '5', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，提高班能独自游10米', '3');
INSERT INTO `train_schedule` VALUES ('86', '1', '八月', '1', '一对三', '0', '', '2017.08.04', '', '周一至周六', '2040', '0', '0', '12', '1', '18:00', '19:00', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('87', '1', '八月', '1', '一对三', '0', '', '2017.08.04', '', '周一至周六', '2040', '0', '0', '12', '1', '19:30', '20:30', '3', '3', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元', '8');
INSERT INTO `train_schedule` VALUES ('89', '1', '八月', '1', '亲子A班', '0', '', '2017.08.04', '', '周一至周六', '3080', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '3');
INSERT INTO `train_schedule` VALUES ('90', '1', '八月', '1', '亲子A班', '0', '', '2017.08.04', '', '周一至周六', '3080', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲或母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">一大一小为一个名额</lable>', '3');
INSERT INTO `train_schedule` VALUES ('92', '1', '八月', '1', '亲子B班', '0', '', '2017.08.04', '', '周一至周六', '3680', '0', '0', '12', '1', '18:00', '19:00', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '3');
INSERT INTO `train_schedule` VALUES ('93', '1', '八月', '1', '亲子B班', '0', '', '2017.08.04', '', '周一至周六', '3680', '0', '0', '12', '1', '19:30', '20:30', '1', '1', '0', '自由泳', '直系父亲和母亲带1米以上小孩', '0', '0', '亲子班费用为总价，凭户口簿报名，<br/><lable style=\"font-weight:bold;color:#27B25F\">两大一小为一个名额</lable>', '3');
INSERT INTO `train_schedule` VALUES ('95', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '1840', '0', '0', '12', '1', '08:30', '09:30', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('96', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '1840', '0', '0', '12', '1', '10:00', '11:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('97', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '1840', '0', '0', '12', '1', '13:00', '14:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('98', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '1840', '0', '0', '12', '1', '14:30', '15:30', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('99', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '1840', '0', '0', '12', '1', '16:00', '17:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('101', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '3040', '0', '0', '12', '1', '08:30', '09:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('102', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '3040', '0', '0', '12', '1', '10:00', '11:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('103', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '3040', '0', '0', '12', '1', '13:00', '14:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('104', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '3040', '0', '0', '12', '1', '14:30', '15:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('105', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '3040', '0', '0', '12', '1', '16:00', '17:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('107', '2', '八月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '1840', '0', '0', '12', '1', '08:30', '09:30', '2', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('108', '2', '八月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '1840', '0', '0', '12', '1', '10:00', '11:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('109', '2', '八月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '1840', '0', '0', '12', '1', '13:00', '14:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('110', '2', '八月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '1840', '0', '0', '12', '1', '14:30', '15:30', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('111', '2', '八月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '1840', '0', '0', '12', '1', '16:00', '17:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('112', '2', '八月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '3040', '0', '0', '12', '1', '08:30', '09:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('113', '2', '八月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '3040', '0', '0', '12', '1', '10:00', '11:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('114', '2', '八月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '3040', '0', '0', '12', '1', '13:00', '14:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('115', '2', '八月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '3040', '0', '0', '12', '1', '14:30', '15:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('116', '2', '八月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.08.04', '', '周一至周六', '3040', '0', '0', '12', '1', '16:00', '17:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('123', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '3040', '0', '0', '12', '1', '08:30', '09:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('124', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '3040', '0', '0', '12', '1', '10:00', '11:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('125', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '3040', '0', '0', '12', '1', '13:00', '14:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('126', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '3040', '0', '0', '12', '1', '14:30', '15:30', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('127', '2', '七月', '1', '一对一锦帆路室外游泳馆', '0', '', '2017.07.05', '', '周一、三、五', '3040', '0', '0', '12', '1', '16:00', '17:00', '1', '1', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('128', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '1840', '0', '0', '12', '1', '08:30', '09:30', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('129', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '1840', '0', '0', '12', '1', '10:00', '11:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('130', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '1840', '0', '0', '12', '1', '13:00', '14:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('131', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '1840', '0', '0', '12', '1', '14:30', '15:30', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('132', '2', '七月', '1', '一对二锦帆路室外游泳馆', '0', '', '2017.07.06', '', '周二、四、六', '1840', '0', '0', '12', '1', '16:00', '17:00', '2', '2', '0', '自由泳', '2010年12月前出生，身高1.2米', '0', '0', '含材料费40元，室外泳池', '3');
INSERT INTO `train_schedule` VALUES ('133', '2', '七月', '1', '中考初级班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '13:00', '14:00', '10', '12', '0', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元，室外泳池', '2');
INSERT INTO `train_schedule` VALUES ('134', '2', '七月', '1', '中考初级班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '14:30', '15:30', '10', '12', '0', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元，室外泳池', '2');
INSERT INTO `train_schedule` VALUES ('135', '2', '七月', '1', '中考初级班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '16:00', '17:00', '10', '12', '0', '自由泳', '应届游泳中考生（初一）', '0', '0', '含材料费40元，室外泳池', '2');
INSERT INTO `train_schedule` VALUES ('137', '2', '七月', '1', '中考冲刺班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '13:00', '14:00', '10', '12', '0', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元，室外泳池', '2');
INSERT INTO `train_schedule` VALUES ('138', '2', '七月', '1', '中考冲刺班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '14:30', '15:30', '10', '12', '0', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元，室外泳池', '2');
INSERT INTO `train_schedule` VALUES ('139', '2', '七月', '1', '中考冲刺班锦帆路室外游泳馆', '0', '', '2017.07.01', '', '每天', '2040', '0', '0', '25', '1', '16:00', '17:00', '10', '12', '0', '自由泳', '应届游泳中考生（初二）', '0', '0', '含材料费40元，室外泳池', '2');

-- ----------------------------
-- Table structure for train_sport
-- ----------------------------
DROP TABLE IF EXISTS `train_sport`;
CREATE TABLE `train_sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '运动名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='运动类型表';

-- ----------------------------
-- Records of train_sport
-- ----------------------------
INSERT INTO `train_sport` VALUES ('1', '游泳', 'youyong');

-- ----------------------------
-- Table structure for train_student
-- ----------------------------
DROP TABLE IF EXISTS `train_student`;
CREATE TABLE `train_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户openid',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `headimg` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '学号',
  `cardnum` varchar(255) NOT NULL DEFAULT '' COMMENT '卡号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '学生姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0->男，1->女',
  `birthinfo` varchar(255) NOT NULL DEFAULT '' COMMENT '出生年月',
  `age` int(11) NOT NULL DEFAULT '0' COMMENT '年龄',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `addtime` int(255) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `isdel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `idcard` varchar(50) DEFAULT NULL COMMENT '身份证号',
  `school` varchar(255) DEFAULT NULL COMMENT '学校名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COMMENT='学生表';

-- ----------------------------
-- Records of train_student
-- ----------------------------
INSERT INTO `train_student` VALUES ('75', '', '', '', '201705021427475692', '05020309', '周妍', '1', '2003-5', '0', '13812670907', '1493706467', '0', '', '320501200305265267', '园区一中');
INSERT INTO `train_student` VALUES ('76', '', '', '', '201705021430299681', '05023485', '董哲皓', '0', '2008-12', '0', '13776007190', '1493706629', '0', '', '320502200812251771', '苏州沧浪实验小学');
INSERT INTO `train_student` VALUES ('77', '', '', '', '201705021430356874', '05028454', '祝瑜斌', '0', '2003-8', '0', '13372177887', '1493706635', '0', '', '', '苏州中学');
INSERT INTO `train_student` VALUES ('78', '', '', '', '201705021433338163', '05024201', '钱婧琦', '1', '2006-10', '0', '18913131616', '1493706813', '0', '', '', '苏州市实验小学');
INSERT INTO `train_student` VALUES ('79', '', '', '', '201705021435346120', '05027743', '刘溪萸', '1', '2009-3', '0', '13771753724', '1493706934', '0', '', '', '敬文小学');
INSERT INTO `train_student` VALUES ('80', '', '', '', '201705021437004059', '05026702', '赵星辉', '0', '2005-11', '0', '18013101481', '1493707020', '0', '', '', '');
INSERT INTO `train_student` VALUES ('81', '', '', '', '201705021446132994', '05021795', '庞雪芹/穆鹏达', '0', '2010-1', '0', '15862436543', '1493707573', '0', '', '', '');
INSERT INTO `train_student` VALUES ('82', '', '', '', '201705021448165779', '05026688', '许新叶', '0', '2009-2', '0', '13584894545', '1493707696', '0', '', '', '平江实验学校');
INSERT INTO `train_student` VALUES ('83', '', '', '', '201705021450168288', '05024774', '徐浩冉', '0', '2010-3', '0', '18994318252', '1493707816', '0', '', '', '崇道小学');
INSERT INTO `train_student` VALUES ('84', '', '', '', '201705021451235107', '05028780', '徐舒馨', '0', '2006-4', '0', '18994318252', '1493707883', '0', '', '', '崇道小学');
INSERT INTO `train_student` VALUES ('85', '', '', '', '201705021452115561', '05022951', '许新卉', '1', '2010-3', '0', '13584894545', '1493707931', '0', '', '', '崇道小学');
INSERT INTO `train_student` VALUES ('86', '', '', '', '201705021454047534', '05022166', '吴定宜', '1', '2007-9', '0', '18014000871', '1493708044', '0', '', '', '');
INSERT INTO `train_student` VALUES ('87', '', '', '', '201705021455109558', '05023068', '周晔枫', '0', '2009-4', '0', '13962117386', '1493708110', '0', '', '', '');
INSERT INTO `train_student` VALUES ('88', '', '', '', '201705021456583164', '05027973', '严俊辉', '0', '2007-9', '0', '13915511686', '1493708218', '0', '', '', '平直小学');
INSERT INTO `train_student` VALUES ('89', '', '', '', '201705021458295393', '05029244', '顾皓', '0', '2009-12', '0', '18963667569', '1493708309', '0', '', '320502200912021754', '沧浪实验小学');
INSERT INTO `train_student` VALUES ('90', '', '', '', '201705021500445331', '05026560', '白雯琪', '1', '2003-4', '0', '18962145547', '1493708444', '0', '', '320507200304254044', '胥江中学');
INSERT INTO `train_student` VALUES ('91', '', '', '', '201705021502071095', '05022652', '衡怡杰', '1', '2003-7', '0', '18962120205', '1493708527', '0', '', '', '');
INSERT INTO `train_student` VALUES ('92', '', '', '', '201705021503375161', '05020639', '陈昊洋', '0', '2003-6', '0', '13862407832', '1493708617', '0', '', '', '');
INSERT INTO `train_student` VALUES ('93', '', '', '', '201705021505304276', '05025653', '耿龚承', '0', '2003-1', '0', '13771827510', '1493708730', '0', '', '', '');
INSERT INTO `train_student` VALUES ('94', '', '', '', '201705021507252328', '05029072', '朱顾颖', '0', '2007-6', '0', '13814804830', '1493708845', '0', '', '', '');
INSERT INTO `train_student` VALUES ('95', '', '', '', '201705021511345763', '05026786', '胡孝斐', '0', '2004-6', '0', '13862084938', '1493709094', '0', '', '', '');
INSERT INTO `train_student` VALUES ('96', '', '', '', '201705021517116678', '05029136', '李韫尧', '0', '2007-10', '0', '13862421582', '1493709431', '0', '', '', '');
INSERT INTO `train_student` VALUES ('97', '', '', '', '201705021520504283', '05021607', '陆天祥', '0', '2009-12', '0', '15962182151', '1493709650', '0', '', '23125020091220221x', '工业园区星港学校');
INSERT INTO `train_student` VALUES ('98', '', '', '', '201705021522193695', '05029554', '寿文逸', '0', '2003-5', '0', '13962154286', '1493709739', '0', '', '', '振华中学');
INSERT INTO `train_student` VALUES ('99', '', '', '', '201705021529161860', '05027485', '李涵君', '0', '2003-5', '0', '13913571339', '1493710156', '0', '', '', '振华中学');
INSERT INTO `train_student` VALUES ('100', '', '', '', '201705021533107828', '05024113', '王恺', '0', '2003-7', '0', '18862110074', '1493710390', '0', '', '', '第十六中学');
INSERT INTO `train_student` VALUES ('101', '', '', '', '201705021534393119', '05020345', '殷梓闻', '0', '2008-2', '0', '18626280836', '1493710479', '0', '', '', '');
INSERT INTO `train_student` VALUES ('102', '', '', '', '201705021536239396', '05026406', '姜苏', '0', '2002-12', '0', '13506207766', '1493710583', '0', '', '', '立达胥江');
INSERT INTO `train_student` VALUES ('103', '', '', '', '201705021536576979', '05023010', '李云飞', '0', '2002-11', '0', '15162409665', '1493710617', '0', '', '', '');
INSERT INTO `train_student` VALUES ('104', '', '', '', '201705021537528945', '05021995', '杨约', '0', '2003-3', '0', '13912603690', '1493710672', '0', '', '', '振华');
INSERT INTO `train_student` VALUES ('105', '', '', '', '201705021538043610', '05028371', '缪芸琦', '0', '2004-2', '0', '13584879204', '1493710684', '0', '', '', '一中');
INSERT INTO `train_student` VALUES ('106', '', '', '', '201705021540408413', '05025265', '王凛芳', '1', '2010-8', '0', '13584860956', '1493710840', '0', '', '', '星港小学');
INSERT INTO `train_student` VALUES ('107', '', '', '', '201705021541390805', '05028517', '张歆怿', '0', '2009-11', '0', '18101546362', '1493710899', '0', '', '', '苏州工业园区星港学校');
INSERT INTO `train_student` VALUES ('108', '', '', '', '201705021541548940', '05023434', '吴越舟', '0', '2006-3', '0', '13862155595', '1493710914', '0', '', '', '');
INSERT INTO `train_student` VALUES ('109', '', '', '', '201705021543183689', '05022342', '罗玉晗', '1', '2003-2', '0', '15895579683', '1493710998', '0', '', '', '振华');
INSERT INTO `train_student` VALUES ('110', '', '', '', '201705021543592626', '05023349', '张轩顾', '0', '2008-5', '0', '15365307296', '1493711039', '0', '', '', '带城实验小学');
INSERT INTO `train_student` VALUES ('111', '', '', '', '201705021545397927', '05027707', '孔天雨', '0', '2006-7', '0', '18962153308', '1493711139', '0', '', '', '');
INSERT INTO `train_student` VALUES ('112', '', '', '', '201705021546101259', '05028810', '汪璟祺', '0', '2002-12', '0', '13771982653', '1493711170', '0', '', '', '');
INSERT INTO `train_student` VALUES ('113', '', '', '', '201705021547163722', '05028436', '刘元浩', '0', '2008-5', '0', '13913541754', '1493711236', '0', '', '', '带城实验小学');
INSERT INTO `train_student` VALUES ('114', '', '', '', '201705021549017031', '05025657', '相涵清', '0', '2010-2', '0', '15051443116', '1493711341', '0', '', '320504201002174011', '金阊外国语');
INSERT INTO `train_student` VALUES ('115', '', '', '', '201705021549419261', '05024307', '吴佳', '1', '2006-7', '0', '18115685391', '1493711381', '0', '', '', '阳光城实验小学');
INSERT INTO `train_student` VALUES ('116', '', '', '', '201705021550179090', '05025433', '顾晟翌', '0', '2010-12', '0', '13862141488', '1493711417', '0', '', '', '');
INSERT INTO `train_student` VALUES ('117', '', '', '', '201705021551453318', '05020107', '曹瀚天', '0', '2010-4', '0', '13912617426', '1493711505', '0', '', '', '沧浪实验小学');
INSERT INTO `train_student` VALUES ('118', '', '', '', '201705021552047479', '05028945', '吴昱韬', '0', '2003-2', '0', '13812647066', '1493711524', '0', '', '', '平江中学');
INSERT INTO `train_student` VALUES ('119', '', '', '', '201705021553134780', '05025800', '尤思嘉', '1', '2003-1', '0', '13912638026', '1493711593', '0', '', '320503200301013528', '振华');
INSERT INTO `train_student` VALUES ('120', '', '', '', '201705021554356883', '05020581', '董亦悦', '1', '2004-11', '0', '13862079072', '1493711675', '0', '', '', '沧浪实验小学');
INSERT INTO `train_student` VALUES ('121', '', '', '', '201705021557222895', '05024912', '马晟瑜', '1', '2003-10', '0', '13291179577', '1493711842', '0', '', '', '草桥');
INSERT INTO `train_student` VALUES ('122', '', '', '', '201705021558401582', '05025665', '祝一骐', '0', '2008-11', '0', '18913171107', '1493711920', '0', '', '', '');
INSERT INTO `train_student` VALUES ('123', '', '', '', '201705021559498005', '05024072', '徐子轩', '0', '2006-6', '0', '13912636832', '1493711989', '0', '', '', '平直');
INSERT INTO `train_student` VALUES ('124', '', '', '', '201705021601072630', '05025610', '徐子豪', '0', '2008-9', '0', '13912636832', '1493712067', '0', '', '', '平直');
INSERT INTO `train_student` VALUES ('125', '', '', '', '201705021601271256', '05022009', '罗然', '0', '2010-1', '0', '18006233633', '1493712087', '0', '', '', '善耕实验学校');
INSERT INTO `train_student` VALUES ('126', '', '', '', '201705021602441200', '05021266', '乐霏帆', '0', '2009-6', '0', '13584836839', '1493712164', '0', '', '', '善耕实验小学');
INSERT INTO `train_student` VALUES ('127', '', '', '', '201705021603244665', '05024667', '段雨晴', '1', '2003-4', '0', '15106216826', '1493712204', '0', '', '', '平江');
INSERT INTO `train_student` VALUES ('128', '', '', '', '201705021604226536', '05022937', '包诚宇', '0', '2003-3', '0', '15995791589', '1493712262', '0', '', '', '星港');
INSERT INTO `train_student` VALUES ('129', '', '', '', '201705021605239889', '05029723', '冯泰翔', '0', '2003-11', '0', '13962183270', '1493712323', '0', '', '320502200311261250', '第十中学');
INSERT INTO `train_student` VALUES ('130', '', '', '', '201705021605255235', '05026048', '周佳晨', '1', '2003-2', '0', '13861317321', '1493712325', '0', '', '', '高新区实验中学');
INSERT INTO `train_student` VALUES ('131', '', '', '', '201705021607114851', '05028816', '陈景轩', '0', '2009-9', '0', '15599011286', '1493712431', '0', '', '', '平直小学');
INSERT INTO `train_student` VALUES ('132', '', '', '', '201705021609175832', '05026057', '吴钰瑾', '1', '2008-12', '0', '13912797789', '1493712557', '0', '', '', '');
INSERT INTO `train_student` VALUES ('133', '', '', '', '201705021610194891', '05025226', '王苏缘', '1', '2009-8', '0', '13814804254', '1493712619', '0', '', '', '');
INSERT INTO `train_student` VALUES ('134', '', '', '', '201705021611591681', '05021860', '王业枫', '0', '2008-11', '0', '13656218068', '1493712719', '0', '', '', '');
INSERT INTO `train_student` VALUES ('135', '', '', '', '201705021613012468', '05022868', '夷睿希', '0', '2010-1', '0', '13912627933', '1493712781', '0', '', '', '');
INSERT INTO `train_student` VALUES ('136', '', '', '', '201705021613250505', '05024783', '余小媛', '1', '2009-5', '0', '13151630130', '1493712805', '0', '', '', '平直');
INSERT INTO `train_student` VALUES ('137', '', '', '', '201705021614284301', '05026974', '梁冠瑜', '0', '2008-10', '0', '18915511745', '1493712868', '0', '', '', '');
INSERT INTO `train_student` VALUES ('138', '', '', '', '201705021615493507', '05025369', '余顺烨', '0', '2005-12', '0', '13151630130', '1493712949', '0', '', '', '平直');
INSERT INTO `train_student` VALUES ('139', '', '', '', '201705021619134499', '05022579', '朱馨怡', '1', '2003-6', '0', '15365316106', '1493713153', '0', '', '', '');
INSERT INTO `train_student` VALUES ('140', '', '', '', '201705021620487570', '05023956', '宗禹诚', '0', '2008-1', '0', '15358813331', '1493713248', '0', '', '', '');
INSERT INTO `train_student` VALUES ('141', '', '', '', '201705021624587168', '05028088', '承宇宏', '1', '2002-10', '0', '13913133812', '1493713498', '0', '', '320502200210180267', '市振华中学');
INSERT INTO `train_student` VALUES ('142', '', '', '', '201705021625428937', '05023304', '钱孝均', '0', '2009-5', '0', '13646225573', '1493713542', '0', '', '', '平江');
INSERT INTO `train_student` VALUES ('143', '', '', '', '201705021626232389', '05022423', '蒋青凌', '1', '2003-5', '0', '18015551369', '1493713583', '0', '', '', '');
INSERT INTO `train_student` VALUES ('144', '', '', '', '201705021626581047', '05022450', '章丽雯', '1', '2010-1', '0', '13962395553', '1493713618', '0', '', '', '彩香实验');
INSERT INTO `train_student` VALUES ('145', '', '', '', '201705021628213249', '05027238', '林欣怡', '1', '2003-1', '0', '13375186820', '1493713701', '0', '', '320503200301180269', '振华');
INSERT INTO `train_student` VALUES ('146', '', '', '', '201705021628362439', '05024303', '陆文瀚', '0', '2003-1', '0', '13771946959', '1493713716', '0', '', '', '振华中学');
INSERT INTO `train_student` VALUES ('147', '', '', '', '201705021632319392', '05020149', '胡佳宜', '1', '2003-5', '0', '13701412195', '1493713951', '0', '', '32050220030522076x', '景范中学');
INSERT INTO `train_student` VALUES ('148', '', '', '', '201705021632340608', '05022810', '刘奕辰', '1', '2008-10', '0', '15506135560', '1493713954', '0', '', '', '带城实验小学');
INSERT INTO `train_student` VALUES ('149', '', '', '', '201705030949134135', '05038681', '张倩', '1', '2003-6', '0', '13812639761', '1493776153', '0', '', '', '');
INSERT INTO `train_student` VALUES ('152', '', '', '', '201705031313569332', '05034795', '沈徐睿', '1', '2010-3', '0', '13913112860', '1493788436', '0', '', '', '');
INSERT INTO `train_student` VALUES ('153', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705031644540301', '05035111', '汪洋', '0', '2010-1', '7', '13254214756', '1493801094', '0', '初学', '', '');
INSERT INTO `train_student` VALUES ('154', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705031656380091', '05035208', '海洋', '0', '2010-1', '7', '15236524215', '1493801798', '0', '初学', '', '');
INSERT INTO `train_student` VALUES ('155', '', '', '', '201705031831031091', '05037034', '李文婷', '1', '2002-9', '0', '13952407705', '1493807463', '0', '', '', '');
INSERT INTO `train_student` VALUES ('156', 'or-Ynw2iuxO1h8yyeeehtdxBalCk', '', '', '201705041127324503', '05042469', '杨亦舒', '1', '2003-8', '13', '18913119336', '1493868452', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('157', 'or-Ynw1Uz6RAQFfu1wUh59dyBkxQ', '', '', '201705041206458068', '05043514', '蒋臻佳', '1', '2003-8', '13', '13862137077', '1493870805', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('158', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705041709080684', '05041136', '哈哈', '1', '2010-1', '7', '13244455263', '1493888948', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('159', 'or-Ynw2vjXVww5UCHV0xBP8JEnhg', '', '', '201705042208170189', '05045092', '许御风', '0', '2003-10', '13', '18036091211', '1493906897', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('160', '', '', '', '201705051131305255', '05050755', '李睿晗', '1', '2010-12', '0', '13616274306', '1493955090', '0', '', '', '同源幼儿园');
INSERT INTO `train_student` VALUES ('161', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705051458174615', '05052082', '哈', '1', '2010-1', '7', '13245785235', '1493967497', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('162', '', '', '', '201705052114082329', '05050989', '朱骏杰', '0', '2010-1', '0', '18962134582', '1493990048', '0', '', '', '苏州平江实验学校');
INSERT INTO `train_student` VALUES ('163', '', '', '', '201705061238458429', '05062567', '郭静雯', '1', '2008-6', '0', '13732644151', '1494045525', '0', '', '', '敬文小学');
INSERT INTO `train_student` VALUES ('164', '', '', '', '201705061342453139', '05069961', '李明渊', '1', '2008-12', '0', '13861333512', '1494049365', '0', '', '', '苏州沧浪实验小学');
INSERT INTO `train_student` VALUES ('165', '', '', '', '201705061504455397', '05069449', '李羽墨', '1', '2010-12', '0', '15950000502', '1494054285', '0', '', '', '');
INSERT INTO `train_student` VALUES ('166', '', '', '', '201705061648582449', '05069641', '张祺', '1', '2002-9', '0', '13402680352', '1494060538', '0', '', '', '平江中学');
INSERT INTO `train_student` VALUES ('167', '', '', '', '201705061929037852', '05065873', '陈晟', '1', '2005-8', '0', '13915595139', '1494070143', '0', '', '', '东中市实小');
INSERT INTO `train_student` VALUES ('168', '', '', '', '201705071216345405', '05075945', '王李嘉', '1', '2002-11', '0', '13771888318', '1494130594', '0', '', '', '平江中学');
INSERT INTO `train_student` VALUES ('169', '', '', '', '201705071408160405', '05070408', '蔡雨晴', '1', '2003-5', '0', '13584875521', '1494137296', '0', '', '320507200305171525', '景城学校');
INSERT INTO `train_student` VALUES ('170', '', '', '', '201705071545396222', '05077254', '蒲铖杨', '1', '2010-1', '0', '13776015219', '1494143139', '0', '', '', '平直');
INSERT INTO `train_student` VALUES ('171', '', '', '', '201705071609360347', '05076718', '张阳', '1', '2003-2', '0', '13913163996', '1494144576', '0', '', '320502200302102266', '景范中心');
INSERT INTO `train_student` VALUES ('172', '', '', '', '201705071647346275', '05076894', '顾航', '1', '2004-6', '0', '13962189045', '1494146854', '0', '', '', '振华');
INSERT INTO `train_student` VALUES ('173', '', '', '', '201705071712586185', '05072108', '罗兰', '1', '2003-5', '0', '13771715223', '1494148378', '0', '', '320503200305290764', '十六中');
INSERT INTO `train_student` VALUES ('174', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705080748292127', '05084390', '哈哈', '0', '2010-1', '7', '13524563253', '1494200909', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('175', '', '', '', '201705080826225746', '05085907', '陈籽娴', '1', '2007-8', '0', '18896961791', '1494203182', '0', '', '', '');
INSERT INTO `train_student` VALUES ('176', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705080835090173', '05087560', '哈拉', '0', '2010-1', '7', '15263253253', '1494203709', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('177', 'or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '', '', '201705082008597576', '05083839', '哈哈', '0', '2010-1', '7', '15233325689', '1494245339', '0', '初学', null, null);
INSERT INTO `train_student` VALUES ('178', '', '', '', '201705090941313264', '05092223', '杨蕊荧', '1', '2009-6', '0', '13812888864', '1494294091', '0', '', '', '苏州沧浪实验小学');
INSERT INTO `train_student` VALUES ('179', '', '', '', '201705091238271722', '05092939', '姚治远', '1', '2005-2', '0', '13862564380', '1494304707', '0', '', '', '');
INSERT INTO `train_student` VALUES ('180', '', '', '', '201705091240290671', '05092377', '吴晨皓', '1', '2007-8', '0', '13915531550', '1494304829', '0', '', '', '');
INSERT INTO `train_student` VALUES ('182', '', '', '', '201705091943383723', '05092042', '鹿恒睿', '1', '2009-1', '0', '18915438797', '1494330218', '0', '', '', '平江实验小学');
INSERT INTO `train_student` VALUES ('183', '', '', '', '201705092139395792', '05092309', '孙彬彬', '1', '2004-10', '0', '13912770659', '1494337179', '0', '', '', '');
INSERT INTO `train_student` VALUES ('184', '', '', '', '201705101042178943', '05108588', '钱馨雨', '1', '2002-12', '0', '13915570053', '1494384137', '0', '', '', '振华');

-- ----------------------------
-- Table structure for train_ucenter_admin
-- ----------------------------
DROP TABLE IF EXISTS `train_ucenter_admin`;
CREATE TABLE `train_ucenter_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理员状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of train_ucenter_admin
-- ----------------------------

-- ----------------------------
-- Table structure for train_ucenter_app
-- ----------------------------
DROP TABLE IF EXISTS `train_ucenter_app`;
CREATE TABLE `train_ucenter_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '应用ID',
  `title` varchar(30) NOT NULL COMMENT '应用名称',
  `url` varchar(100) NOT NULL COMMENT '应用URL',
  `ip` char(15) NOT NULL COMMENT '应用IP',
  `auth_key` varchar(100) NOT NULL COMMENT '加密KEY',
  `sys_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '同步登陆',
  `allow_ip` varchar(255) NOT NULL COMMENT '允许访问的IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '应用状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用表';

-- ----------------------------
-- Records of train_ucenter_app
-- ----------------------------

-- ----------------------------
-- Table structure for train_ucenter_member
-- ----------------------------
DROP TABLE IF EXISTS `train_ucenter_member`;
CREATE TABLE `train_ucenter_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of train_ucenter_member
-- ----------------------------
INSERT INTO `train_ucenter_member` VALUES ('1', 'admin', '58041603ea9cc2f244fcb6bcb3a11dd2', 'admin@qq.com', '', '1487828308', '2130706433', '1494395473', '3730730455', '1487828308', '1');
INSERT INTO `train_ucenter_member` VALUES ('17', '881', '5598456aa4000fb4392be061984b8181', '000888@qq.com', '', '1478659210', '3232240811', '1493789914', '3549427034', '1478659210', '1');
INSERT INTO `train_ucenter_member` VALUES ('18', '882', '5598456aa4000fb4392be061984b8181', '000999@qq.com', '', '1478659248', '3232240811', '1494247468', '3549427034', '1478659248', '1');
INSERT INTO `train_ucenter_member` VALUES ('19', '883', '5598456aa4000fb4392be061984b8181', '883@qq.com', '', '1478674144', '3657746734', '1494392453', '3549427034', '1478674144', '1');
INSERT INTO `train_ucenter_member` VALUES ('20', '884', '5598456aa4000fb4392be061984b8181', '884@qq.com', '', '1478674164', '3657746734', '1494337026', '3549427034', '1478674164', '1');
INSERT INTO `train_ucenter_member` VALUES ('21', '885', '5598456aa4000fb4392be061984b8181', '885@qq.com', '', '1478674176', '3657746734', '1494075848', '3549427034', '1478674176', '1');
INSERT INTO `train_ucenter_member` VALUES ('22', '886', '5598456aa4000fb4392be061984b8181', '886@qq.com', '', '1478674192', '3657746734', '1478947825', '3657746734', '1478674192', '1');
INSERT INTO `train_ucenter_member` VALUES ('23', '887', '5598456aa4000fb4392be061984b8181', '887@qq.com', '', '1478674192', '3657746734', '1493710860', '1968357139', '1478674192', '1');
INSERT INTO `train_ucenter_member` VALUES ('24', 'suzhou', '96aac08ecca66215f6de895a9fb343de', 'suzhou@qq.com', '', '1493791608', '3549427034', '1494396033', '3730730455', '1493791608', '1');

-- ----------------------------
-- Table structure for train_ucenter_setting
-- ----------------------------
DROP TABLE IF EXISTS `train_ucenter_setting`;
CREATE TABLE `train_ucenter_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型（1-用户配置）',
  `value` text NOT NULL COMMENT '配置数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置表';

-- ----------------------------
-- Records of train_ucenter_setting
-- ----------------------------

-- ----------------------------
-- Table structure for train_url
-- ----------------------------
DROP TABLE IF EXISTS `train_url`;
CREATE TABLE `train_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `short` char(100) NOT NULL DEFAULT '' COMMENT '短网址',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接表';

-- ----------------------------
-- Records of train_url
-- ----------------------------

-- ----------------------------
-- Table structure for train_user
-- ----------------------------
DROP TABLE IF EXISTS `train_user`;
CREATE TABLE `train_user` (
  `openid` varchar(30) NOT NULL,
  `subscribe` tinyint(4) DEFAULT '1' COMMENT '用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。',
  `updatetime` int(11) DEFAULT NULL COMMENT '最后更新时间',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户的昵称',
  `sex` tinyint(4) DEFAULT '1' COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `city` varchar(50) DEFAULT NULL COMMENT '用户所在城市',
  `province` varchar(50) DEFAULT NULL COMMENT '用户所在省份',
  `country` varchar(50) DEFAULT NULL COMMENT '用户所在国家',
  `headimgurl` varchar(255) DEFAULT NULL,
  `subscribe_time` int(11) DEFAULT NULL COMMENT '用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间',
  `language` varchar(10) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL COMMENT '只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。',
  `paytypeid` int(11) DEFAULT '4' COMMENT '用户默认的支付方式编号，默认为微信支付',
  `memberid` int(11) DEFAULT '0' COMMENT 'CRM系统会员卡对应的ID（memberinfo表）',
  `cardnum` int(11) DEFAULT '0' COMMENT 'CRM系统的会员卡号',
  `latitude` float(11,6) DEFAULT '0.000000' COMMENT '用户纬度',
  `longitude` float(11,6) DEFAULT '0.000000' COMMENT '用户所在精度',
  PRIMARY KEY (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信用户基本信息';

-- ----------------------------
-- Records of train_user
-- ----------------------------
INSERT INTO `train_user` VALUES ('or-Ynw-Q-EwyOpZgmMTdgHFbcaCo', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw5m32_ic9jPVAEpLKPlNO5o', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9YOBPl-Zp4enzl0-sQ-sWo', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw3PEfG3Apqy6SzdY-G-d16c', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwxcyog2Zyyo_-xVspQ6MbSs', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0F0_jDhpuqZfhTRCloVt7w', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7BJFAbYN61Nt6X1mClOHXY', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwwau4CKYCrZyQMU8kqeYD9Y', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwwUfiQaWMfbWCt8VU62y3R4', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_rlNdzLlKBNiNAcoHlVAKw', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7P8iByW8x-ShGdldmd_UiU', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_HBz3BH6_DSYiqVjS0g2_E', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw5FIFe8gqkJVCGLTZxgr1ZY', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4qIQAAKUT2Mnl471lrB5Ac', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_CvdQ4bWUNJfECnj8sFvMw', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0JkhyRaUjFTCZV8loOprs4', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9MVsOeXlTWueVpNuIGhP30', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwzoNNh_VM8mKuTV3D3EcNVA', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwwvx6ijwO_49WlIEuhzkMeI', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0mut55qaRKKRGh0zazSk8M', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwzGBLPf-P1Zntb1ksRLfnbU', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwydMy8egmN1Kkx9Lg0ed0WA', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw2P_mWj_HdFgER0tOcphACE', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0O6qIkYmKE5c3odRyuSObk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7ynTxs6a0F_D5EgImpVygk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7JGN_5I3X7QQMdjRN1NffQ', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4BsFN-z3pNS4b5_JDMDJvI', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw2iuxO1h8yyeeehtdxBalCk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw1Uz6RAQFfu1wUh59dyBkxQ', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw8fuohT52vhNjHNm10hiWtM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw64uus_CCJYXt_kKiMgs3Tc', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwz33vJmV1iNB5jSR_0a5PCk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw2cmiah2Ib72m5Dfu-TSoQ0', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw5y5Dn8BFBUfNpJsc8aQaQg', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw8gaqz2aE63lYh_K5yDhNaI', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwwc0QxWik-U0D7q0xCamAvM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_ppApcJugVj3a-Jr4xr8yc', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwyn1-Etj-dhgEJxCzhdQCAg', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw2vjXVww5UCHV0xBP8JEnhg', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwxQKrErxpuu3CCoZiyLalEM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwzlinlR6Mo66FNiRDA5ReQo', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwyLFSGm9OXe0X6kBkzSjyPA', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw1EQ7n3pi31RzwQwWVvOyMQ', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwzU0cnHYzfMBINXZ6_hbZuQ', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0DGH5OyGTHEjwG4__5hDe0', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw6LOuCfJu8FU-PrYEhpfC-E', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_zCGSLfwDr2d7nFfUlyLKM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7uo0DYiLjm71Ul93E_H6Zg', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9lPwCdRYz4ODu_W7SxwBck', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw-WLqBh1akHd9E5-krGq9Sc', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4-TavXx5ehRd9zW_cIPIfk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwzCm7FBSaMX7IKrQA4Db-BM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw5zkElfAHBf5RqBlKP2Prl0', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0va1JoUeAfwfMVX3MshJeA', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9erlF-4IwHb7YEsx0bUq6k', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw44dng7hpkbbV50Hris9WUM', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9BtOQVeFrM7ckvzKxpoyFc', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw6leCrIcNQE7V1zBhZx2DSo', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwz0_tQ8G2PEYhWTdH5y5IXI', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw8H3_qZVyK3pejljEwTA45w', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw57F3EOjatdX0ph1kIief8c', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw8qP-e7X2kfLkwmY1A71b_U', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw-qxXXREYLnj1BAjihlwIMo', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7HHfWZBuiN5EOmycwYcF08', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9A1-9N0_1z_ml2Gy7arQQ4', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw05G_yw-rlmyEvqNnN3OC7Y', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw6CyaCi62zJmzOrW8RXQc1I', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0g--JVc92wNitrlVJM4NEc', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw3GPhWRccsPq8gFDBrtNM3o', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7rT6acMqUXXDmh1RZqnwMw', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw8lsY-fLHkhMWwVOlh6YS4w', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwyDMWav0l4zWaVWSn6SVKSI', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw1VtyhdYqxZH8sJkaDXM3X0', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4TkXi_uzQ8MzqTId1Q6ewk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw5FzN45zvMScL4VDcksui9k', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-YnwwO6jmUBVX2RAMWZnj7TOxU', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_NbYih3z9q2zjeSPoobuKY', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4RnCRjfqnTgujGSCt7zI4M', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4E-yo2NVzbMECQMjF71zog', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw1P0Fk9vDgv8aXOL4aqE73k', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9T91wbneqCqM5CNJtG956c', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw593m7Kz4aSsZh9C0dJb9D4', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw3xnNZRUTsEzbJnYnBU6AK4', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_SsEYQi5U6M1Rr9_6K7E4c', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw84Mx2wZcvzZTJn-bjeVPIk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw0-G_k67eGHnEDSecDP2jGs', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7RHj4oXe4GGx1DjrfXZbag', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw_d7qoXh3vrIj-8WgdNQIVA', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9JmuZEu6hOkNmtF8O71Z3k', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynwwocy0O6qtDLlURwMDx1VTE', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw9SKK3vNz5egAacZce7gQMY', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw4HxMJFg73fVrFqB4AoV34A', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw1orJi9g-3Hh9vc0xsenhxk', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');
INSERT INTO `train_user` VALUES ('or-Ynw7sMH5jbtVvMo1_WLKNQARY', '1', null, null, '1', null, null, null, null, null, null, null, '4', '0', '0', '0.000000', '0.000000');

-- ----------------------------
-- Table structure for train_user_token
-- ----------------------------
DROP TABLE IF EXISTS `train_user_token`;
CREATE TABLE `train_user_token` (
  `access_token` varchar(255) NOT NULL COMMENT '网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同',
  `expires_in` int(11) NOT NULL COMMENT 'access_token接口调用凭证超时时间，单位（秒）',
  `refresh_token` varchar(255) NOT NULL COMMENT '用户刷新access_token',
  `openid` varchar(255) NOT NULL COMMENT '用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID',
  `scope` varchar(255) NOT NULL COMMENT '用户授权的作用域，使用逗号（,）分隔',
  `updatetime` int(11) NOT NULL,
  PRIMARY KEY (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of train_user_token
-- ----------------------------

-- ----------------------------
-- Table structure for train_userdata
-- ----------------------------
DROP TABLE IF EXISTS `train_userdata`;
CREATE TABLE `train_userdata` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `type` tinyint(3) unsigned NOT NULL COMMENT '类型标识',
  `target_id` int(10) unsigned NOT NULL COMMENT '目标id',
  UNIQUE KEY `uid` (`uid`,`type`,`target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_userdata
-- ----------------------------

-- ----------------------------
-- Table structure for train_wxpay_order
-- ----------------------------
DROP TABLE IF EXISTS `train_wxpay_order`;
CREATE TABLE `train_wxpay_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `number` varchar(255) NOT NULL DEFAULT '' COMMENT '支付编号',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `amount` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '付款金额',
  `paytime` varchar(11) NOT NULL DEFAULT '' COMMENT '支付时间',
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train_wxpay_order
-- ----------------------------
INSERT INTO `train_wxpay_order` VALUES ('60', '16', '20170330160053666660', '0', '1490860853', '0.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('61', '16', '20170330160312462603', '1', '1490860992', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('62', '16', '20170330160451564030', '0', '1490861091', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('63', '16', '20170330161000377273', '0', '1490861400', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('64', '16', '20170330161004614439', '0', '1490861404', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('65', '16', '20170330161448932026', '0', '1490861688', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('66', '16', '20170330161455066164', '0', '1490861695', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('67', '16', '20170330161457667140', '1', '1490861697', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('68', '17', '20170330171950577708', '0', '1490865590', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('69', '17', '20170330172000059000', '0', '1490865600', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('70', '17', '20170330180653427127', '0', '1490868413', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('71', '18', '20170401102559414467', '0', '1491013559', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('72', '1', '20170401102855160684', '0', '1491013735', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('73', '18', '20170401102903053757', '0', '1491013743', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('74', '5', '20170401105305522792', '0', '1491015185', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('75', '2', '20170401113403063664', '0', '1491017643', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('76', '2', '20170401113422312327', '0', '1491017662', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('77', '2', '20170401115114936640', '0', '1491018674', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('78', '31', '20170401115421000692', '1', '1491018861', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('79', '87', '20170401115455199659', '0', '1491018895', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('80', '1', '20170401133925546658', '0', '1491025165', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('81', '1', '20170401133935421851', '0', '1491025175', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('82', '1', '20170401134741161197', '0', '1491025661', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('83', '1', '20170401135329272605', '0', '1491026009', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('84', '1', '20170401135339998838', '0', '1491026019', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('85', '1', '20170401135340960937', '0', '1491026020', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('86', '49', '20170401135523420372', '0', '1491026123', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('87', '49', '20170401135537443634', '0', '1491026137', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('88', '49', '20170401135553735201', '0', '1491026153', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('89', '49', '20170401135603165850', '0', '1491026163', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('90', '26', '20170401135834875496', '0', '1491026314', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('91', '49', '20170401140533040974', '0', '1491026733', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('92', '2', '20170401141028035125', '0', '1491027028', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('93', '2', '20170401141052008863', '0', '1491027052', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('94', '49', '20170401141114016555', '0', '1491027074', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('95', '1', '20170401141657392483', '0', '1491027417', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('96', '1', '20170401141807347961', '0', '1491027487', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('97', '1', '20170401141812477807', '0', '1491027492', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('98', '67', '20170401141931697833', '0', '1491027571', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('99', '67', '20170401141950917376', '0', '1491027590', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('100', '67', '20170401141954640271', '0', '1491027594', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('101', '67', '20170401142015441068', '0', '1491027615', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('102', '67', '20170401142304870571', '0', '1491027784', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('103', '67', '20170401142320271218', '0', '1491027800', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('104', '67', '20170401142413369779', '0', '1491027853', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('105', '67', '20170401142629995442', '0', '1491027989', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('106', '67', '20170401142718429846', '0', '1491028038', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('107', '67', '20170401142724096216', '0', '1491028044', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('108', '33', '20170401143201458794', '1', '1491028321', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('109', '34', '20170401143337848238', '1', '1491028417', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('110', '35', '20170401143757078813', '0', '1491028677', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('111', '36', '20170401144041874369', '0', '1491028841', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('112', '36', '20170401144106773898', '0', '1491028866', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('113', '37', '20170401144557062683', '0', '1491029157', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('114', '38', '20170401144633264188', '0', '1491029193', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('115', '39', '20170401144653167727', '0', '1491029213', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('116', '39', '20170401144908158309', '0', '1491029348', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('117', '39', '20170401144912257941', '0', '1491029352', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('118', '39', '20170401144916284580', '0', '1491029356', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('119', '38', '20170401144925402597', '0', '1491029365', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('120', '40', '20170401144934156629', '1', '1491029374', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('121', '38', '20170401145025509499', '0', '1491029425', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('122', '38', '20170401145206138238', '0', '1491029526', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('123', '41', '20170401145339108094', '0', '1491029619', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('124', '41', '20170401145349451330', '0', '1491029629', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('125', '42', '20170401145457495301', '0', '1491029697', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('126', '43', '20170401145610393738', '1', '1491029770', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('127', '44', '20170401145634263256', '0', '1491029794', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('128', '45', '20170401145800298772', '0', '1491029880', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('129', '45', '20170401145810686200', '0', '1491029890', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('130', '45', '20170401145810809553', '0', '1491029890', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('131', '45', '20170401145810881680', '0', '1491029890', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('132', '38', '20170401145837488757', '0', '1491029917', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('133', '46', '20170401160407024304', '1', '1491033847', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('134', '47', '20170401160526375980', '0', '1491033926', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('135', '48', '20170401161239300941', '0', '1491034359', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('136', '48', '20170401161344140795', '0', '1491034424', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('137', '41', '20170401163602753490', '1', '1491035762', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('138', '49', '20170401165529098399', '1', '1491036929', '0.01', '2017');
INSERT INTO `train_wxpay_order` VALUES ('139', '48', '20170401165620491315', '0', '1491036980', '0.01', '0');
INSERT INTO `train_wxpay_order` VALUES ('140', '48', '20170401171122039027', '0', '1491037882', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('141', '48', '20170401171137060700', '0', '1491037897', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('142', '48', '20170401171149268915', '0', '1491037909', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('143', '50', '20170401180234372490', '0', '1491040954', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('144', '50', '20170401181556227492', '0', '1491041756', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('145', '50', '20170401181605405718', '0', '1491041765', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('146', '50', '20170401181804908162', '0', '1491041884', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('147', '51', '20170401182038851411', '0', '1491042038', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('148', '51', '20170401182103501014', '0', '1491042063', '750.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('149', '52', '20170401182711948112', '0', '1491042431', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('150', '52', '20170401182721549776', '0', '1491042441', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('151', '52', '20170401182736493947', '0', '1491042456', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('152', '53', '20170401183035394827', '0', '1491042635', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('153', '53', '20170401183044224032', '0', '1491042644', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('154', '53', '20170401183118487030', '0', '1491042678', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('155', '52', '20170401183526748520', '0', '1491042926', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('156', '51', '20170401183636142519', '0', '1491042996', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('157', '52', '20170401184904540698', '0', '1491043744', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('158', '51', '20170401184931069449', '0', '1491043771', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('159', '52', '20170401184943253099', '0', '1491043783', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('160', '52', '20170401185035703313', '0', '1491043835', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('161', '52', '20170401185041063024', '0', '1491043841', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('162', '52', '20170401185101034177', '0', '1491043861', '950.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('163', '53', '20170404085815652766', '0', '1491267495', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('164', '53', '20170404085850541975', '0', '1491267530', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('165', '54', '20170405175538819875', '0', '1491386138', '808.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('166', '54', '20170405175547982146', '0', '1491386147', '788.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('167', '54', '20170405175558958580', '0', '1491386158', '808.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('168', '54', '20170405175600154333', '0', '1491386160', '808.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('169', '51', '20170405175614501494', '0', '1491386174', '800.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('170', '50', '20170405175619545651', '0', '1491386179', '1000.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('171', '54', '20170405175730508342', '0', '1491386250', '808.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('172', '54', '20170405175851779600', '0', '1491386331', '808.00', '0');
INSERT INTO `train_wxpay_order` VALUES ('173', '54', '20170411160839672539', '0', '1491898119', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('174', '54', '20170411160849541404', '0', '1491898129', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('175', '54', '20170411201137258643', '0', '1491912697', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('176', '54', '20170411201148998012', '0', '1491912708', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('177', '54', '20170411201202023000', '0', '1491912722', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('178', '54', '20170411201221768925', '0', '1491912741', '808.00', '');
INSERT INTO `train_wxpay_order` VALUES ('179', '124', '20170420173519696464', '0', '1492680919', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('180', '124', '20170420173529135557', '0', '1492680929', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('181', '124', '20170420173531363072', '0', '1492680931', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('182', '130', '20170426085744809795', '0', '1493168264', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('183', '134', '20170428113408435880', '0', '1493350448', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('184', '134', '20170428113418444999', '0', '1493350458', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('185', '134', '20170428113428940384', '0', '1493350468', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('186', '217', '20170503164454787572', '0', '1493801094', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('187', '217', '20170503164503658509', '0', '1493801103', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('188', '218', '20170503165638240253', '0', '1493801798', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('189', '218', '20170503165648904738', '0', '1493801808', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('190', '218', '20170503165650302155', '0', '1493801810', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('191', '220', '20170504112732151753', '1', '1493868452', '2040.00', '2017-05-04 ');
INSERT INTO `train_wxpay_order` VALUES ('192', '220', '20170504112742098332', '0', '1493868462', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('193', '220', '20170504112744578706', '0', '1493868464', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('194', '221', '20170504120645220170', '1', '1493870805', '2040.00', '2017-05-04 ');
INSERT INTO `train_wxpay_order` VALUES ('195', '221', '20170504120655511915', '0', '1493870815', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('196', '221', '20170504120657076915', '0', '1493870817', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('197', '222', '20170504170908315660', '0', '1493888948', '3680.00', '');
INSERT INTO `train_wxpay_order` VALUES ('198', '222', '20170504170918506808', '0', '1493888958', '3680.00', '');
INSERT INTO `train_wxpay_order` VALUES ('199', '222', '20170504170922352662', '0', '1493888962', '3680.00', '');
INSERT INTO `train_wxpay_order` VALUES ('200', '224', '20170505095901680196', '0', '1493949541', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('201', '224', '20170505095911569512', '0', '1493949551', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('202', '224', '20170505095914387552', '0', '1493949554', '2040.00', '');
INSERT INTO `train_wxpay_order` VALUES ('203', '227', '20170505145818405706', '0', '1493967498', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('204', '227', '20170505145828833946', '0', '1493967508', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('205', '227', '20170505145828073597', '0', '1493967508', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('206', '227', '20170505145828454823', '0', '1493967508', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('207', '227', '20170505145828928698', '0', '1493967508', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('208', '227', '20170505145829802364', '0', '1493967509', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('209', '227', '20170505145830498510', '0', '1493967510', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('210', '227', '20170505145843025199', '0', '1493967523', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('211', '240', '20170508074829130588', '0', '1494200909', '1540.00', '');
INSERT INTO `train_wxpay_order` VALUES ('212', '240', '20170508074839274700', '0', '1494200919', '1540.00', '');
INSERT INTO `train_wxpay_order` VALUES ('213', '240', '20170508074840423264', '0', '1494200920', '1540.00', '');
INSERT INTO `train_wxpay_order` VALUES ('214', '242', '20170508083509895947', '0', '1494203709', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('215', '242', '20170508083519114808', '0', '1494203719', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('216', '242', '20170508083520179180', '0', '1494203720', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('217', '242', '20170508083538499572', '0', '1494203738', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('218', '242', '20170508083549427153', '0', '1494203749', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('219', '242', '20170508083602528804', '0', '1494203762', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('220', '243', '20170508200859395678', '0', '1494245339', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('221', '243', '20170508200909493245', '0', '1494245349', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('222', '243', '20170508200911351032', '0', '1494245351', '1000.00', '');
INSERT INTO `train_wxpay_order` VALUES ('223', '243', '20170508200921494018', '0', '1494245361', '1000.00', '');
