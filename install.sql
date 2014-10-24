SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

CREATE TABLE IF NOT EXISTS `ac_sign` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user` tinytext COLLATE utf8_unicode_ci NOT NULL,
	`lastSign` date NOT NULL,
	`auth_key` int(11) NOT NULL,
	`auth_sha1` int(11) NOT NULL,
	`disabled` TINYINT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
