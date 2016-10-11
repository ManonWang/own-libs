/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50514
Source Host           : 10.20.69.58:3306
Source Database       : myphalcon

Target Server Type    : MYSQL
Target Server Version : 50514
File Encoding         : 65001

Date: 2016-10-11 09:47:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `en_name` varchar(255) NOT NULL,
  `zh_name` varchar(255) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `intro` varchar(255) NOT NULL,
  `hoppy` varchar(255) NOT NULL,
  `sex` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `age` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'wanggefa', '王革发', '18910542509', 'a@b.c', 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack', '0143157', 'aaaaa', '1,2', '1', '1', '0', '1473670569', '1474191431', '11');
INSERT INTO `user` VALUES ('2', 'wangge', '王革', '18910542509', 'a@b.c', 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack', '0143157', 'aaaaa', '1,2', '1', '1', '0', '1473672679', '1474193923', '11');
INSERT INTO `user` VALUES ('3', 'duanyuanrui', '段元瑞', '18001226196', 'abc@cba.com', 'http://www.baidu.com', '0143157', '简介啥的', '2,3', '2', '1', '0', '1473849954', '1473849954', '11');
INSERT INTO `user` VALUES ('4', 'wanggege', '王革革', '18910542509', 'a@b.c', 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack', '0143157', 'aaaaa', '1,2', '1', '1', '0', '1474183107', '1474183107', '11');
INSERT INTO `user` VALUES ('5', 'snb', '随你便', '15678952356', 'a@b.c', 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack', '0143156', 'sszz', '1,3', '2', '2', '0', '1474189494', '1474190181', '11');
INSERT INTO `user` VALUES ('6', 'wangweiwange', '王伟王', '13685263546', 'wangwei@baidu.com', 'http://www.baidu.com', '0143157', '百度工程师', '1,2', '1', '1', '0', '1474190297', '1474190595', '11');
INSERT INTO `user` VALUES ('7', 'wangweiwei', '王伟伟', '13685263546', 'wangwei@baidu.com', 'http://www.baidu.com', '0143157', '百度工程师', '1,2', '1', '1', '0', '1474190483', '1474190483', '11');
INSERT INTO `user` VALUES ('22', 'milining', '小米', '18656896523', '12@12.com', 'http://www.baidu.com', '000000', '000000', '1,2', '2', '1', '0', '1475221232', '1475221232', '12');
INSERT INTO `user` VALUES ('23', 'xiad', '发送', '18923456894', '1156466153@qq.com', 'http://waimai.meituan.com/home/wx4epc0yctpg', '000000', '000000', '1,2', '1', '1', '0', '1475414699', '1475414699', '12');
INSERT INTO `user` VALUES ('24', 'aaaaa', '第三方', '18910542510', 'abc@kk.com', 'http://waimai.meituan.com/home/wx4epc0yctpg', '111111', '111111', '1,2', '1', '2', '0', '1475550811', '1475550811', '12');
INSERT INTO `user` VALUES ('25', 'aaaaab', '的第三方', '18910542510', 'abc@kk.com', 'http://waimai.meituan.com/home/wx4epc0yctpg', '222222', '111111', '1,2', '1', '2', '0', '1475551033', '1475552034', '12');
INSERT INTO `user` VALUES ('28', 'wm', '我们', '18910542511', 'a@b.c', 'http://www.baidu.com', '222222', '222222', '1,3', '2', '2', '1', '1475905940', '1475908302', '23');
INSERT INTO `user` VALUES ('29', '1', 'qwe', '2', '3', '4', '5', '6', '7', '8', '9', '0', '10', '11', '10');
INSERT INTO `user` VALUES ('30', 'ad', '打的', '18910542509', 'a@b.c', 'http://www.baidu.com', '111111', '111111', '1,2', '2', '1', '0', '1475918213', '1475918213', '10');
INSERT INTO `user` VALUES ('35', 'test1', '测试', '18910542512', '12@163.com', 'http://www.baidu.com', '111111', '个人简介', '1,3', '1', '1', '0', '1475924276', '1475924301', '22');
INSERT INTO `user` VALUES ('36', 'ceshi1', '测测', '18910542514', '124@163.com', 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack', '222222', '个人简介', '2,3', '2', '1', '0', '1475924359', '1476073940', '34');
INSERT INTO `user` VALUES ('37', 'sd', '是的', '13511040356', 'a@b.com', 'http://www.baidu.com', '444444', 'ffffff', '1,2', '1', '2', '0', '1476015510', '1476015510', '12');
