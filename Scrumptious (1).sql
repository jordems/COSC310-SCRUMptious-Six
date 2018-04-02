-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2018 at 03:38 PM
-- Server version: 5.6.39-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Scrumptious`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE IF NOT EXISTS `Account` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `balance` decimal(20,2) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `financialinstitution` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`aid`, `uid`, `balance`, `title`, `financialinstitution`, `type`) VALUES
(5, 9, '1000.00', 'Live Savings', 'CIBC', 'Savings Account'),
(6, 10, '2000.00', 'Life Earnings', 'CIBC', 'Savings Account'),
(7, 11, '5000000.00', 'Bank1', 'RBC', 'Savings Account'),
(10, 12, '0.00', '', 'RBC', 'Checking Account'),
(11, 12, '10000.00', 'hi', 'CIBC', 'Savings Account'),
(12, 15, '2000.00', 'My First Account', 'BMO', 'Chequing Account'),
(16, 14, '100.00', 'NewKid&#39;s Account', 'CIBC', 'RESP Account'),
(17, 2, '2016.88', 'Savings of Lives', 'RBC', 'Savings Account'),
(19, 10, '10017.12', 'Levi&#39;s Account', 'BMO', 'Chequing Account'),
(20, 2, '123.00', 'Tester', 'RBC', 'Savings Account'),
(21, 7, '12.00', 'Jame&#39;s Account', 'RBC', 'Savings Account'),
(22, 7, '12.00', 'Jame&#39;s Account', 'RBC', 'Savings Account');

-- --------------------------------------------------------

--
-- Table structure for table `AccountTransaction`
--

CREATE TABLE IF NOT EXISTS `AccountTransaction` (
  `tid` char(64) NOT NULL,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `statementName` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AccountTransaction`
--

INSERT INTO `AccountTransaction` (`tid`, `uid`, `aid`, `date`, `amount`, `desc`, `statementName`) VALUES
('020ed1b183fc7e272d7bb3ac517a1e81d0d8d1b8edf5254e6fdaa57a1bf5131f', 10, 19, '2018-03-03', '1214.00', 'Misc', 'Levi&#39;s Statement'),
('0c8b412da71efcd79bf0ad48e99b6ece6cc729f1015bf4d3b067f48cc2b47d4d', 9, 5, '2014-02-06', '5980.50', 'Sales', 'Sept 2017'),
('1443c86c35f358aa03595fe2144a9ebafc29e0d6e7732946d954b401c6c3d1d2', 10, 6, '2017-01-04', '-100.00', 'Insurance', 'Jan 2018'),
('14af0503a8fa6995be2f1de3d1075d39c6a83e8b3b2ae1fb4965a95343e071d4', 10, 19, '2018-02-22', '510.00', 'Entertainment', 'Levi&#39;s Statement'),
('1c0f7f042fe64f78bddbe65f2a762bfa49d5b1d0a31a49954f2413b91822ed8b', 10, 19, '2018-03-14', '-598.00', 'Education', 'Levi&#39;s Statement'),
('2bc211124084af75cab876bbd53efdbf76306c9cec11ab7e2fd2e8ef5833177d', 2, 17, '2018-02-22', '510.00', 'Entertainment', 'March 2018'),
('2bc6251a8536229a915680deebbddbbe72b5c3e7d1839b58cab7d7b0203ae34e', 10, 6, '2017-01-17', '-100.00', 'Expense Repayment', 'Jan 2018'),
('2ccacd5ba0b5d93852c59f21620ba5ddcb4ea13dccd71db2d72121dfe3232f25', 14, 16, '2018-01-04', '-400.00', 'Insurance', 'dfasdf'),
('38b721c6bbc71ebdc3adc030e1ab17eb547daa181b4af8d8686b30203d8d9bc0', 14, 16, '2018-01-17', '-100.00', 'Bill', 'dfasdf'),
('3fdc4b178e5ed73c196f712b209438f61c92c5e825e7b641af5cd310598257e3', 14, 16, '2018-03-19', '250.00', 'Other', 'dfasdf'),
('427b73f762402a10f41246403b96722f787e27fda324de306637db4215100a18', 10, 19, '2018-01-17', '-100.00', 'Bill', 'Levi&#39;s Statement'),
('49d0ad4c4024fdddd1503dcc4778e859d27154d39282253df08088c16b29ed9e', 10, 6, '2018-02-15', '1020.00', 'Bill', 'Jan 2018'),
('49e7f4cb1b369887fe9a8149cb1615a06f77b9c2e642de4f8273a0e90a29702f', 9, 5, '2018-01-03', '3560.00', 'Sales', 'Sept 2017'),
('4cf9478f6635fa6fb10152614e7af122353cf4e0ea10ac8083eb5114a4a7daa5', 9, 5, '2017-11-02', '1056.00', 'Sales', 'Sept 2017'),
('4e544db01f04aeb7ca2784a899e39b55f2d0fd9397d9b48312388078cf49cb1e', 9, 5, '2018-01-28', '-650.00', 'Bill', 'Sept 2017'),
('51d65993ef59c71811eaaa18d79923a33b70f21eb62d3efb2daca4ba7e873da3', 2, 17, '2018-03-14', '-598.00', 'Education', 'March 2018'),
('58a727be0a767103a6ef61a2a0beab3dab2efa21ca2e62180e8cb38343fbe233', 14, 16, '2018-03-14', '-598.00', 'Education', 'dfasdf'),
('5b6e80e241d1b64d6557bff467539f8ad1c2cb5ecfe414366edd1378e79430a0', 9, 5, '2017-07-22', '240.00', 'Local Council', 'Sept 2017'),
('5ed9b2207d77f124d70084a88e1672cb737d11dd5a991b4a271ec78f67daba75', 10, 6, '2018-01-28', '-650.00', 'Bill', 'Jan 2018'),
('5f596fc9b0282e1c54d649b7318adabb5bbe0ba8c8db33f48a401f1a4a50cab8', 2, 17, '2018-01-04', '-400.00', 'Insurance', 'March 2018'),
('6b52c3eab4650412de5a3b5bd8e9dd8e7f26c5aa3330ae9a036548e8fdd8f903', 14, 16, '2018-03-11', '-320.00', 'Bill', 'dfasdf'),
('6c51430e68494e78a7801b20da9fa6673c36484d40ed451f575b248c5e9420e0', 2, 17, '2018-01-17', '-100.00', 'Bill', 'March 2018'),
('746fefa2fd9118ca225e3fd2b9fef32517cc4fc15aa4312cf6cf0c21ecd85277', 9, 5, '2017-01-17', '-100.00', 'Expense Repayment', 'Sept 2017'),
('7d7aade0ea49e4e0f21fdbaba6c287b117cba2990d8915c0c57c7c8d9c2f7cf0', 9, 5, '2017-01-04', '-100.00', 'Insurance', 'Sept 2017'),
('855d4461139b1c3e1138af3e88e66bdd12b177f3deca7b78145d4e11d260a862', 10, 19, '2018-01-04', '-400.00', 'Insurance', 'Levi&#39;s Statement'),
('86d9997b95c568d72e1db746434e38a4ce2a8a8388a1269be10c967d80ddb09e', 2, 17, '2018-03-11', '-320.00', 'Bill', 'March 2018'),
('8da8e995ea4213b22c17fd77ec0ff85975ff5610b5ed447fa1716c4e4f9b4977', 10, 19, '2018-03-19', '250.00', 'Other', 'Levi&#39;s Statement'),
('9297265b217c368faac32a926c14df7a31a75313a4db533a85845db7b237b785', 14, 16, '2018-02-22', '510.00', 'Entertainment', 'dfasdf'),
('a2515f4904ed8ce1618163562507bf81b75726b525190364fd6ce7478cb8b027', 10, 6, '2017-07-22', '240.00', 'Local Council', 'Jan 2018'),
('a3f822309396a3137dd9cd38886383cadda4824c547c50acd802c0c8f2c68217', 10, 19, '2018-02-25', '200.00', 'Food', 'Levi&#39;s Statement'),
('a663444f7f0a0e5adb9a1ad396adfdba99725db054fe366167373e0a8d5ae29b', 2, 17, '2018-03-03', '1214.00', 'Misc', 'March 2018'),
('aa557bd89ed1fdef539040809971c621936e0b7e5494c0990a17ca6da8a77d7d', 10, 6, '2018-01-03', '3560.00', 'Sales', 'Jan 2018'),
('c21d44f4c64067227fa11719ba87f96570871ecaf7ab4ed9eee31fb4859d9144', 2, 17, '2018-02-25', '200.00', 'Food', 'March 2018'),
('de25c378f8abe1089e97544723f7a076b21c9321781576ab5fde1137ebc87b19', 2, 17, '2018-03-19', '250.00', 'Other', 'March 2018'),
('e0a0c796197a6df9cc0ef17d906153511bf497a1be25891d74f3a041c174d00a', 14, 16, '2018-02-25', '200.00', 'Food', 'dfasdf'),
('e2ee065fcae58de034966e37529d56d56ae51fa379dddae36fd773608cab0f44', 10, 6, '2014-02-06', '5980.50', 'Sales', 'Jan 2018'),
('e6c51d5f4dd423e44a0caa8c21196cffb5c95771e8e52a4e7363c980d5331334', 14, 16, '2018-03-03', '1214.00', 'Misc', 'dfasdf'),
('fcfaa95f0388f427c018fed81cb101ad8e45065cec1e7f44bf4c11a933bf0b8b', 10, 19, '2018-03-11', '-320.00', 'Bill', 'Levi&#39;s Statement'),
('fdf6483ffda41a703163691a3912595f320e18237be465ad5e0031242d03220a', 10, 6, '2017-11-02', '1056.00', 'Sales', 'Jan 2018'),
('ff5fdea13fd556df573ab8d84cb31b028c674bb3be82e1dda63cced887427b96', 9, 5, '2018-02-15', '1020.00', 'Bill', 'Sept 2017');

-- --------------------------------------------------------

--
-- Table structure for table `forgot`
--

CREATE TABLE IF NOT EXISTS `forgot` (
  `uid` int(11) NOT NULL,
  `code` char(10) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `browserString` char(10) DEFAULT NULL,
  PRIMARY KEY (`uid`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forgot`
--

INSERT INTO `forgot` (`uid`, `code`, `timeStamp`, `browserString`) VALUES
(7, '14b79ff62b', '2018-03-02 19:48:51', NULL),
(7, '4584c61950', '2018-03-03 21:56:47', 'f3d56e8977'),
(7, '49c7301d4e', '2018-03-02 20:00:25', '6f3e33f6be'),
(7, '540308ebd3', '2018-03-02 20:27:32', NULL),
(7, 'c5e6b29a6e', '2018-03-02 02:31:48', 'a875508230'),
(7, 'c67f3865df', '2018-03-02 19:56:54', '52404a95a3'),
(7, 'd87afdf500', '2018-03-02 20:30:18', 'aa2a3f2981'),
(7, 'd9b2146fc9', '2018-03-04 04:40:31', 'ba723e0f66');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `compid` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  PRIMARY KEY (`compid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`compid`, `time`) VALUES
(1, '1519084783'),
(2, '1519431466'),
(7, '1519956483'),
(14, '1521568555');

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE IF NOT EXISTS `Transaction` (
  `tid` char(64) NOT NULL,
  `fromid` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `reason` varchar(50) NOT NULL DEFAULT 'Unknown',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `fromid` (`fromid`),
  KEY `toid` (`toid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Transaction`
--

INSERT INTO `Transaction` (`tid`, `fromid`, `toid`, `reason`, `datetime`, `amount`) VALUES
('0ee248c2261ea8010f5f7081bf8b8891bb85fa05d5066f5d7e4bbe5806f4f1a7', 17, 19, 'Testing', '2018-03-27 04:43:34', '5.00'),
('a5665223b14d685c67f61a4e9b9b440c6672af01c8f67c10f722c2e16eeddb0c', 17, 19, 'Testing', '2018-03-27 04:44:26', '12.12');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `billingAddress` varchar(255) NOT NULL,
  `mainAcc` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`uid`, `username`, `password`, `email`, `firstName`, `lastName`, `billingAddress`, `mainAcc`) VALUES
(1, 'test_user', '$2y$10$IrzYJi10j3Jy/K6jzSLQtOLif1wEZqTRQoK3DcS3jdnFEhL4fWM4G', 'test@example.com', 'abc', 'abc', 'abc', NULL),
(2, 'jordems', '$2y$10$LTNltZnZPpgsL4ddvUP.fu38XiY8QV/4G7kF61ezkdCkdEbxWuZVi', 'jordems@asd.com.com', 'Jorda', 'ems', '123 Abicla', 17),
(4, 'Jenny', '$2y$10$0ZDFQZcSj.c5Wst2wAQqEOZZlGRL2GdBh0R7l.UuhKRoUCU/AIee6', 'jennygoer@gmasd.com', 'jenny', 'jackson', '12 asdjasd', NULL),
(5, 'JoeBobthe3rd', '$2y$10$reP6ixQvPvlJdTdv53RyWOyVvlL.VrqUWIHfGMNpLQw.3kAisOAhq', 'Iambob@gmail.com', 'Joe', 'Bob', '123 Bob Street', NULL),
(6, 'Levi', '$2y$10$OV/BxEdIm19TLmKTbl9hNevm6xUAJ6J2FGdqQ4mjmTRHOMZ0jiOuq', 'jkshfskdhfl@gmail.com', 'Levi', 'Joe', 'sdlkfsdlkjfldsjflkdsjf', NULL),
(7, 'james', '$2y$10$2rv4Ukcief0C6fLzMxhEBORNZayUdOMYCTo/bBBAHvAyB8X3cQH9C', 'jordems@hotmail.com', 'James', 'Johnson', '123 test st', NULL),
(8, 'user', '$2y$10$Bs8FPHMnqeBI.0zNsOBmmOr9XxxDW7vw1FM3vM6hbz0ZhZQOi2EHe', 'jamsd@asd.com', 'user', 'test', '123 sd', NULL),
(9, 'Tester', '$2y$10$ntpnQxXlJGqsuwpvug2ImusJoDLUJ9DKPYoCqS6zKeTqQkT4YXzEW', 'test@test.com', 'Test', 'Test', 'Test Road', NULL),
(10, 'mlevi15', '$2y$10$1YYxRqik5eSIBvjz0uWDsOpr80cIRtZGkcxGroi5IWnKC87sbz4yG', 'levi@levi.com', 'Levi', 'M', 'Rocky Road ', 19),
(11, 'Daniel', '$2y$10$PZgoD.QHSVS7xmc7y15oO.5hrdAH5xvEP5XPvcb7qPx93qiGh75gW', 'danielk.eamun@gmail.com', 'Daniel', 'Kandie', 'Kelowna BC', 7),
(12, 'hans12345', '$2y$10$ae8w2hEoL6SgNy3EMSwafuMgx3Fep.JRrEit.uJqhkZ1emj0vW576', 'hans@hotmail.com', 'hi', 'hello', 'kelowna', 11),
(13, 'toughguy', '$2y$10$SK7gu.c13jhW1EmYfI/C2OvuMMy6ccleyr8o2CMIW7lVW9kw/Hy0y', 'toughguy@gmail.com', 'Tough', 'Guy', '481 Tough Street', NULL),
(14, 'NewKid', '$2y$10$QhXyha1.vMZSsrHtlteYnuRt6PMfIf5SL/9drdRGBWZraqLybcpjK', 'newkid@hotmail.com', 'New', 'Kid', '239 New Lane', NULL),
(15, 'Ugh', '$2y$10$33Lh4EsOM/ca9e12bcNisedJEM2okmEV0VROopKS/MCjPIR64VGoC', 'ugh@shaw.ca', 'Ugh', 'Ugh', '111 Ugh Ugh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Wallet`
--

CREATE TABLE IF NOT EXISTS `Wallet` (
  `wid` int(11) NOT NULL,
  `balance` decimal(20,2) DEFAULT NULL,
  `isFrozen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Wallet`
--

INSERT INTO `Wallet` (`wid`, `balance`, `isFrozen`) VALUES
(1, '500.00', 0),
(2, '135.53', 0),
(4, '500.00', 0),
(5, '500.00', 0),
(6, '500.00', 0),
(7, '700.24', 0),
(8, '0.00', 0),
(9, '10.00', 0),
(10, '154.23', 0),
(11, '0.00', 0),
(12, '0.00', 0),
(13, '0.00', 0),
(14, '0.00', 0),
(15, '0.00', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Account`
--
ALTER TABLE `Account`
  ADD CONSTRAINT `Account_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `Users` (`uid`);

--
-- Constraints for table `AccountTransaction`
--
ALTER TABLE `AccountTransaction`
  ADD CONSTRAINT `AccountTransaction_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `Users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `AccountTransaction_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Account` (`aid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forgot`
--
ALTER TABLE `forgot`
  ADD CONSTRAINT `forgot_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `Users` (`uid`);

--
-- Constraints for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD CONSTRAINT `Transaction_ibfk_1` FOREIGN KEY (`fromid`) REFERENCES `Account` (`aid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`toid`) REFERENCES `Account` (`aid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Wallet`
--
ALTER TABLE `Wallet`
  ADD CONSTRAINT `Wallet_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `Users` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
