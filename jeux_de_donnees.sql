-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 31 juil. 2019 à 20:17
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
  `date` date NOT NULL,
  `last_maj` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auteur` (`author`),
  KEY `auteur_2` (`author`),
  KEY `post` (`post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `date_ajout` date NOT NULL,
  `last_maj` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `auteur` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `chapo`, `content`, `author`, `date_ajout`, `last_maj`) VALUES
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
  `password` char(40) NOT NULL,
  `lvl` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `sign_up` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `nickname`, `email`, `password`, `lvl`, `sign_up`) VALUES
(1, 'Adel', 'Malik', 'lemineurdu35', 'adel_98@hotmail.fr', '', '3', '2019-07-31 17:16:13');

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
