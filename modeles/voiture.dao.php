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

    public function findByEtudiant(int $numero): Voiture
    {
        $sql="SELECT * FROM VOITURE WHERE numero in (SELECT numero_voiture FROM ETUDIANT WHERE numero = :numero)";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Voiture');
        $voiture = $pdoStatement->fetch();

        return $voiture;
    }

    public function findMonEtudiant(int $numero_etudiant): Etudiant
    {
        $sql="SELECT * FROM VOITURE V JOIN ETUDIANT E ON V.NUMERO = E.NUMERO_VOITURE WHERE E.numero= :numero_etudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_etudiant"=>$numero_etudiant));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $voiture = $pdoStatement->fetch();

        return $voiture;
    }

    public function findNum(?string $modele = null,?string $marque = null,?string $nbPlace = null): int
    {
        $sql="SELECT numero FROM VOITURE WHERE modele= :modele AND marque= :marque AND nbPlace= :nbPlace";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":modele"=>$modele, ":marque"=>$marque, ":nbPlace"=>$nbPlace));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $num = $pdoStatement->fetch()[0];

        return $num;
    }

    public function existe(?string $modele = null,?string $marque = null,?string $nbPlace = null): bool
    {
        $sql="SELECT count(*) FROM VOITURE WHERE modele= :modele AND marque= :marque AND nbPlace= :nbPlace";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":modele"=>$modele, ":marque"=>$marque, ":nbPlace"=>$nbPlace));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $count = $pdoStatement->fetch();
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }

    public function insert(?string $modele = null,?string $marque = null,?string $nbPlace = null): void
    {
        $sql = "SELECT COUNT(numero) FROM VOITURE";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $newNum = $pdoStatement->fetch(PDO::FETCH_NUM);
        $newNum[0]++;
        $query = $this->PDO->prepare("INSERT INTO VOITURE(numero, modele, marque, nbPlace) VALUES (:numero, :modele, :marque, :nbPlace)");
        $query->bindParam(':numero', $newNum[0]);
        $query->bindParam(':modele', $modele);
        $query->bindParam(':marque', $marque);
        $query->bindParam(':nbPlace', $nbPlace);
        $query->execute();
    }
}