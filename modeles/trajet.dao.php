<?php
/**
* @file    trajet.dao.php
* @author  Thibault ROSALIE

* @brief Classe TrajetDao pour gérer les trajets dans la base de données
 
* @details Cette classe permet de gérer les trajets dans la base de données
* 
* La connexion est représenté par l'objet PDO de PHP

* @version 0.1
* @date    14/11/2024
*/
class TrajetDao{

    // Attributs
    /**
     * @brief Objet PDO de connexion à la base de données
     *
     * @var PDO|null
     */
    private ?PDO $PDO;

    // Constructeur
    /**
     * @brief Constructeur de la classe TrajetDao
     *
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->PDO = $pdo;
    }

    // Getters & Setters
    /**
     * @brief Retourne l'objet PDO de connexion à la base de données
     *
     * @return PDO|null
     */
    public function getPDO(): ?PDO
    {
        return $this->PDO;
    }

    /**
     * @brief Modifie l'objet PDO de connexion à la base de données
     *
     * @param PDO|null $PDO
     * @return void
     */
    public function setPDO(?PDO $PDO): void
    {
        $this->PDO = $PDO;
    }
    /**
     * @brief Retourne dans une liste toutes les informations d'un trajet en fonction du numero d'un passager
     *
     * @param integer $numero
     * @return array
     */
    public function findAllByPassager(int $numero): array
    {
        $requete = "SELECT T.* FROM TRAJET T JOIN CHOISIR C ON T.NUMERO = C.NUMERO_TRAJET WHERE C.NUMERO_PASSAGER = :numero";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(":numero", $numero);
        $pdoStatement->execute();
        $tableau = $pdoStatement->fetchAll();
        $listeTrajets = $this->hydrateAll($tableau);
        return $listeTrajets;
    }
    /**
     * @brief retourne toutes les informations d'un trajet en fonction de son numero
     *
     * @param integer $numero
     * @return Trajet
     */
    public function find(int $numero): Trajet
    {
        $sql="SELECT * FROM TRAJET WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Trajet');
        $trajet = $pdoStatement->fetch();

        return $trajet;
    }
    /**
     * @brief retourne toutes les informations des trajet
     *
     * @return array
     */
    public function findAll(): array{
        $sql="SELECT * FROM TRAJET";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $trajets = $pdoStatement->fetchAll();
        return $trajets;
    }
    /**
     * @brief retourne toutes les informations d'un trajet correspondant au numero d'un conducteur
     *
     * @param integer $numero
     * @return array
     */
    public function findAllByConducteur(int $numero): array{
        $sql="SELECT * FROM TRAJET WHERE numero_conducteur = :numero_conducteur";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero_conducteur", $numero);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $trajets = $pdoStatement->fetchAll();
        return $trajets;
    }
    /**
     * @brief retourn le nombre de passager par trajet
     *
     * @return array
     */
    public function getAllNombreReservations(): array{
        $sql="SELECT T.numero, COUNT(C.numero_passager) AS nbPassagers FROM TRAJET T LEFT JOIN CHOISIR C ON T.numero = C.numero_trajet GROUP BY T.numero;";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $trajets = $pdoStatement->fetchAll();
        return $trajets;
    }
    /**
     * @brief supprime un trajet avec son numero
     *
     * @param integer $numero
     * @return void
     */
    public function delete(int $numero): void{
        // En raison des contraintes, on supprime d'abord le trajet dans la table choisir
        $sql="DELETE FROM CHOISIR WHERE numero_trajet = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero",$numero);
        $pdoStatement->execute();

        // On supprime ensuite le trajet dans la table TRAJET
        $sql="DELETE FROM TRAJET WHERE numero = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero",$numero);
        $pdoStatement->execute();
    }
    /**
     * @brief remplie un trajet avec les informations du tableau
     *
     * @param array $tableauAssoc
     * @return Trajet|null
     */
    public function hydrate(array $tableauAssoc): ?Trajet
    {
        $trajet = new Trajet($tableauAssoc['numero'],$tableauAssoc['heureDep'],$tableauAssoc['heureArr'],$tableauAssoc['prix'],$tableauAssoc['dateDep'],$tableauAssoc['nbPlace'],$tableauAssoc['numero_conducteur'],$tableauAssoc['numero_lieu_depart'],$tableauAssoc['numero_lieu_arrivee']);
        return $trajet;
    }
    /**
     * @brief 
     *
     * @param [type] $tableau
     * @return array|null
     */
    public function hydrateAll($tableau): ?array{
        $trajets = [];
        foreach($tableau as $tableauAssoc){
            $trajets[] = $this->hydrate($tableauAssoc);
        }
        return $trajets;
    }

    /**
     * @brief retourne la liste des trajets trier par heure de depart
     *
     * @param string $num_lieu_depart
     * @param string $num_lieu_arrivee
     * @param string $date
     * @param integer $nbPassager
     * @return array
     */
    public function findTrajetParHeure(string $num_lieu_depart, string $num_lieu_arrivee, string $date, int $nbPassager): array
    {
        $requete = "SELECT T.numero, T.heureDep, T.nbPlace, T.heureArr, T.prix, T.dateDep, T.nbPlace,T.numero_conducteur, T.numero_lieu_depart, T.numero_lieu_arrivee FROM TRAJET T WHERE numero_lieu_depart IN " . $num_lieu_depart . " AND numero_lieu_arrivee IN " . $num_lieu_arrivee . " AND dateDep = ? AND nbPlace >= " . $nbPassager . " ORDER BY T.heureDep ASC";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, $date, PDO::PARAM_STR);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $pdoStatement->fetchAll();
        $listeTrajet = $this->hydrateAll($tableau);
        return $listeTrajet;
    }
    /**
     * @brief retourne la liste des trajets par prix
     *
     * @param string $num_lieu_depart
     * @param string $num_lieu_arrivee
     * @param string $date
     * @param integer $nbPassager
     * @return array
     */
    public function findTrajetTrieeParPrix(string $num_lieu_depart, string $num_lieu_arrivee, string $date, int $nbPassager): array
    {
        $requete = "SELECT T.numero, T.heureDep, T.nbPlace, T.heureArr, T.prix, T.dateDep,T.numero_conducteur, T.nbPlace, T.numero_lieu_depart, T.numero_lieu_arrivee FROM TRAJET T WHERE numero_lieu_depart IN " . $num_lieu_depart . " AND numero_lieu_arrivee IN " . $num_lieu_arrivee . " AND dateDep = ? AND nbPlace > " . $nbPassager . " ORDER BY T.prix ASC" ;
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, $date, PDO::PARAM_STR);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $pdoStatement->fetchAll();
        $listeTrajet = $this->hydrateAll($tableau);
        return $listeTrajet;
    }
    /**
     * @brief retourne toutes les informations necessaire sur la page de reponse a une offre
     *
     * @param integer $numero
     * @return arrayss
     */
    public function findTrajet(int $numero): Trajet
    {
        $requete = "SELECT T.numero, T.heureDep, T.nbPlace, T.heureArr, T.prix, T.dateDep, T.nbPlace, T.numero_conducteur, T.numero_lieu_depart,T.numero_lieu_arrivee FROM TRAJET T WHERE " . $numero . " = T.numero;";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $pdoStatement->fetch();
        $infoTrajet = $this->hydrate($tableau);
        return $infoTrajet;
    }
    /**
     * @brief insert un trajet dans la base de données
     *
     * @param string|null $heureDep
     * @param string|null $heureArr
     * @param integer|null $prix
     * @param string|null $dateDep
     * @param integer|null $nbPlace
     * @param integer|null $numero_conducteur
     * @param integer|null $numero_lieu_depart
     * @param integer|null $numero_lieu_arrivee
     * @return void
     */
    public function insert(?string $heureDep = null,?string $heureArr = null,?float $prix = null,?string $dateDep = null,?int $nbPlace = null,?int $numero_conducteur = null,?int $numero_lieu_depart = null,?int $numero_lieu_arrivee = null): void
    {
        $query = $this->PDO->prepare("INSERT INTO TRAJET(heureDep, heureArr, prix, dateDep, nbPlace, numero_conducteur, numero_lieu_depart, numero_lieu_arrivee) VALUES (:heureDep, :heureArr, :prix, :dateDep, :nbPlace, :numero_conducteur, :numero_lieu_depart, :numero_lieu_arrivee)");
        
        $query->bindParam(':heureDep', $heureDep);
        $query->bindParam(':heureArr', $heureArr);
        $query->bindParam(':prix', $prix);
        $query->bindParam(':dateDep', $dateDep);
        $query->bindParam(':nbPlace', $nbPlace);
        $query->bindParam(':numero_conducteur', $numero_conducteur);
        $query->bindParam(':numero_lieu_depart', $numero_lieu_depart);
        $query->bindParam(':numero_lieu_arrivee', $numero_lieu_arrivee);

        $query->execute();
    }
    /**
     * @brief modifie un trajet dans la base de données 
     *
     * @param integer|null $numero
     * @param string|null $heureDep
     * @param string|null $heureArr
     * @param integer|null $prix
     * @param string|null $dateDep
     * @param integer|null $numero_lieu_depart
     * @param integer|null $numero_lieu_arrivee
     * @return void
     */
    public function update(?int $numero = null, ?string $heureDep = null,?string $heureArr = null,?int $prix = null,?string $dateDep = null,?int $numero_lieu_depart = null,?int $numero_lieu_arrivee = null)
    {
        $query = $this->PDO->prepare("UPDATE TRAJET SET heureDep = :heureDep, heureArr = :heureArr, prix = :prix, dateDep = :dateDep, numero_lieu_depart = :numero_lieu_depart, numero_lieu_arrivee = :numero_lieu_arrivee WHERE numero = :numero");
        $query->bindParam(':numero', $numero);
        $query->bindParam(':heureDep', $heureDep);
        $query->bindParam(':heureArr', $heureArr);
        $query->bindParam(':prix', $prix);
        $query->bindParam(':dateDep', $dateDep);
        $query->bindParam(':numero_lieu_depart', $numero_lieu_depart);
        $query->bindParam(':numero_lieu_arrivee', $numero_lieu_arrivee);
        $query->execute();
    }
    /**
     * @brief retourne le numero du conducteur d'un trajet en particulier
     *
     * @param integer $numero
     * @return integer
     */
    public function getConducteur(int $numero): int{
        $sql = "SELECT numero_conducteur FROM TRAJET WHERE numero = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero", $numero);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        return $pdoStatement->fetch()[0];
    }

    public function findAllRue() 
    { 
        $sql = "SELECT numero, numRue, nomRue, ville FROM LIEU"; 
        $pdoStatement = $this->PDO->prepare($sql); 
        $pdoStatement->execute(); 
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC); 
        $tableau = $pdoStatement->fetchAll(); 
        $lieu = $this->hydrateAll($tableau); 
        return $lieu; 

    } 

    public function decrementerNbPlace(?int $numTrajet, ?int $nbPassager)
    {
        $sql = "UPDATE TRAJET SET nbPlace = nbPlace - :nbPassager WHERE numero = :numTrajet";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":nbPassager", $nbPassager);
        $pdoStatement->bindParam(":numTrajet", $numTrajet);
        $pdoStatement->execute();
    }

    public function findAllNbPlaceReserve(): array
    {
        $sql = "SELECT numero_trajet, numero_passager, nbPlaceReserve FROM CHOISIR";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC); 
        $nbPlaceReserve = $pdoStatement->fetchAll(); 
        return $nbPlaceReserve;
    }

    public function trajetDejaReserver($idTrajet, $numEtudiant): bool
    {
        $sql = "SELECT COUNT(numero_trajet) AS nbReserve FROM CHOISIR WHERE numero_trajet = :numTrajet AND numero_passager = :numPassager";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(':numTrajet', $idTrajet);
        $pdoStatement->bindParam(':numPassager', $numEtudiant);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC); 
        $bool = $pdoStatement->fetch(); 
        if ($bool['nbReserve'] >= 1) {
            $bool = true;
        }
        else {
            $bool = false;
        }
        return $bool;
    }

    public function incrementationNbPlace($numTrajet, $numPassager, $nbPassager)
    {
        $sql = "UPDATE CHOISIR SET nbPlaceReserve = nbPlaceReserve + :nbPassager WHERE numero_trajet = :numTrajet AND numero_passager = :numPassager";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(':numTrajet', $numTrajet);
        $pdoStatement->bindParam(':numPassager', $numPassager);
        $pdoStatement->bindParam(':nbPassager', $nbPassager);
        $pdoStatement->execute();
    }

    public function annuler($numTrajet){
        $sql = "DELETE FROM CHOISIR WHERE numero_trajet = :numTrajet";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(':numTrajet', $numTrajet);
        $pdoStatement->execute();
    }
}