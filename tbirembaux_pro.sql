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
-- Base de données : `koulai001_pro`
--

-- --------------------------------------------------------

--
-- Structure de la table `VOITURE`
--

CREATE TABLE VOITURE (
  numero int(5) NOT NULL PRIMARY KEY,
  `nom` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `nbPlace` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `ETUDIANT`
--

CREATE TABLE `ETUDIANT` (
  numero int(5) NOT NULL PRIMARY KEY,
  nom varchar(50) DEFAULT NULL,
  prenom varchar(50) DEFAULT NULL,
  dateNaiss date DEFAULT NULL,
  adresseMail varchar(50) DEFAULT NULL,
  numTelephone varchar(10) DEFAULT NULL,
  numero_voiture int(5) NOT NULL,
  CONSTRAINT Fk_voiture FOREIGN KEY (numero_voiture) REFERENCES VOITURE(numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `LIEU`
--
CREATE TABLE LIEU(
	numero int(5) NOT NULL PRIMARY KEY,
    numRue int(5) NOT NULL,
    nomRue varchar(50) NOT NULL,
    ville varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `TRAJET`
--

CREATE TABLE `TRAJET` (
  numero int(5) NOT NULL PRIMARY KEY,
  heureDep varchar(5) DEFAULT NULL,
  heureArr varchar(5) DEFAULT NULL,
  prix int(3) DEFAULT NULL,
  dateDep date DEFAULT NULL,
  nbPlace int(2) DEFAULT NULL,
  numero_conducteur int(5) DEFAULT NULL,
  numero_lieu_depart int(5) NOT NULL,
  numero_lieu_arrivee int(5) NOT NULL,
  CONSTRAINT Fk_conducteur FOREIGN KEY (numero_conducteur) REFERENCES ETUDIANT(numero),
  CONSTRAINT Fk_lieu_depart FOREIGN KEY (numero_lieu_depart) REFERENCES LIEU(numero),
  CONSTRAINT Fk_lieu_arrivee FOREIGN KEY (numero_lieu_arrivee) REFERENCES LIEU(numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Structure de la table `BADGE`
--
CREATE TABLE BADGE (
	numero int(5) NOT NULL PRIMARY KEY,
    titre varchar(50) NOT NULL,
    image varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Structure de la table `AVIS`
--
CREATE TABLE AVIS (
	numero int(5) NOT NULL PRIMARY KEY,
    message varchar(50) NOT NULL,
	note int(2) DEFAULT NULL,
	numero_concerne int(5) NOT NULL,
	numero_commentateur int(5) NOT NULL,
    CONSTRAINT Fk_concerne foreign key (numero_concerne) references ETUDIANT(numero),
    CONSTRAINT Fk_commentateur foreign key (numero_commentateur) references ETUDIANT(numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Structure de la table `CHOISIR`
--
CREATE TABLE CHOISIR(
	numero_trajet int(5) NOT NULL,
    numero_passager int(5) NOT NULL,
	CONSTRAINT Fk_trajet foreign key (numero_trajet) references TRAJET(numero),
    CONSTRAINT Fk_passager foreign key (numero_passager) references ETUDIANT(numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Structure de la table `OBTENIR`
--
CREATE TABLE OBTENIR(
	numero_etudiant int(5) NOT NULL,
    numero_badge int(5) NOT NULL,
	CONSTRAINT Fk_etudiant foreign key (numero_etudiant) references ETUDIANT(numero),
    CONSTRAINT Fk_badge foreign key (numero_badge) references BADGE(numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

INSERT INTO `VOITURE` (`numero`, `nom`, `marque`, `nbPlace`) VALUES
(1, '911', 'Porsche', 3),
(2, 'Clio', 'Renault', 4),
(3, 'GT-R', 'Nissan', 4),
(4, 'E36', 'BMW', 5);

-- --------------------------------------------------------

INSERT INTO `ETUDIANT` (`numero`, `nom`, `prenom`, `dateNaiss`, `adresseMail`, `numTelephone`, `numero_voiture`) VALUES
(1, 'Birembaux', 'Theo', '2004-08-24', 'tbirembaux@iutbayonne.univ-pau.fr', '0783324454', 2),
(2, 'Rosalie', 'Thibault', '2003-05-30', 'trosalie@iutbayonne.univ-pau.fr', '0692354381', 3),
(3, 'Galles', 'Titouan', '2003-05-30', 'tgalles@iutbayonne.univ-pau.fr', '0692354381', 2),
(4, 'Dutournier', 'Candice', '2003-05-30', 'cdutournier001@iutbayonne.univ-pau.fr', '0692354381', 1),
(5, 'Oulai', 'Kevin', '2003-05-30', 'koulai001@iutbayonne.univ-pau.fr', '0692354381', 4);
INSERT INTO `ETUDIANT` (`numero`, `nom`, `prenom`, `dateNaiss`, `adresseMail`, `numTelephone`, `numero_voiture`) VALUES
(6, 'Oulai', 'Kevin', '2009-05-30', 'koulai001@iutbayonne.univ-pau.fr', '0692354381', 4);

-- --------------------------------------------------------

INSERT INTO LIEU (numero, numRue, nomRue, ville) VALUES
(1, 2, 'Allee parc Montaury', 'Anglet'),
(2, 14, 'Rue de la paix', 'Paris'),
(3, 5, 'Allee des Champs Elysees', 'Paris');

-- --------------------------------------------------------

INSERT INTO `TRAJET` (`numero`, `heureDep`, `heureArr`, `prix`, `dateDep`, `nbPlace`, `numero_conducteur`, numero_lieu_depart, numero_lieu_arrivee) VALUES
(1, '7:30', '15:00', 30, '2024-11-06', 4, 2, 1, 3),
(2, '17:30', '18:00', 15, '2024-11-06', 3, 1, 2, 3),
(3, '10:30', '13:00', 20, '2024-11-06', 2, 3, 2, 1);

-- --------------------------------------------------------

INSERT INTO AVIS (numero, message, note, numero_concerne, numero_commentateur) VALUES
(1,'Bon trajet', 4, 2, 3),
(2,'Mauvaise musique dans la voiture', 2, 5, 1);

INSERT INTO AVIS (numero, message, note, numero_concerne, numero_commentateur) VALUES
(3,'Excellent pilote', 5, 2, 3),
(4,'Conduit avec la mentalité "On a qu\'une vie"', 1, 2, 3),
(5,'A obtenu son permis dans un Kinder Surprise !!!', 1, 2, 3),
(6, 'Conduite assurée', 4, 5, 1),
(7, 'Bon trajet.. Si c\'était une course de rallye!', 1, 5, 1),
(8,'Conduite assurée et consciencieuse', 4, 5, 1);

-- --------------------------------------------------------

INSERT INTO BADGE (numero, titre, image) VALUES
(1,'Conducteur étoilé','etoile.png'),
(2,'Passager récurent', 'recurent.png');

-- --------------------------------------------------------

INSERT INTO OBTENIR (numero_etudiant, numero_badge) VALUES
(2,1),
(4,2);

-- --------------------------------------------------------

INSERT INTO CHOISIR (numero_trajet, numero_passager) VALUES
(1, 1),
(1, 5),
(2, 3),
(2, 4),
(2, 5),
(3, 2),
(3, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- REQUETES SQL

-- Intitulé 1 : Le nombre de places disponibles pour les trajets partant d'un lieu donné ayant comme lieu d’arrivée l’IUT de Bayonne et du Pays basque à Anglet.
SELECT T.nbPlace AS NombrePlaceDisponible
FROM TRAJET T
JOIN LIEU L ON L.numero = T.numero_lieu_arrivee
WHERE L.numero = 1;

-- Intitulé 2 : Le prix moyen des trajets partant d’un endroit donné et allant à l’IUT de Bayonne et du Pays basque à Anglet.
SELECT AVG(T.prix) AS PrixMoyen
FROM TRAJET T
JOIN LIEU L ON L.numero = T.numero_lieu_arrivee
WHERE T.numero = 1;

-- Intitulé 3 : La/les ville(s) qui possède le plus de trajet (le plus de lieu de départ et de lieu d'arrivée)
SELECT L.ville AS Ville, COUNT(T.numero) AS NombreTrajet
FROM LIEU L
JOIN TRAJET T ON T.numero_lieu_depart = L.numero
GROUP BY L.ville
ORDER BY COUNT(T.numero) DESC

-- Intitulé 4 : Le nombre de conducteurs ayant plus de 20 ans
SELECT COUNT(E.numero) AS NombreConducteur
FROM ETUDIANT E
WHERE DATEDIFF(DATE_FORMAT(NOW(), '%Y-%m-%d'), E.dateNaiss) > 7305;

-- Intitulé 5 : Le nombre de trajets complets.
SELECT COUNT(T.numero) AS NombreTrajetsComplets
FROM TRAJET T
WHERE T.nbPlace = ( SELECT COUNT(C.numero_passager) 
                    FROM CHOISIR C 
                    WHERE C.numero_trajet = T.numero);

-- Intitulé 6 : Le nombre de conducteurs ayant proposé au moins 2 trajets.
SELECT COUNT(E.numero) AS NombreConducteur
FROM ETUDIANT E
WHERE E.numero IN (SELECT T.numero_conducteur
                    FROM TRAJET T
                    GROUP BY T.numero_conducteur
                    HAVING COUNT(T.numero) >= 2);

-- Intitulé 7 : Le nom, prénom et mail des conducteurs ayant un trajet disponible pour un lieu d’arrivée donné
SELECT E.nom AS Nom, E.prenom AS Prenom, E.adresseMail AS Mail
FROM ETUDIANT E
JOIN TRAJET T ON T.numero_conducteur = E.numero
WHERE T.numero_lieu_arrivee = 1;

-- Intitulé 8 : Trouver des trajets dont le prix est inférieur à un prix donné
SELECT T.numero AS NumeroTrajet, T.prix AS Prix
FROM TRAJET T
WHERE T.prix < 20;

-- Intitulé 9 : Nombre d’avis reçu par personne (du plus d’avis au moins d'avis)
SELECT E.nom AS Nom, E.prenom AS Prenom, COUNT(A.numero) AS NombreAvis
FROM ETUDIANT E
JOIN AVIS A ON A.numero_concerne = E.numero
GROUP BY E.numero
ORDER BY COUNT(A.numero) DESC;

-- Intitulé 10 : Liste de tous les conducteurs avec une moyenne de note au-dessus d’un paramètre saisi au clavier triés par moyenne
SELECT E.nom AS Nom, E.prenom AS Prenom, AVG(A.note) AS MoyenneNote
FROM ETUDIANT E
JOIN AVIS A ON A.numero_concerne = E.numero
GROUP BY E.numero
HAVING AVG(A.note) > 1
ORDER BY AVG(A.note) DESC;