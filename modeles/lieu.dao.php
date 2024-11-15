<?php

/**
 * @brief Classe LieuDao pour gérer les lieux dans la base de données
 * 
 * @details Cette classe permet de gérer les lieux dans la base de données
 * 
 * La connexion est représenté par l'objet PDO de PHP
 */

class LieuDao{

    // Attributs
    private ?PDO $PDO;

    // Constructeur
    /**
     * @brief Constructeur de la classe LieuDao
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


}
