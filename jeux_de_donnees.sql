-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 16 août 2019 à 10:53
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
  PRIMARY KEY (`id`),
  KEY `auteur` (`author`),
  KEY `auteur_2` (`author`),
  KEY `post` (`post`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `author`, `post`, `content`, `date_added`, `last_maj`) VALUES
(3, 1, 3, 'Troisième test, lolilol', '2019-08-12', NULL),
(4, 1, 3, 'quatrième test, un p', '2019-08-12', NULL),
(12, 1, 1, 'Hello, ça va? Oui et toi?', '2019-08-12', '2019-08-16'),
(14, 1, 6, 'Hey, ça va?', '2019-08-12', NULL),
(15, 1, 6, 'Yo', '2019-08-12', NULL),
(16, 1, 6, 'Test encore', '2019-08-12', NULL),
(17, 1, 6, 'Encore une fois stp', '2019-08-12', NULL),
(18, 1, 6, 'Et again', '2019-08-12', NULL),
(20, 1, 5, 'Test', '2019-08-12', NULL),
(21, 1, 2, 'Hey', '2019-08-12', NULL),
(22, 1, 6, 'Hey, bien? Oui sur? Mais oui, lourd', '2019-08-13', NULL),
(23, 1, 6, 'Yo, bien? trkl yep', '2019-08-13', NULL),
(24, 1, 6, 'xd, rien de drole', '2019-08-13', NULL),
(25, 1, 6, 'LLol, tu trouve ça drôle?', '2019-08-13', NULL),
(28, 1, 6, 'Dacc', '2019-08-13', NULL),
(29, 1, 6, 'Deam', '2019-08-13', NULL),
(30, 1, 6, 'Yeahh', '2019-08-13', NULL),
(31, 1, 6, 'Yeahh', '2019-08-13', NULL),
(32, 1, 6, 'Yeahh', '2019-08-13', NULL),
(33, 1, 6, 'Yeahh', '2019-08-13', NULL),
(34, 1, 6, 'Yeahh', '2019-08-13', NULL),
(35, 1, 6, 'Yeahh', '2019-08-13', NULL),
(36, 1, 6, 'Yeahh', '2019-08-13', NULL),
(37, 1, 6, 'Yeahh', '2019-08-13', NULL),
(38, 1, 6, 'Yeahh', '2019-08-13', NULL),
(39, 1, 6, 'Yeahh', '2019-08-13', NULL),
(40, 1, 6, 'Yeahh', '2019-08-13', NULL),
(41, 1, 6, 'Yeahh', '2019-08-13', NULL),
(42, 1, 6, 'Encore?', '2019-08-13', NULL),
(43, 6, 1, 'Hey', '2019-08-16', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `chapo`, `content`, `author`, `date_added`, `last_updated`) VALUES
(1, 'Uno', 'Chiffre un', 'Ceci est le chiffre un', 1, '2019-07-31', NULL),
(2, 'Dos', 'Chiffre Deux', 'Ceci est le chiffre deux', 1, '2019-07-31', NULL),
(3, 'Tres', 'Chiffre trois', 'Ceci est le chiffre trois', 1, '2019-07-31', NULL),
(4, 'Quatro', 'Le chiffre quatre', 'Ceci est le chiffre quatre', 1, '2019-07-31', NULL),
(5, 'Cinquo', 'Le chiffre cinq', 'Ceci est le chiffre cinq', 1, '2019-07-31', NULL),
(6, 'Seis', 'Le chiffre six', 'Ceci est le chiffre six', 1, '2019-07-31', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `nickname`, `email`, `password`, `lvl`, `sign_up`, `reset`) VALUES
(1, 'Adel', 'Malik', 'lemineurdu35', 'adel_98@hotmail.fr', '$2y$10$WitZvSP5lye9Kmkl4TV8oOQokz2Ck8LW3ZGlFYM9nHxmXZRsq35KK', '3', '2019-07-31 17:16:13', '2019-08-16 14:09:21'),
(3, '', 'maryne', 'sole', 'jskqljd@dkd.fr', '$2y$10$m04naeFbgpjzxPerg/GIQekIx4XcPPVPlxBtkoHbVaw8lUK5XTbg2', '0', '2019-08-14 13:02:21', NULL),
(5, 'jfdisfj', 'ddskok', 'jfskdf', 'jkds@lol.fr', '$2y$10$YTqYhHCTw/tbWaG6rn0Ezel8PB4vkAnHiJJxQnec6xDUx7vokaVY6', '1', '2019-08-14 13:23:50', '2019-08-14 20:46:40'),
(6, 'test', 'test', 'theminororof35', 'adelemineur@gmail.com', '$2y$10$S7GejavoX.MNh5kK7FOk8OozDHuaZayUOm972fHGx99POCrM/l1Zu', '1', '2019-08-16 12:28:08', NULL);

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
