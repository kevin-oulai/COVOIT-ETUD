
-- --------------------------------------------------------

-- Le nombre de places disponibles pour les trajets partant 
-- d'un lieu donné ayant comme lieu d’arrivée l’IUT de Bayonne et du Pays basque à Anglet.

SELECT sum(T.nbPlace) FROM TRAJET T
WHERE T.numero_lieu_depart = '2' AND T.numero_lieu_arrivee = '3';

-- --------------------------------------------------------

-- Vérifier qu’un étudiant n’est pas à la fois conducteur et passager d’un trajet

SELECT E.numero FROM ETUDIANT E
JOIN TRAJET T ON E.numero = T.numero_conducteur
JOIN CHOISIR C ON E.numero = C.numero_passager
WHERE C.numero_trajet = T.numero;

-- Vérifier qu’un étudiant n’est pas à la fois conducteur et passager d’un trajet

SELECT E.numero, T.dateDep, T.heureDep, count(E.numero) FROM ETUDIANT E
JOIN TRAJET T ON E.numero = T.numero_conducteur
GROUP BY E.numero, T.dateDep, T.heureDep
HAVING count(E.numero) > 1;


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

-- Intitulé 11 : Compter le nombre de trajet pour chaque lieu d’arrivée.
SELECT L.nomRue AS NomRue, COUNT(T.numero) AS NombreTrajet
FROM LIEU L
JOIN TRAJET T ON T.numero_lieu_arrivee = L.numero
GROUP BY L.numero;

-- Intitulé 12 : Nombre de trajets qui ont encore de la place par conducteur
SELECT E.nom AS Nom, E.prenom AS Prenom, COUNT(T.numero) AS NombreTrajet
FROM ETUDIANT E
JOIN TRAJET T ON T.numero_conducteur = E.numero
WHERE T.nbPlace > (SELECT COUNT(C.numero_passager) 
                    FROM CHOISIR C 
                    WHERE C.numero_trajet = T.numero)
GROUP BY E.numero;

-- Intitulé 13 : La durée moyenne des trajets par conducteur inférieure à un nombre saisi.

SELECT E.numero AS NumEtudiant, ROUND(AVG(TIMEDIFF(T.heureArr, T.heureDep))/10000,2) AS DureeMoyenneTrajet
FROM `TRAJET` T
JOIN `ETUDIANT` E ON T.numero_conducteur = E.numero
GROUP BY E.numero
HAVING DureeMoyenneTrajet < 7;

-- Intitulé 14 : Le nom et prénom des conducteurs dont le nombre de trajet est supérieur au nombre de trajet moyen.
SELECT T.numero_conducteur AS NumeroConducteur, E.nom AS NomEtudiant, E.prenom AS PrenomEtudiant, COUNT(T.numero) AS NombreTrajet
FROM ETUDIANT E
JOIN TRAJET T ON `E`.`numero` = `T`.`numero_conducteur`
GROUP BY T.numero_conducteur
HAVING NombreTrajet > ( SELECT AVG(NombreTrajet)
                        FROM (  SELECT COUNT(T.numero) AS NombreTrajet
                                FROM TRAJET T
                                GROUP BY T.numero_conducteur) AS NombreTrajetMoyen);

-- Intitulé 15 : Liste des conducteurs ayant fait plus de 5 trajets entre Bayonne et l’IUT ayant des tarifs inférieurs aux tarifs moyens pour ce trajet
SELECT T.numero_conducteur AS NumConducteur, E.nom AS Nom, E.prenom AS Prenom, COUNT(T.numero) AS NombreTrajet
FROM ETUDIANT E
JOIN TRAJET T ON T.numero_conducteur = E.numero
WHERE T.numero_lieu_depart = 1 AND T.numero_lieu_arrivee = 3 AND T.prix < ( SELECT AVG(T2.prix) 
                                                                            FROM TRAJET T2 
                                                                            WHERE T2.numero_lieu_depart = 1 AND T2.numero_lieu_arrivee = 3)
GROUP BY T.numero_conducteur
HAVING COUNT(T.numero) > 5;

-- Intitulé 16 : Modifier les informations du profil.
UPDATE `ETUDIANT`
SET `nom` = 'Marquesuzaa', `prenom` = 'Christophe', `dateNaiss` = '1955-05-30', `adresseMail` = 'marquesu@univ-pau.fr', `numTelephone` = '0792657844'
WHERE `numero` = 6;