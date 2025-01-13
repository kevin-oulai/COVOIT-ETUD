INSERT INTO `VOITURE` (`numero`, `nom`, `marque`, `nbPlace`) VALUES
(1, '911', 'Porsche', 3),

-- --------------------------------------------------------

INSERT INTO `ETUDIANT` (`numero`, `nom`, `prenom`, `dateNaiss`, `adresseMail`, `numTelephone`, `numero_voiture`, motDePasse, token_reinitialisation, expiration_token, salt) VALUES
(1, 'Birembaux', 'Theo', '2004-08-24', 'tbirembaux@iutbayonne.univ-pau.fr', '0783324454', 2, '$2y$10$dWVUbuz70gJR23aqAO7ux.aD.ZrOw2EiZEBxDOWKDFIpGQQBZKXZa', NULL, NULL, '58a41f8056cbef9b5dbf8bb6443a615a'),

-- --------------------------------------------------------

INSERT INTO LIEU (numero, numRue, nomRue, ville) VALUES
(1, 2, 'Allee parc Montaury', 'Anglet'),
(2, 14, 'Rue de la paix', 'Paris'),
(3, 5, 'Allee des Champs Elysees', 'Paris');

-- --------------------------------------------------------

INSERT INTO `TRAJET` (`numero`, `heureDep`, `heureArr`, `prix`, `dateDep`, `nbPlace`, `numero_conducteur`, 'numero_lieu_depart', 'numero_lieu_arrivee') VALUES
(1, '7:30', '15:00', 30, '2024-11-06', 4, 2, 1, 3),
(2, '17:30', '18:00', 15, '2024-11-06', 3, 1, 2, 3),
(3, '10:30', '13:00', 20, '2024-11-06', 2, 3, 2, 1);

-- --------------------------------------------------------

INSERT INTO AVIS (numero, datePost, message, note, numero_concerne, numero_commentateur) VALUES
(1, CURRENT_TIMESTAMP ,'Excellent pilote', 5, 2, 3);

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

INSERT INTO CHOISIR (numero_trajet, numero_passager) VALUES 
(3, 3);