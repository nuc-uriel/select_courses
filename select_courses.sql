/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50715
Source Host           : localhost:3306
Source Database       : select_courses

Target Server Type    : MYSQL
Target Server Version : 50715
File Encoding         : 65001

Date: 2018-05-26 10:56:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sc_course
-- ----------------------------
DROP TABLE IF EXISTS `sc_course`;
CREATE TABLE `sc_course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '任课老师ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '课程名称',
  `score` decimal(2,1) NOT NULL DEFAULT '0.0' COMMENT '学分',
  `class` varchar(32) NOT NULL DEFAULT '' COMMENT '教室',
  `time` varchar(32) NOT NULL DEFAULT '' COMMENT '上课时间',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '课容量',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='课程表';

-- ----------------------------
-- Records of sc_course
-- ----------------------------
INSERT INTO `sc_course` VALUES ('2', '6', 'Java', '1.5', '11111H', '1-17(六)', '150', '2018-05-25 17:16:52', '2018-05-25 17:16:52');
INSERT INTO `sc_course` VALUES ('3', '5', 'php', '2.0', '10201', '2-15(日)', '150', '2018-05-25 21:04:19', '2018-05-25 21:08:59');

-- ----------------------------
-- Table structure for sc_student_course
-- ----------------------------
DROP TABLE IF EXISTS `sc_student_course`;
CREATE TABLE `sc_student_course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',
  `course_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '课程ID',
  `score` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '成绩',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='选课表';

-- ----------------------------
-- Records of sc_student_course
-- ----------------------------
INSERT INTO `sc_student_course` VALUES ('1', '7', '2', '0.00', '2018-05-25 22:42:42', '2018-05-25 22:42:42');

-- ----------------------------
-- Table structure for sc_user
-- ----------------------------
DROP TABLE IF EXISTS `sc_user`;
CREATE TABLE `sc_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `number` varchar(32) NOT NULL DEFAULT '' COMMENT '学号',
  `class` varchar(64) NOT NULL DEFAULT '' COMMENT '单位',
  `role` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '角色：0管理员，1教师，2学生',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sc_user
-- ----------------------------
INSERT INTO `sc_user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '0', '2018-05-25 20:17:56', '2018-05-25 20:17:59');
INSERT INTO `sc_user` VALUES ('5', '小王老师', '21232f297a57a5a743894a0e4a801fc3', '20180002', '机电工程学院', '1', '2018-05-24 16:58:41', '2018-05-25 21:41:25');
INSERT INTO `sc_user` VALUES ('6', '小刘', 'f8f7ed18a7e76c59c1c87bda0057e2b4', '20180003', '理学院', '1', '2018-05-24 18:02:53', '2018-05-24 18:02:53');
INSERT INTO `sc_user` VALUES ('7', '赵晨凯', '2abb60f15889af390fed6d93b213ba66', '1514010416', '15140A02', '2', '2018-05-24 21:39:49', '2018-05-24 21:42:32');
