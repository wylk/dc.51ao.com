-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 06 月 30 日 15:00
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
-- 表的结构 `hd_company`
--

CREATE TABLE IF NOT EXISTS `hd_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `company_name` varchar(55) NOT NULL COMMENT '��˾����',
  `company_address` varchar(255) NOT NULL COMMENT '��˾��ַ',
  `company_person` varchar(55) NOT NULL COMMENT '��˾����',
  `licence` varchar(55) NOT NULL COMMENT 'Ӫҵִ�պ���',
  `cart_number` varchar(55) NOT NULL COMMENT '���֤����',
  `licence_path` varchar(255) NOT NULL,
  `frontal_view` varchar(255) NOT NULL COMMENT '���֤������',
  `back_view` varchar(255) NOT NULL COMMENT '���֤������',
  `phone` char(11) NOT NULL COMMENT '�ֻ�����',
  `password` char(32) NOT NULL COMMENT '登录密码',
  `email` varchar(55) NOT NULL COMMENT '电子邮箱',
  `addtime` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  `status` tinyint(3) unsigned NOT NULL COMMENT '状态值 默认0 通过1 不通过2',
  `reason` varchar(255) NOT NULL COMMENT '驳回原因',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hd_company_company_name` (`company_name`),
  KEY `hd_company_phone` (`phone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='��˾��' AUTO_INCREMENT=85 ;

--
-- 转存表中的数据 `hd_company`
--

INSERT INTO `hd_company` (`id`, `company_name`, `company_address`, `company_person`, `licence`, `cart_number`, `licence_path`, `frontal_view`, `back_view`, `phone`, `password`, `email`, `addtime`, `status`, `reason`) VALUES
(83, '北京五一乐卡科技有限公司', '北京海淀区苏州街银丰大厦3楼纳什空间', '人人陆', '1111111', '412627199809090909', './uploadfile/images/18811480487/20170630143320_103.jpg', './uploadfile/images/18811480487/20170630143320_994.jpg', './uploadfile/images/18811480487/20170630143320_216.jpg', '18811480487', '96e79218965eb72c92a549dd5a330112', '760553350@qq.com', 1498632860, 2, ''),
(84, '北京五一乐卡科技', '北京海淀区苏州街银丰大厦3楼', 'luwen', '1111111', '412627199809090909', './uploadfile/images/15651117501/20170628164115_623.jpg', './uploadfile/images/15651117501/20170628164115_352.jpg', './uploadfile/images/15651117501/20170628164115_619.jpg', '15651117501', '96e79218965eb72c92a549dd5a330112', '760553350@qq.com', 1498639275, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
