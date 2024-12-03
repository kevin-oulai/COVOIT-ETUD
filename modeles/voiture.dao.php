<?php

/**
 * @brief Classe VoitureDao pour gérer les voitures dans la base de données
 * 
 * @details Cette classe permet de gérer les voitures dans la base de données
 * 
 * La connexion est représenté par l'objet PDO de PHP
 */

class VoitureDao {

    // Attributs
    /**
     * @brief Objet PDO de connexion à la base de données
     *
     * @var PDO|null
     */
    private ?PDO $PDO;

    // Constructeur
    /**
     * @brief Constructeur de la classe VoitureDao
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

    public function find(int $numero): Voiture
    {
        $sql="SELECT * FROM VOITURE WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Voiture');
        $voiture = $pdoStatement->fetch();

        return $voiture;
    }

    public function findMonEtudiant(int $numero_etudiant): Voiture
    {
        $sql="SELECT * FROM VOITURE V JOIN ETUDIANT E ON V.NUMERO = E.NUMERO_VOITURE WHERE E.numero= :numero_etudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_etudiant"=>$numero_etudiant));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Voiture');
        $voiture = $pdoStatement->fetch();

        return $voiture;
    }
}