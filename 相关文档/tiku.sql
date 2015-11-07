/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.6.21 : Database - tiku
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tiku` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tiku`;

/*Table structure for table `course_to_type` */

DROP TABLE IF EXISTS `course_to_type`;

CREATE TABLE `course_to_type` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `course_id` mediumint(11) DEFAULT NULL COMMENT '科目ID',
  `type_id` mediumint(11) DEFAULT NULL COMMENT '题型ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `province` */

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `province_name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Table structure for table `shijuan_type` */

DROP TABLE IF EXISTS `shijuan_type`;

CREATE TABLE `shijuan_type` (
  `id` mediumint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `banshi` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku` */

DROP TABLE IF EXISTS `tiku`;

CREATE TABLE `tiku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` mediumint(3) DEFAULT NULL,
  `difficulty_id` tinyint(2) DEFAULT NULL COMMENT '难度系数id',
  `content` text COMMENT '内容',
  `options` text COMMENT '单选/多选题选项',
  `source_id` mediumint(11) DEFAULT NULL COMMENT '来源',
  `answer` text COMMENT '答案',
  `analysis` text COMMENT '解析',
  `clicks` int(11) DEFAULT NULL COMMENT '点击数',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '1已审核，0表示未审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_course` */

DROP TABLE IF EXISTS `tiku_course`;

CREATE TABLE `tiku_course` (
  `id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(32) NOT NULL DEFAULT '',
  `course_type` tinyint(1) DEFAULT '1' COMMENT '1表示高中，2表示初中',
  `status` tinyint(1) DEFAULT '1' COMMENT '0表示无效，1表示有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_difficulty` */

DROP TABLE IF EXISTS `tiku_difficulty`;

CREATE TABLE `tiku_difficulty` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `degreen` mediumint(4) DEFAULT NULL COMMENT '难度系数',
  `description` varchar(16) DEFAULT NULL COMMENT '简单、困难。。',
  `section` varchar(16) DEFAULT NULL COMMENT '区间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_feature` */

DROP TABLE IF EXISTS `tiku_feature`;

CREATE TABLE `tiku_feature` (
  `id` mediumint(1) NOT NULL AUTO_INCREMENT,
  `feature_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1表示高中，2表示初中',
  `feature_name` varchar(32) NOT NULL,
  `is_wenli` tinyint(1) DEFAULT '0' COMMENT '当选择的科目是高中数学时默认0表示不分文理科，1表示有分文理科',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_feature_type` */

DROP TABLE IF EXISTS `tiku_feature_type`;

CREATE TABLE `tiku_feature_type` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(64) DEFAULT NULL,
  `feature_id` mediumint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_point` */

DROP TABLE IF EXISTS `tiku_point`;

CREATE TABLE `tiku_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` mediumint(3) NOT NULL COMMENT '科目id',
  `parent_id` int(11) NOT NULL COMMENT '父类id',
  `point_name` varchar(64) NOT NULL,
  `diKnowledgeId` mediumint(11) DEFAULT NULL COMMENT '采集源的知识点ID',
  `knowledgeId` mediumint(11) DEFAULT NULL COMMENT '采集源的知识点ID,采集题库传递该参数',
  `level` tinyint(1) DEFAULT NULL COMMENT '知识点层级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_source` */

DROP TABLE IF EXISTS `tiku_source`;

CREATE TABLE `tiku_source` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `course_id` mediumint(4) DEFAULT NULL COMMENT '课程ID，tiku表中的course_id字段删掉',
  `source_name` varchar(128) DEFAULT NULL COMMENT '来源',
  `year` mediumint(4) DEFAULT NULL COMMENT '年份',
  `province_id` mediumint(4) DEFAULT NULL COMMENT '省份',
  `grade` tinyint(2) DEFAULT NULL COMMENT '1表示高一，2表示高二，3表示高三',
  `tiku_count` mediumint(4) DEFAULT NULL COMMENT '题目数量',
  `clicks` int(11) DEFAULT '0' COMMENT '点击数',
  `source_type_id` mediumint(4) DEFAULT '0' COMMENT '1表示高考真题，2表示名校模拟，3表示月考试卷，4表示期中试卷，5表示期末试卷',
  `wen_li` tinyint(1) DEFAULT '0' COMMENT '1表示理科，2表示文科，默认0表示不分',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_to_point` */

DROP TABLE IF EXISTS `tiku_to_point`;

CREATE TABLE `tiku_to_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiku_id` int(11) DEFAULT NULL COMMENT '题库id',
  `point_id` mediumint(11) DEFAULT NULL COMMENT '知识点id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8;

/*Table structure for table `tiku_type` */

DROP TABLE IF EXISTS `tiku_type`;

CREATE TABLE `tiku_type` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(32) NOT NULL COMMENT '单选、多选。。。',
  `wieght` int(11) DEFAULT '0' COMMENT '权重值，越高组卷时越靠前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL COMMENT '邮箱',
  `telphone` int(11) DEFAULT NULL COMMENT '手机号码',
  `nick_name` varchar(64) DEFAULT NULL COMMENT '昵称',
  `real_name` varchar(32) DEFAULT NULL COMMENT '真实姓名',
  `password` varchar(128) DEFAULT NULL,
  `introduction` text COMMENT '个人简介',
  `type` tinyint(1) DEFAULT '1' COMMENT '账号类型，1表示学生，2表示老师',
  `tel_verified` tinyint(1) DEFAULT '0' COMMENT '1表示已验证，0表示未验证',
  `email_verified` tinyint(1) DEFAULT '0' COMMENT '1表示已验证，0表示未验证',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `last_login` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `login_ip` varchar(64) DEFAULT NULL COMMENT '登录IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `user_collected` */

DROP TABLE IF EXISTS `user_collected`;

CREATE TABLE `user_collected` (
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `tiku_id` int(11) DEFAULT NULL COMMENT '题库id',
  `collected_time` int(11) DEFAULT NULL COMMENT '收藏的时间',
  `tags` varchar(128) DEFAULT NULL COMMENT '标签'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user_shijuan` */

DROP TABLE IF EXISTS `user_shijuan`;

CREATE TABLE `user_shijuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `content` text COMMENT '试卷内容，用json格式保存',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
