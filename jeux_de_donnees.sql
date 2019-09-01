-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 25 août 2019 à 20:31
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p5`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_added` date NOT NULL,
  `last_maj` date DEFAULT NULL,
  `validation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `auteur` (`author`),
  KEY `auteur_2` (`author`),
  KEY `post` (`post`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `author`, `post`, `content`, `date_added`, `last_maj`, `validation`) VALUES
(14, 1, 6, 'Hey, ça va?', '2019-08-12', NULL, 1),
(15, 1, 6, 'Yo', '2019-08-12', NULL, 1),
(16, 1, 6, 'Test encore', '2019-08-12', NULL, 1),
(18, 1, 6, 'Et again', '2019-08-12', NULL, 1),
(20, 1, 5, 'Test', '2019-08-12', NULL, 1),
(21, 1, 2, 'Hey', '2019-08-12', NULL, 1),
(22, 1, 6, 'Hey, bien? Oui sur? Mais oui, lourd', '2019-08-13', NULL, 1),
(23, 1, 6, 'Yo, bien? trkl yep', '2019-08-13', NULL, 1),
(24, 1, 6, 'xd, rien de drole', '2019-08-13', NULL, 1),
(25, 1, 6, 'LLol, tu trouve ça drôle?', '2019-08-13', NULL, 1),
(28, 1, 6, 'Dacc', '2019-08-13', NULL, 1),
(29, 1, 6, 'Deam', '2019-08-13', NULL, 1),
(30, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(31, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(32, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(33, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(34, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(35, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(36, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(38, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(41, 1, 6, 'Yeahh', '2019-08-13', NULL, 1),
(42, 1, 6, 'Encore?', '2019-08-13', NULL, 1),
(43, 6, 1, 'Hey', '2019-08-16', NULL, 1),
(44, 1, 6, 'Oui', '2019-08-18', NULL, 1),
(46, 1, 3, 'Test', '2019-08-23', NULL, 1),
(47, 7, 31, 'yo', '2019-08-25', NULL, 1),
(48, 7, 31, 'Yo', '2019-08-25', NULL, 1),
(49, 7, 31, 'Hello\r\n', '2019-08-25', NULL, 1),
(50, 7, 1, 'ça va?', '2019-08-25', NULL, 1),
(51, 1, 31, 'trql', '2019-08-25', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `chapo` text NOT NULL,
  `content` mediumtext NOT NULL,
  `author` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `last_updated` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `auteur` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `chapo`, `content`, `author`, `date_added`, `last_updated`) VALUES
(1, 'Uno', 'Chiffre un', 'Ceci est le chiffre un', 1, '2019-07-31', NULL),
(2, 'Dos', 'Chiffre Deux', 'Ceci est le chiffre deux', 1, '2019-07-31', NULL),
(3, 'Tres', 'Chiffre trois', 'Ceci est le chiffre trois', 1, '2019-07-31', NULL),
(4, 'Quatro', 'Le chiffre quatre', 'Ceci est le chiffre quatre', 1, '2019-07-31', NULL),
(5, 'Cinquo', 'Le chiffre cinq', 'Ceci est le chiffre cinq', 1, '2019-07-31', NULL),
(6, 'Seis', 'Le chiffre six', 'Ceci est le chiffre six', 1, '2019-07-31', NULL),
(7, 'Sept', 'Ceci est 7', 'Je test le chiffre 7', 1, '2019-08-22', NULL),
(25, 'Huit', 'Ocho', 'HUITO Nop, sur?', 1, '2019-08-22', '2019-08-23'),
(30, '10', 'la dizaine', 'le nombre dix', 6, '2019-08-24', NULL),
(31, 'Onze', 'Le 11', '<p>Ceci est le <em>11&egrave;me</em> <strong>test</strong></p>', 1, '2019-08-25', NULL),
(35, 'Douze', 'djnsqklkjd', '<p>njdslfckqsjd,nlks</p>', 1, '2019-08-25', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `nickname` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `lvl` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `sign_up` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reset` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `nickname`, `email`, `password`, `lvl`, `sign_up`, `reset`) VALUES
(1, 'Adel', 'Malik', 'lemineurdu35', 'adel_98@hotmail.fr', '$2y$10$Ihl8OX4vX0LcabKNmPHPIunw3BZ.FtVR3/Np3Y48/Yo3ayM3YH0dm', '3', '2019-07-31 17:16:13', '2019-08-22 20:04:55'),
(3, '', 'maryne', 'sole', 'jskqljd@dkd.fr', '$2y$10$m04naeFbgpjzxPerg/GIQekIx4XcPPVPlxBtkoHbVaw8lUK5XTbg2', '0', '2019-08-14 13:02:21', NULL),
(5, 'jfdisfj', 'ddskok', 'jfskdf', 'jkds@lol.fr', '$2y$10$YTqYhHCTw/tbWaG6rn0Ezel8PB4vkAnHiJJxQnec6xDUx7vokaVY6', '1', '2019-08-14 13:23:50', '2019-08-14 20:46:40'),
(6, 'test', 'test', 'theminororof35', 'adelemineur@gmail.com', '$2y$10$S7GejavoX.MNh5kK7FOk8OozDHuaZayUOm972fHGx99POCrM/l1Zu', '2', '2019-08-16 12:28:08', NULL),
(7, 'Malik', 'Adel', 'monrocq', 'marinmalouin@hotmail.fr', '$2y$10$lhyZssZUVOgnq8MKDE9C.OSlFzlajKggPzFMbejJ4ZUAXCowqR9g.', '1', '2019-08-25 20:16:22', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
