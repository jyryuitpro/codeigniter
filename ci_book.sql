-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 21-01-08 07:18
-- 서버 버전: 10.4.17-MariaDB
-- PHP 버전: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `ci_book`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `ci_board`
--

CREATE TABLE `ci_board` (
  `board_id` int(10) NOT NULL,
  `board_pid` int(10) NOT NULL DEFAULT 0 COMMENT '원글번호',
  `user_id` varchar(20) NOT NULL COMMENT '작성자ID',
  `user_name` varchar(20) NOT NULL COMMENT '작성자이름',
  `subject` varchar(50) NOT NULL COMMENT '게시글제목',
  `contents` text NOT NULL COMMENT '게시글내용',
  `hits` int(10) NOT NULL DEFAULT 0 COMMENT '조회수',
  `reg_date` datetime NOT NULL COMMENT '등록일'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='CodeIgniter 게시판';

--
-- 테이블의 덤프 데이터 `ci_board`
--

INSERT INTO `ci_board` (`board_id`, `board_pid`, `user_id`, `user_name`, `subject`, `contents`, `hits`, `reg_date`) VALUES
(1, 0, 'jy.ryu.itpro', '류지영', '첫번째 글입니다.', '첫번째글이네요.', 5, '2021-01-05 17:23:01'),
(2, 0, 'jy.ryu.itpro', '류지영', '두번째 글입니다.', '두번째글이네요.', 1, '2021-01-05 17:24:01'),
(3, 0, 'jy.ryu.itpro', '류지영', '세번째 글입니다.', '세번째글이네요.', 1, '2021-01-05 17:24:01'),
(4, 0, 'jy.ryu.itpro', '류지영', '네번째 글입니다.', '네번째글이네요.', 6, '2021-01-05 17:24:01'),
(5, 0, 'jy.ryu.itpro', '류지영', '다섯번째 글입니다.', '다섯번째글이네요.', 4, '2021-01-05 17:24:01'),
(8, 0, 'jy.ryu.itpro', '류지영', '여덞번째 글입니다.', '여덞번째글이네요.', 13, '2021-01-05 17:24:01'),
(9, 0, 'jy.ryu.itpro', '류지영', '아홉번째 글입니다.', '아홉번째글이네요.', 15, '2021-01-05 17:24:01'),
(10, 0, 'jy.ryu.itpro', '류지영', '열번째 글입니다.', '열번째글이네요.', 14, '2021-01-05 17:24:01'),
(11, 1, 'mufin', '머핀', '첫번째 글의 첫번째 댓글입니다.', '첫번째 댓글이네요.', 2, '2021-01-05 17:26:01'),
(12, 1, 'mufin', '머핀', '첫번째 글의 두번째 댓글입니다.', '두번째 댓글이네요.', 1, '2021-01-05 17:27:01'),
(13, 2, 'mufin', '머핀', '두번째 글의 첫번째 댓글입니다.', '두번째 글의 첫번째 댓글이네요.', 10, '2021-01-05 17:29:01'),
(27, 0, 'advisor', '류지영', '열한번째 글입니다.', '열한번째글이네요.', 0, '2021-01-08 06:48:00');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `ci_board`
--
ALTER TABLE `ci_board`
  ADD PRIMARY KEY (`board_id`),
  ADD KEY `board_pid` (`board_pid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `ci_board`
--
ALTER TABLE `ci_board`
  MODIFY `board_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
