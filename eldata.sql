-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.2.8-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for eldercare
CREATE DATABASE IF NOT EXISTS `eldercare` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `eldercare`;

-- Dumping structure for table eldercare.care
CREATE TABLE IF NOT EXISTS `care` (
  `e_id` int(11) DEFAULT NULL,
  `k_id` int(11) DEFAULT NULL,
  KEY `FK__elder` (`e_id`),
  KEY `FK__keeper` (`k_id`),
  CONSTRAINT `FK__elder` FOREIGN KEY (`e_id`) REFERENCES `elder` (`e_id`),
  CONSTRAINT `FK__keeper` FOREIGN KEY (`k_id`) REFERENCES `keeper` (`k_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table eldercare.care: ~5 rows (approximately)
DELETE FROM `care`;
/*!40000 ALTER TABLE `care` DISABLE KEYS */;
INSERT INTO `care` (`e_id`, `k_id`) VALUES
	(3, 1),
	(1, 2),
	(5, 3),
	(4, 1),
	(2, 2);
/*!40000 ALTER TABLE `care` ENABLE KEYS */;

-- Dumping structure for table eldercare.device
CREATE TABLE IF NOT EXISTS `device` (
  `d_id` int(11) NOT NULL,
  `d_batt` int(11) DEFAULT NULL,
  `d_error` varchar(50) DEFAULT NULL,
  `d_state` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table eldercare.device: ~5 rows (approximately)
DELETE FROM `device`;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` (`d_id`, `d_batt`, `d_error`, `d_state`) VALUES
	(1, 99, NULL, 'detected'),
	(2, 85, NULL, 'normal'),
	(3, 85, NULL, 'normal'),
	(4, 95, NULL, 'detected'),
	(5, 75, NULL, 'detected');
/*!40000 ALTER TABLE `device` ENABLE KEYS */;

-- Dumping structure for table eldercare.elder
CREATE TABLE IF NOT EXISTS `elder` (
  `e_id` int(11) NOT NULL,
  `e_age` int(11) DEFAULT NULL,
  `e_addr` text DEFAULT NULL,
  `e_name` text DEFAULT NULL,
  PRIMARY KEY (`e_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table eldercare.elder: ~5 rows (approximately)
DELETE FROM `elder`;
/*!40000 ALTER TABLE `elder` DISABLE KEYS */;
INSERT INTO `elder` (`e_id`, `e_age`, `e_addr`, `e_name`) VALUES
	(1, 62, 'Bangkok', 'Scott'),
	(2, 75, 'Nonthaburi', 'Johnson'),
	(3, 81, 'Ayuthaya', 'Micheal'),
	(4, 85, 'Pratumthani', 'Prayut'),
	(5, 69, 'Nakorn Sawan', 'Wanna');
/*!40000 ALTER TABLE `elder` ENABLE KEYS */;

-- Dumping structure for table eldercare.keeper
CREATE TABLE IF NOT EXISTS `keeper` (
  `k_id` int(11) NOT NULL,
  `k_name` varchar(50) DEFAULT NULL,
  `k_age` int(11) DEFAULT NULL,
  `k_tel` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table eldercare.keeper: ~3 rows (approximately)
DELETE FROM `keeper`;
/*!40000 ALTER TABLE `keeper` DISABLE KEYS */;
INSERT INTO `keeper` (`k_id`, `k_name`, `k_age`, `k_tel`) VALUES
	(1, 'Tanya', 35, '0854562158'),
	(2, 'Alex', 40, '0841258476'),
	(3, 'John', 37, '0845154783');
/*!40000 ALTER TABLE `keeper` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
