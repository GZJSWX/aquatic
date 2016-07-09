-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 �?07 �?09 �?18:31
-- 服务器版本: 5.5.47
-- PHP 版本: 5.5.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `aquatic`
--

-- --------------------------------------------------------

--
-- 表的结构 `ap_base`
--

CREATE TABLE IF NOT EXISTS `ap_base` (
  `base_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '基地编号',
  `base_name` varchar(20) NOT NULL DEFAULT '' COMMENT '基地名称',
  `base_addr` varchar(50) NOT NULL DEFAULT '' COMMENT '基地地址',
  `base_source_water` varchar(50) NOT NULL DEFAULT '' COMMENT '水质来源',
  `base_scale` varchar(50) NOT NULL DEFAULT '' COMMENT '基地规模',
  `base_contacts` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人',
  `base_tel` varchar(30) NOT NULL DEFAULT '' COMMENT '联系电话',
  `base_time` varchar(20) NOT NULL DEFAULT '',
  `base_coordinate` varchar(20) NOT NULL DEFAULT '',
  `base_code` char(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`base_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='基地基本信息' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ap_base`
--

INSERT INTO `ap_base` (`base_id`, `base_name`, `base_addr`, `base_source_water`, `base_scale`, `base_contacts`, `base_tel`, `base_time`, `base_coordinate`, `base_code`) VALUES
(1, '海大沙北基地', '海鸥岛', '海鸥岛', '基地养殖面积1247.5公顷', '苏振球', '13488882222', '2016-02-01 21:13', '116.439.7', '123'),
(2, '海大实验基地', '实验基地', '实验水库', '基地养殖面积1247.5公顷', '苏振球', '13488882222', '2016-02-06 21:13', '116.439.9', '111'),
(3, '家的粉丝', '是空间裂缝', '速度', '圣诞节', '圣诞节', '46523156', '2016-07-08 21:48', '213.1', '123');

-- --------------------------------------------------------

--
-- 表的结构 `ap_cage`
--

CREATE TABLE IF NOT EXISTS `ap_cage` (
  `cage_id` int(11) NOT NULL AUTO_INCREMENT,
  `cage_rowid` int(11) NOT NULL COMMENT '排编号',
  `cage_rowname` varchar(20) NOT NULL DEFAULT '' COMMENT '排名称',
  `cage_number` int(11) NOT NULL COMMENT '网箱数量',
  `cage_pool_id` int(11) DEFAULT NULL COMMENT '所属池塘id',
  `cage_code` char(5) DEFAULT NULL COMMENT '编码',
  `cage_row_code` char(5) DEFAULT NULL COMMENT '排编码',
  PRIMARY KEY (`cage_id`),
  KEY `cage_pool_id` (`cage_pool_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网箱信息（池塘养殖模式为网箱养殖才需要维护网箱信息）' AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `ap_cage`
--

INSERT INTO `ap_cage` (`cage_id`, `cage_rowid`, `cage_rowname`, `cage_number`, `cage_pool_id`, `cage_code`, `cage_row_code`) VALUES
(1, 1, '30排', 10, 1, '123', '123'),
(2, 2, '30排', 15, 1, '222', '12'),
(6, 3, '13排', 6, 1, NULL, NULL),
(7, 4, '14排', 10, 1, NULL, NULL),
(8, 5, '15排', 10, 1, NULL, NULL),
(9, 6, '16排', 10, 1, NULL, NULL),
(10, 7, '17排', 10, 1, NULL, NULL),
(11, 8, '18排', 10, 1, NULL, NULL),
(12, 9, '19排', 10, 1, NULL, NULL),
(13, 10, '20排', 10, 1, NULL, NULL),
(14, 11, '21排', 10, 2, NULL, NULL),
(15, 12, '22排', 10, 2, NULL, NULL),
(16, 13, '23排', 10, 2, NULL, NULL),
(17, 14, '24排', 10, 2, NULL, NULL),
(18, 15, '25排', 10, 2, NULL, NULL),
(19, 16, '26排', 10, 3, NULL, NULL),
(20, 17, '27排', 10, 3, NULL, NULL),
(21, 18, '28排', 10, 3, NULL, NULL),
(22, 19, '29排', 10, 3, NULL, NULL),
(23, 20, '30排', 10, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ap_feed`
--

CREATE TABLE IF NOT EXISTS `ap_feed` (
  `feed_id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_name` varchar(20) NOT NULL DEFAULT '',
  `feed_specifications` varchar(20) NOT NULL DEFAULT '',
  `feed_code` char(10) DEFAULT '' COMMENT '编码',
  PRIMARY KEY (`feed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ap_feed`
--

INSERT INTO `ap_feed` (`feed_id`, `feed_name`, `feed_specifications`, `feed_code`) VALUES
(1, '草鱼料', '20kg/包', '123'),
(2, '鲫鱼料', '100kg/包', ''),
(4, '鲤鱼料', '29kg/包', ''),
(5, '鳊鱼料', '10kg/包', ''),
(6, '罗非料', '10kg/包', ''),
(7, '黄颡鱼料', '10kg/包', ''),
(8, '海鲈料', '10kg/包', ''),
(9, '加州鲈料', '10kg/包', ''),
(10, '生鱼料', '10kg/包', '');

-- --------------------------------------------------------

--
-- 表的结构 `ap_feeding`
--

CREATE TABLE IF NOT EXISTS `ap_feeding` (
  `feeding_id` int(11) NOT NULL AUTO_INCREMENT,
  `feeding_pool_id` int(11) DEFAULT NULL,
  `feeding_cage_id` int(11) DEFAULT NULL,
  `feeding_feed_id` int(11) DEFAULT NULL,
  `feeding_number` varchar(30) NOT NULL DEFAULT '',
  `feeding_member_id` int(11) DEFAULT NULL,
  `feeding_time` varchar(20) NOT NULL DEFAULT '',
  `feeding_pool_img` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`feeding_id`),
  KEY `feeding_pool_id` (`feeding_pool_id`,`feeding_cage_id`,`feeding_feed_id`,`feeding_member_id`),
  KEY `feeding_cage_id` (`feeding_cage_id`),
  KEY `feeding_feed_id` (`feeding_feed_id`),
  KEY `feeding_member_id` (`feeding_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投饲' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ap_feeding`
--

INSERT INTO `ap_feeding` (`feeding_id`, `feeding_pool_id`, `feeding_cage_id`, `feeding_feed_id`, `feeding_number`, `feeding_member_id`, `feeding_time`, `feeding_pool_img`) VALUES
(1, 1, 1, 4, '100', 7, '2016-02-22 11:26', ''),
(2, 1, 2, 5, '100包', 7, '2016-02-22 10:59', ''),
(3, 1, 1, 1, '100包', 7, '2016-02-22 11:01', ''),
(4, 1, 1, 4, '123', 7, '2016-02-22 11:27', ''),
(5, 1, 1, 1, '26', 7, '2016-02-23 22:34', ''),
(8, 5, 1, 1, '32', 7, '2016-03-03', ''),
(9, 1, 1, 1, '12', 7, '2016-03-31', ''),
(10, 1, 7, 1, '20', 7, '2016-04-19', 'wechat_img/2016/04/19/2fa191046ee60e0e6dd3f821e412'),
(11, 1, 6, 1, '2', 7, '2016-04-19', 'wechat_img/2016/04/19/0bdc4b3837affa0a54c405e6213c');

-- --------------------------------------------------------

--
-- 表的结构 `ap_fry`
--

CREATE TABLE IF NOT EXISTS `ap_fry` (
  `fry_id` int(11) NOT NULL AUTO_INCREMENT,
  `fry_name` varchar(20) NOT NULL DEFAULT '',
  `fry_code` char(10) DEFAULT NULL COMMENT '编码',
  PRIMARY KEY (`fry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ap_fry`
--

INSERT INTO `ap_fry` (`fry_id`, `fry_name`, `fry_code`) VALUES
(1, '罗非鱼', '0122'),
(2, '鲫鱼', '0123'),
(3, '草鱼', '0124'),
(4, '海鲈', '0125');

-- --------------------------------------------------------

--
-- 表的结构 `ap_indicator`
--

CREATE TABLE IF NOT EXISTS `ap_indicator` (
  `indicator_id` int(11) NOT NULL AUTO_INCREMENT,
  `indicator_pool_id` int(11) DEFAULT '0',
  `indicator_cage_id` int(11) DEFAULT '0',
  `indicator_time` varchar(20) NOT NULL DEFAULT '',
  `indicator_weather` varchar(30) NOT NULL DEFAULT '',
  `indicator_name` varchar(20) NOT NULL DEFAULT '',
  `indicator_value` varchar(20) NOT NULL DEFAULT '',
  `indicator_unit` varchar(20) NOT NULL DEFAULT '',
  `indicator_member_id` int(11) DEFAULT '0',
  PRIMARY KEY (`indicator_id`),
  KEY `indicator_pool_id` (`indicator_pool_id`),
  KEY `indicator_cage_id` (`indicator_cage_id`),
  KEY `indicator_member_id` (`indicator_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ap_indicator`
--

INSERT INTO `ap_indicator` (`indicator_id`, `indicator_pool_id`, `indicator_cage_id`, `indicator_time`, `indicator_weather`, `indicator_name`, `indicator_value`, `indicator_unit`, `indicator_member_id`) VALUES
(1, 1, 2, '2016-03-11', '东南风', '风力', '5', '级', 7),
(2, 1, 13, '2016-03-30', '晴天，东南风', '风力', '3', '级', 7);

-- --------------------------------------------------------

--
-- 表的结构 `ap_medication`
--

CREATE TABLE IF NOT EXISTS `ap_medication` (
  `medication_id` int(11) NOT NULL AUTO_INCREMENT,
  `medication_medicine_id` int(11) DEFAULT '0',
  `medication_amount` varchar(20) NOT NULL DEFAULT '',
  `medication_pool_id` int(11) DEFAULT '0',
  `medication_cage_id` int(11) DEFAULT '0',
  `medication_time` varchar(20) NOT NULL DEFAULT '',
  `medication_reason` varchar(100) NOT NULL DEFAULT '',
  `medication_pattern` varchar(50) NOT NULL DEFAULT '',
  `medication_precautions` varchar(100) NOT NULL DEFAULT '',
  `medication_member_id` int(11) DEFAULT '0',
  PRIMARY KEY (`medication_id`),
  KEY `medication_medicine_id` (`medication_medicine_id`,`medication_pool_id`,`medication_cage_id`),
  KEY `medication_pool_id` (`medication_pool_id`),
  KEY `medication_cage_id` (`medication_cage_id`),
  KEY `medication_member_id` (`medication_member_id`),
  KEY `medication_member_id_2` (`medication_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ap_medication`
--

INSERT INTO `ap_medication` (`medication_id`, `medication_medicine_id`, `medication_amount`, `medication_pool_id`, `medication_cage_id`, `medication_time`, `medication_reason`, `medication_pattern`, `medication_precautions`, `medication_member_id`) VALUES
(1, 1, '10瓶', 1, 1, '2016-03-30', '保健', '无', '无', 7),
(2, 1, 'test', 1, 6, '2016-02-29 13:24', 'test', 't', 't', 7),
(3, 3, '1袋', 5, 8, '2016-03-18', '保健', '无', '无', 7),
(4, 1, 'km', 1, 6, '1460652905', '258', 'ajtj', '255', 7),
(5, 1, '10', 1, 2, '2016-04-19', '生病', '水调', '无', 7),
(6, 1, '5', 1, 8, '2016-04-19', '', '', '', 7);

-- --------------------------------------------------------

--
-- 表的结构 `ap_medicine`
--

CREATE TABLE IF NOT EXISTS `ap_medicine` (
  `medicine_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(20) NOT NULL DEFAULT '',
  `medicine_use` varchar(50) NOT NULL DEFAULT '',
  `medicine_precautions` varchar(50) NOT NULL DEFAULT '',
  `medicine_code` char(10) NOT NULL DEFAULT '' COMMENT '编码 ',
  PRIMARY KEY (`medicine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ap_medicine`
--

INSERT INTO `ap_medicine` (`medicine_id`, `medicine_name`, `medicine_use`, `medicine_precautions`, `medicine_code`) VALUES
(1, '海联科103', '保健', '保健', '12'),
(2, '海联科3505', '保健', '', ''),
(3, '海联科维生素', '保健', '', ''),
(4, '蚌毒灵散\r\n', '保健', '', ''),
(5, '康力沙', '治疗', '', ''),
(6, '恩诺沙星', '治疗', '', ''),
(7, '氟苯尼考', '治疗', '', ''),
(8, '海联科101', '调水', '', ''),
(9, '海联科202', '调水', '', ''),
(10, '海联科206', '调水', '', ''),
(11, '海联科502', '抗应激', '', ''),
(12, '海联科池底安', '改底', '', ''),
(13, '海联科黑精灵', '调水', '', ''),
(14, '海联科粒粒氧', '增氧', '', ''),
(15, '海联科育藻膏', '肥水', '', ''),
(16, '海联科聚维酮碘溶液', '消毒', '', ''),
(17, '海联科二氧化氯', '消毒', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ap_member`
--

CREATE TABLE IF NOT EXISTS `ap_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_username` varchar(30) NOT NULL DEFAULT '',
  `member_password` varchar(55) NOT NULL DEFAULT '',
  `member_role` int(11) NOT NULL COMMENT '角色（1系统管理员2基础管理员3普通用户）',
  `member_base_id` int(11) DEFAULT '0',
  `member_pool_id` int(11) DEFAULT '0',
  `member_permission` int(11) NOT NULL COMMENT '权限控制',
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_username` (`member_username`),
  KEY `member_base_id` (`member_base_id`),
  KEY `member_pool_id` (`member_pool_id`),
  KEY `member_pool_id_2` (`member_pool_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `ap_member`
--

INSERT INTO `ap_member` (`member_id`, `member_username`, `member_password`, `member_role`, `member_base_id`, `member_pool_id`, `member_permission`) VALUES
(1, 'baseadmin', 'test', 2, 1, 0, 0),
(2, 'superadmin', '47aafdea08632dd73b61a81e5909ea25', 1, 0, 0, 0),
(3, 'user12', 'test', 3, 1, 2, 0),
(4, 'baseadmin2', 'test', 2, 2, 0, 0),
(7, 'user11', 'test', 3, 1, 1, 0),
(8, 'user26', 'test', 3, 2, 6, 0),
(10, 'superadmin1', '123', 2, 1, 0, 0),
(11, 'superadmin2', '123', 2, 1, 0, 0),
(15, 'superadmin111', 'a2309310628434a2bd8d675ee2bac467', 2, 1, 0, 1),
(17, 'user111', 'a06da7664146a0ccd23dbc0373ad3aaa', 3, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ap_patrol`
--

CREATE TABLE IF NOT EXISTS `ap_patrol` (
  `patrol_id` int(11) NOT NULL AUTO_INCREMENT,
  `patrol_pool_id` int(11) DEFAULT '0',
  `patrol_cage_id` int(11) DEFAULT '0',
  `patrol_fry_id` int(11) DEFAULT '0',
  `patrol_number` varchar(20) NOT NULL DEFAULT '',
  `patrol_weight` varchar(15) NOT NULL DEFAULT '',
  `patrol_death_reason` varchar(300) NOT NULL DEFAULT '',
  `patrol_death_date` varchar(20) NOT NULL DEFAULT '',
  `patrol_member_id` int(11) DEFAULT '0',
  `patrol_remark` varchar(400) NOT NULL DEFAULT '',
  `patrol_pool_img` varchar(100) NOT NULL DEFAULT '',
  `patrol_coordinate` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`patrol_id`),
  KEY `patrol_pool_id` (`patrol_pool_id`,`patrol_cage_id`,`patrol_fry_id`,`patrol_member_id`),
  KEY `patrol_member_id` (`patrol_member_id`),
  KEY `patrol_cage_id` (`patrol_cage_id`),
  KEY `patrol_fry_id` (`patrol_fry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `ap_patrol`
--

INSERT INTO `ap_patrol` (`patrol_id`, `patrol_pool_id`, `patrol_cage_id`, `patrol_fry_id`, `patrol_number`, `patrol_weight`, `patrol_death_reason`, `patrol_death_date`, `patrol_member_id`, `patrol_remark`, `patrol_pool_img`, `patrol_coordinate`) VALUES
(1, 1, 0, 2, '10', '5斤', '天气影响', '2016-02-23 22:34', 7, '无', '', ''),
(2, 1, 1, 1, '1', '1', '不明', '2016-03-18', 7, '无', '', ''),
(3, 0, 6, 1, '1', '1', '22', '2016-03-31', 7, '', '', ''),
(4, 1, 0, 3, '562', '565', 'no', '2016-04-15', 7, ' 563', '', '65'),
(6, 1, 8, 3, '23', '12', '天气', '2016-04-19', 7, ' 无', 'wechat_img/2016/04/19/659dbc7a3330d74761cafdeb9b7a0a2d.jpg', '40.0'),
(7, 1, 11, 1, '5', '5', '无', '2016-04-19', 7, ' ', 'wechat_img/2016/04/19/e44dfb5819f2c60f965ade9407bd8e64.jpg', '40.0');

-- --------------------------------------------------------

--
-- 表的结构 `ap_pool`
--

CREATE TABLE IF NOT EXISTS `ap_pool` (
  `pool_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '池塘编号',
  `pool_name` varchar(20) NOT NULL DEFAULT '' COMMENT '池塘名称',
  `pool_base_id` int(11) DEFAULT NULL COMMENT '池塘所属基地编号',
  `pool_addr` varchar(50) NOT NULL DEFAULT '' COMMENT '池塘地址',
  `pool_area` varchar(20) NOT NULL DEFAULT '' COMMENT '池塘水面面积',
  `pool_depth` varchar(20) NOT NULL DEFAULT '' COMMENT '池塘水深',
  `pool_equipment` varchar(30) NOT NULL DEFAULT '' COMMENT '养殖所用设备设施',
  `pool_model` varchar(30) NOT NULL DEFAULT '' COMMENT '养殖模式',
  `pool_coordinate` varchar(20) NOT NULL DEFAULT '',
  `pool_time` varchar(20) NOT NULL DEFAULT '',
  `pool_smart_id` int(11) NOT NULL,
  `pool_code` char(5) DEFAULT NULL COMMENT '池塘编码',
  PRIMARY KEY (`pool_id`),
  KEY `pool_base_id` (`pool_base_id`),
  KEY `pool_addr` (`pool_addr`),
  KEY `pool_base_id_2` (`pool_base_id`),
  KEY `pool_base_id_3` (`pool_base_id`),
  KEY `pool_base_id_4` (`pool_base_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='池塘信息' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `ap_pool`
--

INSERT INTO `ap_pool` (`pool_id`, `pool_name`, `pool_base_id`, `pool_addr`, `pool_area`, `pool_depth`, `pool_equipment`, `pool_model`, `pool_coordinate`, `pool_time`, `pool_smart_id`, `pool_code`) VALUES
(1, '11号塘', 1, '11号塘地址', '1000平方米', '610米', '增氧机', '网箱', '123.123.12', '2016-02-06 21:13', 0, '123'),
(2, '14号塘', 2, '14号塘地址', '1000平方米', '300米', '增氧机', '网箱', '123.123.2', '2016-02-06 21:13', 0, NULL),
(3, '15号塘', 1, '15号塘地址', '500平方米', '200米', '增氧机', '网箱', '123.123.1', '2016-02-15 20:38', 0, '121'),
(14, '1', 1, '1', '1', '1', '1', '大塘混养', '1', '2016-06-02 14:55', 0, '1');

-- --------------------------------------------------------

--
-- 表的结构 `ap_record`
--

CREATE TABLE IF NOT EXISTS `ap_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_pool_id` int(11) DEFAULT '0',
  `record_cage_id` int(11) DEFAULT '0',
  `record_fry_id` int(11) DEFAULT '0',
  `record_transfer_pool_id` int(11) DEFAULT '0',
  `record_transfer_cage_id` int(11) DEFAULT '0',
  `record_member_id` int(11) DEFAULT '0',
  `record_batch` varchar(20) NOT NULL DEFAULT '',
  `record_number` varchar(20) NOT NULL DEFAULT '',
  `record_weight` varchar(20) NOT NULL DEFAULT '',
  `record_time` varchar(20) NOT NULL DEFAULT '',
  `record_type` varchar(20) NOT NULL DEFAULT '',
  `record_remark` varchar(200) NOT NULL DEFAULT '',
  `record_transfer_number` varchar(20) NOT NULL DEFAULT '',
  `record_transfer_weight` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`record_id`),
  KEY `record_pool_id` (`record_pool_id`),
  KEY `record_cage_id` (`record_cage_id`),
  KEY `record_fry_id` (`record_fry_id`),
  KEY `record_transfer_pool_id` (`record_transfer_pool_id`),
  KEY `record_transfer_cage_id` (`record_transfer_cage_id`),
  KEY `record_member_id` (`record_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ap_record`
--

INSERT INTO `ap_record` (`record_id`, `record_pool_id`, `record_cage_id`, `record_fry_id`, `record_transfer_pool_id`, `record_transfer_cage_id`, `record_member_id`, `record_batch`, `record_number`, `record_weight`, `record_time`, `record_type`, `record_remark`, `record_transfer_number`, `record_transfer_weight`) VALUES
(1, 1, 2, 3, 0, 0, 7, '第一批', '66524', '100斤', '3月4日', '销售', '备注test', '', ''),
(2, 1, 2, 2, 0, 0, 7, '第二批', '100条', '100斤', '16.3.3', '销售', 'test', '', ''),
(3, 1, 2, 2, 1, 6, 7, '3', '', '', '16.3.3', '转塘', 'test', '100条', '100斤');

-- --------------------------------------------------------

--
-- 表的结构 `ap_sale`
--

CREATE TABLE IF NOT EXISTS `ap_sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_record_id` int(11) DEFAULT '0',
  `sale_client_name` varchar(20) NOT NULL DEFAULT '',
  `sale_client_tel` varchar(20) NOT NULL DEFAULT '',
  `sale_fry_id` int(11) DEFAULT '0',
  `sale_number` varchar(20) NOT NULL DEFAULT '',
  `sale_weight` varchar(20) NOT NULL DEFAULT '',
  `sale_univalent` varchar(20) NOT NULL DEFAULT '',
  `sale_sales` varchar(20) NOT NULL DEFAULT '',
  `sale_member_id` int(11) DEFAULT '0',
  `sale_remark` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`sale_id`),
  KEY `sale_record_id` (`sale_record_id`),
  KEY `sale_fry_id` (`sale_fry_id`),
  KEY `sale_member_id` (`sale_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ap_sale`
--

INSERT INTO `ap_sale` (`sale_id`, `sale_record_id`, `sale_client_name`, `sale_client_tel`, `sale_fry_id`, `sale_number`, `sale_weight`, `sale_univalent`, `sale_sales`, `sale_member_id`, `sale_remark`) VALUES
(1, 1, '某农批市场', '612626', 3, '100条', '100斤', '1万', '1000万', 7, '备注test'),
(2, 1, '客户名称', '客户电话号码', 1, '数量', '重量', '单价', '销售金额', 7, '备注');

-- --------------------------------------------------------

--
-- 表的结构 `ap_stocking`
--

CREATE TABLE IF NOT EXISTS `ap_stocking` (
  `stocking_id` int(11) NOT NULL AUTO_INCREMENT,
  `stocking_batch` int(11) NOT NULL DEFAULT '0' COMMENT '批次',
  `stocking_cage_id` int(11) DEFAULT NULL,
  `stocking_fry_id` int(11) DEFAULT NULL,
  `stocking_number` int(11) NOT NULL DEFAULT '0',
  `stocking_specifications` varchar(30) NOT NULL DEFAULT '',
  `stocking_start_time` varchar(20) NOT NULL DEFAULT '',
  `stocking_finish_time` varchar(20) NOT NULL DEFAULT '',
  `stocking_member_id` int(11) DEFAULT '0',
  `stocking_remark` varchar(400) NOT NULL DEFAULT '',
  PRIMARY KEY (`stocking_id`),
  KEY `stocking_cage_id` (`stocking_cage_id`,`stocking_fry_id`),
  KEY `stocking_fry_id` (`stocking_fry_id`),
  KEY `stocking_member_id` (`stocking_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `ap_stocking`
--

INSERT INTO `ap_stocking` (`stocking_id`, `stocking_batch`, `stocking_cage_id`, `stocking_fry_id`, `stocking_number`, `stocking_specifications`, `stocking_start_time`, `stocking_finish_time`, `stocking_member_id`, `stocking_remark`) VALUES
(3, 1, 7, 1, 145, '1斤', '2016-02-23 22:30', '2016-02-23 22:30', 7, '无'),
(4, 2, 2, 2, 100, '1斤', '2016-03-11', '2016-03-17', 7, '无'),
(5, 3, 1, 1, 23, '12', ' 2016-02-20 15:53', ' 2016-02-20 15:53', 7, ' 2016-02-20 15:53'),
(6, 4, 1, 1, 100, '100', '2016-02-21 09:42', '2016-02-21 09:42', 7, 'test'),
(7, 5, 2, 1, 1232, '123', '2016-02-21 09:42', '2016-02-21 09:42', 7, 'test'),
(10, 6, 2, 2, 0, 't', 't', 't', 7, 't'),
(11, 0, 1, 1, 0, 't', 't', 't', 7, 'tt'),
(12, 123, 2, 1, 0, '', '', '', 7, ''),
(14, 33, 2, 1, 0, '', '', '', 7, ''),
(15, 22, 1, 1, 0, '', '', '', 7, ''),
(16, 23, 1, 1, 0, '', '', '', 7, ''),
(18, 24, 2, 1, 0, '', '', '', 7, ''),
(19, 3, 2, 2, 100, '100', '2016-03-07', '2016-03-25', 7, 'test'),
(20, 3, 2, 2, 100, '100', '2016-03-02', '2016-03-16', 7, 'test'),
(21, 3, 2, 2, 100, '100', '2016-03-02', '2016-03-16', 7, 'test'),
(22, 3, 6, 3, 100, '100', '2016-03-02', '2016-03-09', 7, 'test'),
(23, 0, NULL, 1, 0, '', '2016-03-08', '2016-03-23', 7, ''),
(24, 1111111, NULL, 1, 12, '1', '2016-03-31', '2016-03-31', 7, ''),
(25, 12, NULL, 3, 2, '12', '2016-07-14', '2016-07-15', 17, '1233'),
(26, 12, NULL, 2, 21, '1213', '2016-07-14', '2016-07-09', 17, '1235'),
(27, 45, NULL, 2, 45, '45', '2016-07-08', '2016-10-13', 17, '45'),
(28, 78, NULL, 2, 45, '23', '2016-07-14', '2016-07-15', 17, '123'),
(29, 233, NULL, 1, 233, '32', '', '2016-07-21', 17, '22333'),
(30, 234, NULL, 1, 234, '234', '', '2016-07-29', 17, '54789451'),
(31, 456, NULL, 2, 456, '456', '', '', 17, '456'),
(32, 555, NULL, 2, 546, '56', '', '', 17, '45645'),
(33, 666, NULL, 1, 666, '666', '2016-07-09', '2016-07-15', 17, '666');

-- --------------------------------------------------------

--
-- 表的结构 `ap_trace`
--

CREATE TABLE IF NOT EXISTS `ap_trace` (
  `trace_id` int(11) NOT NULL AUTO_INCREMENT,
  `trace_sale_id` int(11) DEFAULT '0',
  `trace_basename` varchar(20) NOT NULL DEFAULT '',
  `trace_pool_id` int(11) DEFAULT '0',
  `trace_fry_id` int(11) DEFAULT '0',
  `trace_member_id` int(11) DEFAULT '0',
  `trace_is_water` varchar(20) NOT NULL DEFAULT '',
  `trace_is_medicine` varchar(20) NOT NULL DEFAULT '',
  `trace_start_time` varchar(20) NOT NULL DEFAULT '',
  `trace_finish_time` varchar(20) NOT NULL DEFAULT '',
  `trace_client_name` varchar(20) NOT NULL DEFAULT '',
  `trace_tel` varchar(20) NOT NULL DEFAULT '',
  `trace_base_id` int(11) DEFAULT '0',
  PRIMARY KEY (`trace_id`),
  KEY `trace_sale_id` (`trace_sale_id`),
  KEY `trace_base_id` (`trace_basename`),
  KEY `trace_pool_id` (`trace_pool_id`),
  KEY `trace_fry_id` (`trace_fry_id`),
  KEY `trace_member_id` (`trace_member_id`),
  KEY `trace_base_id_2` (`trace_base_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ap_trace`
--

INSERT INTO `ap_trace` (`trace_id`, `trace_sale_id`, `trace_basename`, `trace_pool_id`, `trace_fry_id`, `trace_member_id`, `trace_is_water`, `trace_is_medicine`, `trace_start_time`, `trace_finish_time`, `trace_client_name`, `trace_tel`, `trace_base_id`) VALUES
(1, 1, '洪晓波', 1, 2, 7, '水质达标', '用药达标test', '2016-03-01', '2016-03-02', '洪晓峰', '726261', 1),
(2, 1, '洪晓凤', 1, 2, 7, '是', '是', '2016-03-04', '2016-03-06', '洪晓波', '123456', 1);

--
-- 限制导出的表
--

--
-- 限制表 `ap_cage`
--
ALTER TABLE `ap_cage`
  ADD CONSTRAINT `ap_cage_ibfk_1` FOREIGN KEY (`cage_pool_id`) REFERENCES `ap_pool` (`pool_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_feeding`
--
ALTER TABLE `ap_feeding`
  ADD CONSTRAINT `ap_feeding_ibfk_3` FOREIGN KEY (`feeding_feed_id`) REFERENCES `ap_feed` (`feed_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_feeding_ibfk_4` FOREIGN KEY (`feeding_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_indicator`
--
ALTER TABLE `ap_indicator`
  ADD CONSTRAINT `ap_indicator_ibfk_1` FOREIGN KEY (`indicator_pool_id`) REFERENCES `ap_pool` (`pool_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_indicator_ibfk_2` FOREIGN KEY (`indicator_cage_id`) REFERENCES `ap_cage` (`cage_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_indicator_ibfk_3` FOREIGN KEY (`indicator_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_medication`
--
ALTER TABLE `ap_medication`
  ADD CONSTRAINT `ap_medication_ibfk_1` FOREIGN KEY (`medication_medicine_id`) REFERENCES `ap_medicine` (`medicine_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_medication_ibfk_4` FOREIGN KEY (`medication_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_patrol`
--
ALTER TABLE `ap_patrol`
  ADD CONSTRAINT `ap_patrol_ibfk_3` FOREIGN KEY (`patrol_fry_id`) REFERENCES `ap_fry` (`fry_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_patrol_ibfk_4` FOREIGN KEY (`patrol_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_pool`
--
ALTER TABLE `ap_pool`
  ADD CONSTRAINT `ap_pool_ibfk_2` FOREIGN KEY (`pool_base_id`) REFERENCES `ap_base` (`base_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_record`
--
ALTER TABLE `ap_record`
  ADD CONSTRAINT `ap_record_ibfk_1` FOREIGN KEY (`record_pool_id`) REFERENCES `ap_pool` (`pool_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_record_ibfk_2` FOREIGN KEY (`record_cage_id`) REFERENCES `ap_cage` (`cage_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_record_ibfk_3` FOREIGN KEY (`record_fry_id`) REFERENCES `ap_fry` (`fry_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_record_ibfk_6` FOREIGN KEY (`record_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_sale`
--
ALTER TABLE `ap_sale`
  ADD CONSTRAINT `ap_sale_ibfk_1` FOREIGN KEY (`sale_record_id`) REFERENCES `ap_record` (`record_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_sale_ibfk_2` FOREIGN KEY (`sale_fry_id`) REFERENCES `ap_fry` (`fry_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_sale_ibfk_3` FOREIGN KEY (`sale_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_stocking`
--
ALTER TABLE `ap_stocking`
  ADD CONSTRAINT `ap_stocking_ibfk_1` FOREIGN KEY (`stocking_cage_id`) REFERENCES `ap_cage` (`cage_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_stocking_ibfk_2` FOREIGN KEY (`stocking_fry_id`) REFERENCES `ap_fry` (`fry_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_stocking_ibfk_3` FOREIGN KEY (`stocking_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ap_trace`
--
ALTER TABLE `ap_trace`
  ADD CONSTRAINT `ap_trace_ibfk_1` FOREIGN KEY (`trace_sale_id`) REFERENCES `ap_sale` (`sale_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_trace_ibfk_3` FOREIGN KEY (`trace_pool_id`) REFERENCES `ap_pool` (`pool_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_trace_ibfk_4` FOREIGN KEY (`trace_fry_id`) REFERENCES `ap_fry` (`fry_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_trace_ibfk_5` FOREIGN KEY (`trace_member_id`) REFERENCES `ap_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ap_trace_ibfk_6` FOREIGN KEY (`trace_base_id`) REFERENCES `ap_base` (`base_id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
