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

}