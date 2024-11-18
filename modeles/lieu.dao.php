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

    public function find(int $numero): Lieu
    {
        $sql="SELECT * FROM LIEU WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Lieu');
        $lieu = $pdoStatement->fetch();

        return $lieu;
    }
    public function findAllAssoc(){
        $sql="SELECT * FROM LIEU";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $lieu = $pdoStatement->fetchAll();
        return $lieu;
    }

    public function hydrate(array $tableauAssoc): ?Lieu
    {
        $lieu = new Lieu();
        $lieu->setNumero($tableauAssoc['numero']);
        $lieu->setNumRue($tableauAssoc['numRue']);
        $lieu->setNomRue($tableauAssoc['nomRue']);
        $lieu->setVille($tableauAssoc['ville']);
        return $lieu;
    }

    public function hydrateAll($tableau): ?array{
        $lieux = [];
        foreach($tableau as $tableauAssoc){
            $lieu = $this->hydrate($tableauAssoc);
            $lieux[] = $lieu;
        }
        return $lieux;
    }

}
