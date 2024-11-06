-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-5.7
-- Généré le : mer. 06 nov. 2024 à 14:55
-- Version du serveur : 5.7.28
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tbirembaux_pro`
--

-- --------------------------------------------------------

--
-- Structure de la table `ETUDIANT`
--

CREATE TABLE `ETUDIANT` (
  `numero` int(5) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `dateNaiss` date DEFAULT NULL,
  `adresseMail` varchar(50) DEFAULT NULL,
  `numTelephone` varchar(10) DEFAULT NULL,
  `numero_voiture` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ETUDIANT`
--

INSERT INTO `ETUDIANT` (`numero`, `nom`, `prenom`, `dateNaiss`, `adresseMail`, `numTelephone`, `numero_voiture`) VALUES
(1, 'Birembaux', 'Theo', '2004-08-24', 'tbirembaux@iutbayonne.univ-pau.fr', '0783324454', 2),
(2, 'Rosalie', 'Thibault', '2003-05-30', 'trosalie@iutbayonne.univ-pau.fr', '0692354381', 3);

-- --------------------------------------------------------

--
-- Structure de la table `TRAJET`
--

CREATE TABLE `TRAJET` (
  `numero` int(5) NOT NULL,
  `heureDep` varchar(5) DEFAULT NULL,
  `heureArr` varchar(5) DEFAULT NULL,
  `prix` int(3) DEFAULT NULL,
  `dateDep` date DEFAULT NULL,
  `nbPlace` int(2) DEFAULT NULL,
  `numero_conducteur` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TRAJET`
--

INSERT INTO `TRAJET` (`numero`, `heureDep`, `heureArr`, `prix`, `dateDep`, `nbPlace`, `numero_conducteur`) VALUES
(1, '7:30', '08:00', 10, '2024-11-06', 4, 2),
(2, '17:30', '18:00', 15, '2024-11-06', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `VOITURE`
--

CREATE TABLE `VOITURE` (
  `numero` int(5) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `nbPlace` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `VOITURE`
--

INSERT INTO `VOITURE` (`numero`, `nom`, `marque`, `nbPlace`) VALUES
(1, '911', 'Porsche', 3),
(2, 'Clio', 'Renault', 4),
(3, 'GT-R', 'Nissan', 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ETUDIANT`
--
ALTER TABLE `ETUDIANT`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `FK_NumVoiture` (`numero_voiture`);

--
-- Index pour la table `TRAJET`
--
ALTER TABLE `TRAJET`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `FK_numConducteur` (`numero_conducteur`);

--
-- Index pour la table `VOITURE`
--
ALTER TABLE `VOITURE`
  ADD PRIMARY KEY (`numero`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ETUDIANT`
--
ALTER TABLE `ETUDIANT`
  ADD CONSTRAINT `FK_NumVoiture` FOREIGN KEY (`numero_voiture`) REFERENCES `VOITURE` (`numero`);

--
-- Contraintes pour la table `TRAJET`
--
ALTER TABLE `TRAJET`
  ADD CONSTRAINT `FK_numConducteur` FOREIGN KEY (`numero_conducteur`) REFERENCES `ETUDIANT` (`numero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
