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
-- 表的结构 `hd_shop_type`
--

CREATE TABLE IF NOT EXISTS `hd_shop_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�ŵ�����id',
  `cid` int(10) unsigned NOT NULL COMMENT '公司',
  `typename` varchar(55) NOT NULL COMMENT '�ŵ���������',
  `type_img` varchar(255) NOT NULL COMMENT '�ŵ����͵�ͼ��',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='�ŵ����ͱ�' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `hd_shop_type`
--

INSERT INTO `hd_shop_type` (`id`, `cid`, `typename`, `type_img`, `create_time`) VALUES
(2, 83, '鲁菜', './uploadfile/images/18811480487/20170629115120_132.jpg', 1498708280),
(3, 83, '江湖菜', './uploadfile/images/18811480487/20170629142633_931.jpg', 1498714617),
(4, 83, '烤鸭', './uploadfile/images/18811480487/20170629152818_107.jpg', 1498721298);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
