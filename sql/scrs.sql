-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 06 月 30 日 13:10
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- 表的结构 `sc_collects`
--

CREATE TABLE IF NOT EXISTS `sc_collects` (
  `collect_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`collect_id`),
  UNIQUE KEY `collect_id` (`collect_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sc_collects`
--

INSERT INTO `sc_collects` (`collect_id`, `user_id`, `topic_id`, `item_id`, `team_id`, `score`) VALUES
(1, 2, 3, 4, 5, 6),
(2, 1, 1, 1, 1, 10),
(3, 1, 1, 2, 1, 5);

-- --------------------------------------------------------

--
-- 表的结构 `sc_items`
--

CREATE TABLE IF NOT EXISTS `sc_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `itemname` varchar(64) NOT NULL,
  `maxscore` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sc_items`
--

INSERT INTO `sc_items` (`item_id`, `topic_id`, `itemname`, `maxscore`, `comment`) VALUES
(1, 1, '评分项1', 10, '评分项1就是评分项1'),
(2, 1, '评分项2', 5, '评分项2就是评分项2你管那'),
(3, 2, '评分项4', 8, '评分项4就是评分项4'),
(4, 1, '你猜到底是啥', 20, '我就是告诉你评分标准的');

-- --------------------------------------------------------

--
-- 表的结构 `sc_teams`
--

CREATE TABLE IF NOT EXISTS `sc_teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `teamname` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sc_teams`
--

INSERT INTO `sc_teams` (`team_id`, `teamname`, `comment`, `topic_id`) VALUES
(1, '测试队伍1', '这尼玛就是测试队伍1', 1),
(2, '测试队伍2', '测试队伍2测试队伍2测试队伍2', 2),
(3, '测试队伍3', '测试队伍3测试队伍3测试队伍3', 1),
(4, '测试队伍4', '测试队伍4测试队伍4测试队伍4', 1),
(5, '测试队伍5', '测试队伍5测试队伍5测试队伍5测试队伍5', 2),
(6, '又一只队伍', '你猜都有啥', 2);

-- --------------------------------------------------------

--
-- 表的结构 `sc_topics`
--

CREATE TABLE IF NOT EXISTS `sc_topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topicname` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sc_topics`
--

INSERT INTO `sc_topics` (`topic_id`, `topicname`, `comment`) VALUES
(1, '测试题目1', '这就是尼玛是个测试题1'),
(2, '测试题目2', '这就是尼玛测试题目2'),
(3, '又一个测试题目', '注释一下');

-- --------------------------------------------------------

--
-- 表的结构 `sc_users`
--

CREATE TABLE IF NOT EXISTS `sc_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` smallint(4) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `sex` int(2) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sc_users`
--

INSERT INTO `sc_users` (`user_id`, `username`, `password`, `salt`, `isadmin`, `sex`, `realname`, `phone`, `comment`) VALUES
(1, 'test1', '5a105e8b9d40e1329780d62ea2265d8a', NULL, 0, NULL, 'Summer Zhang', NULL, ''),
(2, '1', '1', 1234, 0, 0, 'asd', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
