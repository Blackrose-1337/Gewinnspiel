SET
    NAMES utf8;

SET
    time_zone = '+00:00';

SET
    foreign_key_checks = 0;

SET
    sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET
    NAMES utf8mb4;

DROP TABLE IF EXISTS `Bewertung`;

CREATE TABLE `Bewertung` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `administrativeId` int(11) NOT NULL,
    `projectId` int(11) NOT NULL,
    `kriterienId` int(11) NOT NULL,
    `bewertung` int(11) NOT NULL,
    `finish` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `administrativeId` (`administrativeId`),
    KEY `userId` (`projectId`),
    KEY `kriterienId` (`kriterienId`),
    CONSTRAINT `Bewertung_ibfk_3` FOREIGN KEY (`administrativeId`) REFERENCES `User` (`id`),
    CONSTRAINT `Bewertung_ibfk_6` FOREIGN KEY (`kriterienId`) REFERENCES `Kriterien` (`id`),
    CONSTRAINT `Bewertung_ibfk_8` FOREIGN KEY (`projectId`) REFERENCES `Project` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Competition`;

CREATE TABLE `Competition` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(2000) NOT NULL,
    `text` varchar(3000) NOT NULL,
    `teilnehmerbedingung` varchar(3000) NOT NULL,
    `wettbewerbbeginn` date NOT NULL,
    `wettbewerbende` date NOT NULL,
    `wettbewerbCloseText` varchar(3000) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Image`;

CREATE TABLE `Image` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `projectid` int(11) NOT NULL,
    `path` varchar(70) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `projectid` (`projectid`),
    CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`projectid`) REFERENCES `Project` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Kriterien`;

CREATE TABLE `Kriterien` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `frage` varchar(200) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Project`;

CREATE TABLE `Project` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `userId` int(11) NOT NULL,
    `title` varchar(50) NOT NULL,
    `text` varchar(3500) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `userId` (`userId`),
    CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Pw`;

CREATE TABLE `Pw` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `hash` varchar(150) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Salt`;

CREATE TABLE `Salt` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `salt` double NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    `surname` varchar(50) NOT NULL,
    `role` varchar(25) NOT NULL,
    `email` varchar(50) NOT NULL,
    `land` varchar(3) DEFAULT NULL,
    `plz` int(11) DEFAULT NULL,
    `ortschaft` varchar(50) DEFAULT NULL,
    `strasse` varchar(50) DEFAULT NULL,
    `strNr` int(11) DEFAULT NULL,
    `tel` double DEFAULT NULL,
    `vorwahl` varchar(5) DEFAULT NULL,
    `pwId` int(11) NOT NULL,
    `saltId` int(11) NOT NULL,
    `optIn` int(11) DEFAULT NULL,
    `token` varchar(70) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `pwId` (`pwId`),
    KEY `saltId` (`saltId`),
    CONSTRAINT `User_ibfk_1` FOREIGN KEY (`pwId`) REFERENCES `Pw` (`id`),
    CONSTRAINT `User_ibfk_2` FOREIGN KEY (`saltId`) REFERENCES `Salt` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;