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
  photoDeProfil varchar(99) DEFAULT "photoProfilParDefaut.png",
  motDePasse varchar(999) NOT NULL,
  token_reinitialisation varchar(250) DEFAULT NULL,
  expiration_token datetime DEFAULT NULL,
  salt varchar(255) NOT NULL,
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
    datePost datetime NOT NULL,
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