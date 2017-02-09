/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50716
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50716
File Encoding         : 65001

Date: 2017-02-09 20:05:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `parent` int(10) DEFAULT NULL,
  `text` text NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `pk_user_id` (`user_id`),
  CONSTRAINT `pk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=585 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('580', '11', null, 'test', '1486663320', null);
INSERT INTO `comments` VALUES ('581', '11', null, 'test1', '1486663331', null);
INSERT INTO `comments` VALUES ('582', '12', '580', 'reply test', '1486663367', null);
INSERT INTO `comments` VALUES ('583', '12', '581', 'reply test2', '1486663374', null);
INSERT INTO `comments` VALUES ('584', '11', '582', 'reply test 3', '1486663398', null);

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('11', 'test', 'b59c67bf196a4758191e42f76670ceba', '1486663177');
INSERT INTO `user` VALUES ('12', 'test2', 'b59c67bf196a4758191e42f76670ceba', '1486663345');
