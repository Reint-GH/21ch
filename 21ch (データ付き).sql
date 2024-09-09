-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-09-09 04:58:51
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `21ch`
--
CREATE DATABASE IF NOT EXISTS `21ch` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `21ch`;

-- --------------------------------------------------------

--
-- テーブルの構造 `chat`
--

CREATE TABLE `chat` (
  `ID` int(11) NOT NULL,
  `name` char(11) NOT NULL,
  `user` char(11) NOT NULL,
  `password` char(11) NOT NULL,
  `dbname` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `TEXT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `chat`
--

INSERT INTO `chat` (`ID`, `name`, `user`, `password`, `dbname`, `time`, `TEXT`) VALUES
(30, '達人', '', '', 9, '2024-09-09 11:30:10', 'aaa'),
(31, 'aaa', '', '', 9, '2024-09-09 11:30:16', 'aaa'),
(32, 'aa', '', '', 9, '2024-09-09 11:30:20', 'ss'),
(33, 'dd', '', '', 9, '2024-09-09 11:30:28', 'ss'),
(46, 'fsa', '', '', 9, '2024-09-09 11:41:21', 'fa'),
(47, 'fa', '', '', 9, '2024-09-09 11:41:23', 'fa'),
(48, 'fa', '', '', 9, '2024-09-09 11:41:24', 'fa'),
(49, 'fa', '', '', 9, '2024-09-09 11:41:24', 'fa'),
(50, 'fa', '', '', 9, '2024-09-09 11:41:25', 'fa'),
(51, 'fa', '', '', 9, '2024-09-09 11:41:25', 'fa'),
(52, 'fa', '', '', 9, '2024-09-09 11:41:25', 'fa'),
(53, 'fa', '', '', 9, '2024-09-09 11:41:25', 'fa'),
(54, 'fa', '', '', 9, '2024-09-09 11:41:26', 'fa'),
(55, 'fa', '', '', 9, '2024-09-09 11:41:26', 'fa'),
(56, 'fa', '', '', 9, '2024-09-09 11:41:26', 'fa'),
(57, 'fa', '', '', 9, '2024-09-09 11:41:26', 'fa'),
(58, 'fa', '', '', 9, '2024-09-09 11:41:26', 'fa'),
(59, 'fa', '', '', 9, '2024-09-09 11:41:37', 'fa'),
(60, 'fa', '', '', 9, '2024-09-09 11:42:04', 'fa'),
(61, 'fa', '', '', 9, '2024-09-09 11:42:19', 'fa');

-- --------------------------------------------------------

--
-- テーブルの構造 `chat_table`
--

CREATE TABLE `chat_table` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `chat_table`
--

INSERT INTO `chat_table` (`topic_id`, `topic_name`) VALUES
(7, 'ワイ、ガラス瓶を1000本割るwww'),
(8, '幽玄ノ乱ムズイ...'),
(9, '役満とれるまで寝れません！！をやってみた結果'),
(10, 'バルス祭りを開催してみたwww(オンラインで)'),
(11, 'デデドン(絶望)'),
(12, 'ダンス'),
(13, 'da');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- テーブルのインデックス `chat_table`
--
ALTER TABLE `chat_table`
  ADD PRIMARY KEY (`topic_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `chat`
--
ALTER TABLE `chat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- テーブルの AUTO_INCREMENT `chat_table`
--
ALTER TABLE `chat_table`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
