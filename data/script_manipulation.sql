
-- --------------------------------------------------------

--Intitulé : Le nombre de places disponibles pour les trajets partant d'un lieu donné ayant comme lieu d’arrivée l’IUT de Bayonne et du Pays basque à Anglet.   

SELECT t.nbPlace  
FROM TRAJET t  
JOIN LIEU lArr ON lArr.numero = t.numero_lieu_arrivee  
WHERE lArr.nomRue = "Allee parc Montaury" AND lArr.ville = "Anglet"; 

-- --------------------------------------------------------

-- Intitulé : Le prix moyen des trajets allant à l’IUT de Bayonne et du Pays basque à Anglet.   

SELECT AVG(t.prix)  
FROM TRAJET t JOIN LIEU lArr ON lArr.numero = t.numero_lieu_arrivee  
WHERE lArr.nomRue = "Allee parc Montaury" AND lArr.ville = "Anglet"; 

-- Intitulé : Le nombre de conducteurs ayant plus de 20 ans   

SELECT COUNT(E.numero) AS NombreConducteur 
FROM ETUDIANT E 
WHERE DATEDIFF(DATE_FORMAT(NOW(), '%Y-%m-%d'), E.dateNaiss) > 7305; 


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Intitulé : Le nombre de trajets complets.   

SELECT COUNT(T.numero) AS NombreTrajetsComplets 
FROM TRAJET T 
WHERE T.nbPlace = (SELECT COUNT(C.numero_passager)  
                   FROM CHOISIR C  
                   WHERE C.numero_trajet = T.numero); 

-- Intitulé : Le nombre de conducteurs ayant proposé au moins 2 trajets. 

SELECT COUNT(E.numero) AS NombreConducteur 
FROM ETUDIANT E 
WHERE DATEDIFF(DATE_FORMAT(NOW(), '%Y-%m-%d'), E.dateNaiss) > 7305; 

-- Intitulé : Le nombre de trajets complets.   

SELECT COUNT(T.numero) AS NombreTrajetsComplets 
FROM TRAJET T 
WHERE T.nbPlace = (SELECT COUNT(C.numero_passager)  
                   FROM CHOISIR C  
                   WHERE C.numero_trajet = T.numero); 

-- Intitulé : Le nombre de conducteurs ayant proposé au moins 2 trajets. 

SELECT COUNT(E.numero) AS NombreConducteur 
FROM ETUDIANT E 
WHERE E.numero IN (SELECT T.numero_conducteur 
                   FROM TRAJET T 
                   GROUP BY T.numero_conducteur 
                   HAVING COUNT(T.numero) >= 2); 

-- Intitulé : Le nom, prénom et mail des conducteurs ayant un trajet disponible pour un lieu d’arrivée donné   

set @lieuArrDonne := 'anglet'; 
SELECT E.nom AS Nom, E.prenom AS Prenom, E.adresseMail AS Mail, L.numRue, L.nomRue, L.ville 
FROM ETUDIANT E  
JOIN TRAJET T ON T.numero_conducteur = E.numero  
JOIN LIEU L ON L.numero = T.numero_lieu_arrivee 
WHERE L.ville = @lieuArrDonne; 

-- Intitulé : Trouver des trajets dont le prix est inférieur à un prix donné    

SELECT T.numero AS NumeroTrajet, T.prix AS Prix  
FROM TRAJET T  
WHERE prix <= 50; 

-- Intitulé : Nombre d’avis reçu par personne (du plus d’avis au moins d'avis)   

SELECT E.nom AS Nom, E.prenom AS Prenom, COUNT(A.numero) AS NombreAvis 
FROM ETUDIANT E 
JOIN AVIS A ON A.numero_concerne = E.numero 
GROUP BY E.numero 
ORDER BY COUNT(A.numero) DESC; 

-- Intitulé : Liste de tous les conducteurs avec une moyenne de note au-dessus d’un paramètre saisi au clavier triés par moyenne   

SELECT E.nom AS Nom, E.prenom AS Prenom, AVG(A.note) AS MoyenneNote 
FROM ETUDIANT E 
JOIN AVIS A ON A.numero_concerne = E.numero 
GROUP BY E.numero 
HAVING AVG(A.note) > 3 
ORDER BY AVG(A.note) DESC; 

-- Intitulé : Compter le nombre de trajet pour chaque lieu d’arrivée.   

SELECT L.nomRue AS NomRue, COUNT(T.numero) AS NombreTrajet 
FROM LIEU L 
JOIN TRAJET T ON T.numero_lieu_arrivee = L.numero 
GROUP BY L.numero; 

-- Intitulé : Nombre de trajets qui ont encore de la place par conducteur   

SELECT E.nom AS Nom, E.prenom AS Prenom, COUNT(T.numero) AS NombreTrajet 
FROM ETUDIANT E 
JOIN TRAJET T ON T.numero_conducteur = E.numero 
WHERE T.nbPlace > (SELECT COUNT(C.numero_passager)  
                    FROM CHOISIR C  
                    WHERE C.numero_trajet = T.numero) 
GROUP BY E.numero; 

-- Intitulé : La durée moyenne des trajets par conducteur inférieure à un nombre saisi. 

SELECT E.numero AS NumEtudiant, ROUND(AVG(TIMEDIFF(T.heureArr, T.heureDep))/10000,2) AS DureeMoyenneTrajet 
FROM `TRAJET` T 
JOIN `ETUDIANT` E ON T.numero_conducteur = E.numero 
GROUP BY E.numero 
HAVING DureeMoyenneTrajet < 7; 

-- Intitulé : Le nom et prénom des conducteurs dont le nombre de trajet est supérieur au nombre de trajet moyen. 

SELECT T.numero_conducteur AS NumeroConducteur, E.nom AS NomEtudiant, E.prenom AS PrenomEtudiant, COUNT(T.numero) AS NombreTrajet 
FROM ETUDIANT E 
JOIN TRAJET T ON `E`.`numero` = `T`.`numero_conducteur` 
GROUP BY T.numero_conducteur 
HAVING NombreTrajet > ( SELECT AVG(NombreTrajet) 
                        FROM (SELECT COUNT(T.numero) AS NombreTrajet 
                              FROM TRAJET T 
                              GROUP BY T.numero_conducteur) AS NombreTrajetMoyen); 

-- Intitulé : Liste des conducteurs ayant fait plus de 5 trajets entre Bayonne et l’IUT ayant des tarifs inférieurs aux tarifs moyens pour ce trajet   

SELECT T.numero_conducteur AS NumConducteur, E.nom AS Nom, E.prenom AS Prenom, COUNT(T.numero) AS NombreTrajet 
FROM ETUDIANT E 
JOIN TRAJET T ON T.numero_conducteur = E.numero 
WHERE T.numero_lieu_depart = 1 AND T.numero_lieu_arrivee = 3 
AND T.prix<(SELECT AVG(T2.prix)                                                        
           FROM TRAJET T2  
           WHERE T2.numero_lieu_depart = 1 AND T2.numero_lieu_arrivee = 3) 
           GROUP BY T.numero_conducteur 
           HAVING COUNT(T.numero) > 1; 

-- Intitulé : Modifier les informations du profil.   

UPDATE `ETUDIANT` 
SET `nom` = 'Marquesuzaa', `prenom` = 'Christophe', `dateNaiss` = '1955-05-30', `adresseMail` = 'marquesu@univ-pau.fr', `numTelephone` = '0792657844' 
WHERE `numero` = 6; 

-- Intitulé : Créer un compte (vérifier que le mail n'existe pas déjà)   

SELECT COUNT(*) FROM ETUDIANT WHERE adressemail = ‘titouangalles@gmail.com’; 

-- Intitulé :  Ajouter un nouveau trajet en spécifiant l'arrivée et le départ, la date, le prix et le nombre de place disponible.   

INSERT INTO TRAJET(heureDep, heureArr, prix, dateDep, nbPlace, numero_conducteur, numero_lieu_depart, numero_lieu_arrivee)  
VALUES (“07:30”, “15:00”, 30, 2024-11-06, 4, 2, 1, 3); 