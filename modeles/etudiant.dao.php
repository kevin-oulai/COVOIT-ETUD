<?php

/**
 * @brief Classe EtudiantDao pour gérer les étudiants dans la base de données
 * 
 * @details Cette classe permet de gérer les étudiants dans la base de données
 * 
 * La connexion est représenté par l'objet PDO de PHP
 */

class EtudiantDao
{
    // Attributs
    private ?PDO $PDO;

    // Constructeur
    /**
     * @brief Constructeur de la classe EtudiantDao
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

    // Méthodes
    /**
     * @brief Retourne un étudiant à partir de son numéro
     *
     * @param int $numero
     * @return Etudiant
     */
    public function find(int $numero): Etudiant
    {
        $sql="SELECT * FROM ETUDIANT WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
    }
}
