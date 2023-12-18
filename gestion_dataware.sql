-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 12 déc. 2023 à 10:26
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";





CREATE Database `gestion_dataware`;
USE `gestion_dataware`


DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `ProjectID` int NOT NULL AUTO_INCREMENT,
  `ProjectName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ProductOwnerID` int DEFAULT NULL,
  PRIMARY KEY (`ProjectID`),
  KEY `ProductOwnerID` (`ProductOwnerID`)
);

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`ProjectID`, `ProjectName`, `ProductOwnerID`) VALUES
(1, 'DATAN', 3),
(2, 'database analytique', 3),
(4, 'Brief-6', 3),
(5, 'BREIF-10', 8);

-- --------------------------------------------------------

--
-- Structure de la table `projectteams`
--

DROP TABLE IF EXISTS `projectteams`;
CREATE TABLE IF NOT EXISTS `projectteams` (
  `ProjectID` int NOT NULL,
  `TeamID` int NOT NULL,
  PRIMARY KEY (`ProjectID`,`TeamID`),
  KEY `TeamID` (`TeamID`)
);

--
-- Déchargement des données de la table `projectteams`
--

INSERT INTO `projectteams` (`ProjectID`, `TeamID`) VALUES
(2, 1),
(1, 2),
(4, 5),
(5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `teammembers`
--

DROP TABLE IF EXISTS `teammembers`;
CREATE TABLE IF NOT EXISTS `teammembers` (
  `TeamID` int NOT NULL,
  `UserID` int NOT NULL,
  PRIMARY KEY (`TeamID`,`UserID`),
  KEY `UserID` (`UserID`)
);

--
-- Déchargement des données de la table `teammembers`
--

INSERT INTO `teammembers` (`TeamID`, `UserID`) VALUES
(1, 3),
(2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `TeamID` int NOT NULL AUTO_INCREMENT,
  `TeamName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ScrumMasterID` int DEFAULT NULL,
  PRIMARY KEY (`TeamID`),
  KEY `ScrumMasterID` (`ScrumMasterID`)
);

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`TeamID`, `TeamName`, `ScrumMasterID`) VALUES
(1, 'Nighthclawres', 7),
(2, 'BA2assa', 1),
(3, 'team loda', 1),
(5, 'masters', 7),
(6, 'Breif', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID_User` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Prenom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Tel` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PasswordU` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `UserRole` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'User',
  `Image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID_User`)
);

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID_User`, `Nom`, `Prenom`, `Email`, `Tel`, `PasswordU`, `UserRole`, `Image`) VALUES
(1, 'Talemsi', 'abdellah', 'mohamadtalemsi@gmail.com', '0625084897', '$2y$10$KS8C7k35b6I8PAT7AfxsZeVviu/Vun/Qj5DChkvJvSlkqQuIbn/Di', 'scrum_master', NULL),
(2, 'loulida', 'zakaria', 'zakarialoulida@gmail.com', '0625084898', '$2y$10$PyYMo7dI6l6uXKkBsq3yl./SGiFUYg2EIXwhsJbz7hodezjDWGt2K', 'product_owner', NULL),
(3, 'imad', 'din', 'imadin@gmail.com', '06250848854', '$2y$10$pOhK0BTA9bUAAtNto7FAL.R8kNGwOoHARQ6eUG51PkQQEktNwmhLG', 'product_owner', NULL),
(7, 'ZAKARIA', 'Houass', 'zakhouassi@gmail.com', '0256452478', '$2y$10$NGsT/KG2JcEYb5iAwmwa.u1npcInQSrDYh/Z8BMavGgTFtdJfhpju', 'scrum_master', NULL),
(8, 'hiba', 'lhbiba', 'hibalhbiba@gmail.com', '0212054585', '$2y$10$zNGAl5Bp6b35u6BgQnG/8u3wzaYg3Insm0CNlAfN2uvEPAgP2OTDO', 'product_owner', NULL),
(10, 'talemsi', 'mahjoub', 'talemsimahjoub@gmail.com', '06253125', '$2y$10$pdsYkk2yxCrl/v0FqiFqUOllZYGlevY3SDF6cmkL4FmC6j/7U6R5G', 'user', NULL),
(12, 'abdellah ', 'hakim', 'abdellahhakim@gmail.com', '0625487952', '$2y$10$a0MXdXcS98.RWK7F.OETg.XBUxHZ/nPsZwLZN4/dgDWGhksgvPdrG', 'user', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`ProductOwnerID`) REFERENCES `users` (`ID_User`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `projectteams`
--
ALTER TABLE `projectteams`
  ADD CONSTRAINT `projectteams_ibfk_1` FOREIGN KEY (`ProjectID`) REFERENCES `projects` (`ProjectID`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `projectteams_ibfk_2` FOREIGN KEY (`TeamID`) REFERENCES `teams` (`TeamID`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `teammembers`
--
ALTER TABLE `teammembers`
  ADD CONSTRAINT `teammembers_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `teams` (`TeamID`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `teammembers_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID_User`)ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`ScrumMasterID`) REFERENCES `users` (`ID_User`)ON DELETE CASCADE ON UPDATE SET NULL;
COMMIT;

