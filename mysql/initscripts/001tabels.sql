SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

# Drop all tables if they exist
DROP TABLE IF EXISTS `Bewertung`;
DROP TABLE IF EXISTS `Image`;
DROP TABLE IF EXISTS `Project`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Kriterien`;
DROP TABLE IF EXISTS `Competition`;
DROP TABLE IF EXISTS `Salt`;
DROP TABLE IF EXISTS `Pw`;

# Create all  without foreign keys
CREATE TABLE `Pw` (
                      `id` int NOT NULL AUTO_INCREMENT,
                      `hash` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
                      PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `Salt` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `salt` double NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `Competition` (
                               `id` int NOT NULL AUTO_INCREMENT,
                               `title` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `text` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `teilnehmerbedingung` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `wettbewerbbeginn` date NOT NULL,
                               `wettbewerbende` date NOT NULL,
                               `wettbewerbCloseText` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `Kriterien` (
                             `id` int NOT NULL AUTO_INCREMENT,
                             `frage` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

# Create all tables with foreign keys
CREATE TABLE `User` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `role` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `land` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `plz` int DEFAULT NULL,
                        `ortschaft` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `strasse` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `strNr` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `tel` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `vorwahl` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `pwId` int NOT NULL,
                        `saltId` int NOT NULL,
                        `optIn` int DEFAULT NULL,
                        `token` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        KEY `pwId` (`pwId`),
                        KEY `saltId` (`saltId`),
                        CONSTRAINT `User_ibfk_1` FOREIGN KEY (`pwId`) REFERENCES `Pw` (`id`),
                        CONSTRAINT `User_ibfk_2` FOREIGN KEY (`saltId`) REFERENCES `Salt` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Project` (
                           `id` int NOT NULL AUTO_INCREMENT,
                           `userId` int NOT NULL,
                           `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `text` varchar(3500) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `pictureIncrement` varchar(3500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                           `finish` int DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           KEY `userId` (`userId`),
                           CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Image` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `projectid` int NOT NULL,
                         `path` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                         PRIMARY KEY (`id`),
                         KEY `projectid` (`projectid`),
                         CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`projectid`) REFERENCES `Project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `Bewertung` (
                             `id` int NOT NULL AUTO_INCREMENT,
                             `administrativeId` int NOT NULL,
                             `projectId` int NOT NULL,
                             `kriterienId` int NOT NULL,
                             `bewertung` int DEFAULT NULL,
                             `finish` int NOT NULL,
                             PRIMARY KEY (`id`),
                             KEY `administrativeId` (`administrativeId`),
                             KEY `userId` (`projectId`),
                             KEY `kriterienId` (`kriterienId`),
                             CONSTRAINT `Bewertung_ibfk_3` FOREIGN KEY (`administrativeId`) REFERENCES `User` (`id`),
                             CONSTRAINT `Bewertung_ibfk_6` FOREIGN KEY (`kriterienId`) REFERENCES `Kriterien` (`id`),
                             CONSTRAINT `Bewertung_ibfk_8` FOREIGN KEY (`projectId`) REFERENCES `Project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
