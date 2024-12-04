<?php

/**
 * @brief Classe TrajetDao pour gérer les trajets dans la base de données
 * 
 * @details Cette classe permet de gérer les trajets dans la base de données
 * 
 * La connexion est représenté par l'objet PDO de PHP
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

    public function findAllByPassager(int $numero): array
    {
        $requete = "SELECT T.* FROM TRAJET T JOIN CHOISIR C ON T.NUMERO = C.NUMERO_TRAJET WHERE C.NUMERO_PASSAGER = :numero";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(":numero", $numero);
        $pdoStatement->execute();
        $listeTrajets = $pdoStatement->fetchAll();
        return $listeTrajets;
    }

    public function find(int $numero): Trajet
    {
        $sql="SELECT * FROM TRAJET WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Trajet');
        $trajet = $pdoStatement->fetch();

        return $trajet;
    }

    public function findAll(string $num_lieu_depart, string $num_lieu_arrivee, string $date, int $nbPassager): array
    {
        $requete = "SELECT T.heureDep, T.heureArr, T.prix, T.dateDep, T.nbPlace, L1.ville AS villeArr, L1.numRue AS numRueArr, L1.nomRue AS nomRueArr, L2.ville AS villeDep, L2.numRue AS numRueDep, L2.nomRue AS nomRueDep FROM TRAJET T LEFT JOIN LIEU L1 ON L1.numero = T.numero_lieu_arrivee LEFT JOIN LIEU L2 ON L2.numero = T.numero_lieu_depart WHERE numero_lieu_depart IN " . $num_lieu_depart . " AND numero_lieu_arrivee IN " . $num_lieu_arrivee . " AND dateDep = ? AND nbPlace > " . $nbPassager . "";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, $date, PDO::PARAM_STR);
        $pdoStatement->execute();
        $listeTrajet = $pdoStatement->fetchAll();
        return $listeTrajet;
    }

    public function hydrate(array $tab): Trajet
    {
        $trajet = new Trajet();
    }
        
    public function insert(?string $heureDep = null,?string $heureArr = null,?int $prix = null,?int $nbPlace = null,?int $numero_conducteur = null,?int $numero_lieu_depart = null,?int $numero_lieu_arrivee = null): void
    {
        $sql = "SELECT COUNT(numero) FROM TRAJET";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $newNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
        $newNum[0]++;
        $dateDep = "2024-11-06";
        $query = $this->PDO->prepare("INSERT INTO TRAJET(numero,heureDep, heureArr, prix, dateDep, nbPlace, numero_conducteur, numero_lieu_depart, numero_lieu_arrivee) VALUES (:numero, :heureDep, :heureArr, :prix, :dateDep, :nbPlace, :numero_conducteur, :numero_lieu_depart, :numero_lieu_arrivee)");
        $query->bindParam(':numero', $newNum[0]);
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

    public function getConducteur(int $numero): int{
        $sql = "SELECT numero_conducteur FROM TRAJET WHERE numero = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero", $numero);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        return $pdoStatement->fetch()[0];
    }
}