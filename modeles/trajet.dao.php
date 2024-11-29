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

    public function find(int $numero): Trajet
    {
        $sql="SELECT * FROM TRAJET WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Trajet');
        $trajet = $pdoStatement->fetch();

        return $trajet;
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
}