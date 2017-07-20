-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 06 月 30 日 15:01
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `hd`
--

-- --------------------------------------------------------

--
-- 表的结构 `hd_employee`
--

CREATE TABLE IF NOT EXISTS `hd_employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Ա��id',
  `role_id` int(10) unsigned NOT NULL COMMENT '��ɫid',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id',
  `shop_id` int(10) unsigned NOT NULL COMMENT '����id',
  `username` varchar(55) NOT NULL COMMENT '��¼�˺�',
  `password` char(32) NOT NULL COMMENT '��¼����',
  `truename` varchar(55) NOT NULL COMMENT '��ʵ����',
  `phone` char(11) NOT NULL COMMENT '�ֻ�����',
  `email` varchar(55) NOT NULL COMMENT '��������',
  `status` tinyint(3) unsigned NOT NULL COMMENT '״̬',
  `remark` varchar(255) NOT NULL COMMENT '��ע',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hd_employee_username` (`username`),
  UNIQUE KEY `hd_employee_phone` (`phone`),
  UNIQUE KEY `hd_employee_email` (`email`),
  KEY `hd_employee_role_id` (`role_id`),
  KEY `hd_employee_shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Ա����' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `hd_employee`
--

INSERT INTO `hd_employee` (`id`, `role_id`, `company_id`, `shop_id`, `username`, `password`, `truename`, `phone`, `email`, `status`, `remark`, `create_time`) VALUES
(1, 0, 83, 3, 'admin', '96e79218965eb72c92a549dd5a330112', '66', '18811480487', '123@qq.com', 1, '撸起袖子加油干', 1498729284),
(8, 0, 83, 6, 'demo', '96e79218965eb72c92a549dd5a330112', '人人6', '18811480482', '1234@qq.com', 1, '好好干', 1498729662);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
