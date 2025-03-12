<?php
/**
* @file    administrateur.dao.php
* @author  Kevin Oulai

* @brief La classe AdministrateurDao permet de gérer les informations des administrateurs.
* 
* @details Elle permet de gérer les administrateurs en base de données.

* @version 0.1
* @date    10/03/2025
*/

class AdministrateurDao{
    // Attributs

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

    // Méthodes
    /**
     * @brief Permet de trouver un administrateur en fonction de son numéro
     *
     * @param int $numeroAdministrateur
     * @return Administrateur|null
     */
    public function find(int $numeroAdmistrateur): ?Administrateur
    {
        $sql="SELECT * FROM ADMINISTRATEUR WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numeroAdmistrateur));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Administrateur');
        $administrateur = $pdoStatement->fetch();

        return $administrateur;
    }

    /**
     * @brief Permet de trouver tous les administrateurs
     *
     * 
     * @return array
     */
    public function findAll(): array
    {
        $requete = "SELECT * FROM ADMINISTATEUR";
        $pdoStatement = $this->PDO->prepare($requete);
        $tableau = $pdoStatement->fetchAll();
        $listeAdministrateur = $this->hydrateAll($tableau);
        return $listeAdministrateur;
    }

    public function hydrate(array $tableauAssoc): ?Administrateur
    {
        $administrateur = new Administrateur($tableauAssoc['numero'], $tableauAssoc['adresseMail']);
        return $administrateur;
    }

    public function hydrateAll($tableau): ?array{
        $administrateurs = [];
        foreach($tableau as $tableauAssoc){
            $administrateur = $this->hydrate($tableauAssoc);
            $administrateurs[] = $administrateur;
        }
        return $administrateurs;
    }
}