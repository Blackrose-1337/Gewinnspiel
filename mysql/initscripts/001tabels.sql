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
    `id` int NOT NULL AUTO_INCREMENT,
    `administrativeId` int NOT NULL,
    `userId` int NOT NULL,
    `bewertung` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `administrativeId` (`administrativeId`),
    KEY `userId` (`userId`),
    CONSTRAINT `Bewertung_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `User` (`id`),
    CONSTRAINT `Bewertung_ibfk_3` FOREIGN KEY (`administrativeId`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Competition`;

CREATE TABLE `Competition` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(30) NOT NULL,
    `text` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `teilnehmerbedingungen` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Project`;

CREATE TABLE `Project` (
    `id` int NOT NULL AUTO_INCREMENT,
    `userId` int NOT NULL,
    `title` varchar(50) NOT NULL,
    `text` varchar(3500) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `userId` (`userId`),
    CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Pw`;

CREATE TABLE `Pw` (
    `id` int NOT NULL AUTO_INCREMENT,
    `hash` varchar(522) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Salt`;

CREATE TABLE `Salt` (
    `id` int NOT NULL AUTO_INCREMENT,
    `salt` double NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    `surname` varchar(50) NOT NULL,
    `role` varchar(25) NOT NULL,
    `email` varchar(50) NOT NULL,
    `land` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `plz` int DEFAULT NULL,
    `ortschaft` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `strasse` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `strNr` int DEFAULT NULL,
    `tel` double DEFAULT NULL,
    `pwId` int NOT NULL,
    `saltId` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `pwId` (`pwId`),
    KEY `saltId` (`saltId`),
    CONSTRAINT `User_ibfk_1` FOREIGN KEY (`pwId`) REFERENCES `Pw` (`id`),
    CONSTRAINT `User_ibfk_2` FOREIGN KEY (`saltId`) REFERENCES `Salt` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;