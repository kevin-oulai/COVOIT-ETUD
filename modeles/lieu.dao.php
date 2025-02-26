<?php
/**
* @file    lieu.dao.php
* @author  Thibault ROSALIE

* @brief Classe LieuDao pour gérer les lieux dans la base de données
* 
* @details Cette classe permet de gérer les lieux dans la base de données
* 
* La connexion est représenté par l'objet PDO de PHP

* @version 0.1
* @date    14/11/2024
*/

class LieuDao{

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
     * @brief retourne toutes les informations d'un lieu via son numero
     *
     * @param integer $numero
     * @return Lieu
     */
    public function find(int $numero): Lieu
    {
        $sql="SELECT * FROM LIEU WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Lieu');
        $lieu = $pdoStatement->fetch();

        return $lieu;
    }
    /**
     * @brief retourne toutes les informations de tout les trajets
     *
     * @return array|null
     */
    public function findAllAssoc(): ?array
    {
        $sql="SELECT * FROM LIEU";
        $pdoStatement = $this->PDO->prepare($sql); 
        $pdoStatement->execute(); 
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC); 
        $tableau = $pdoStatement->fetchAll(); 
        $lieu = $this->hydrateAll($tableau); 

        return $lieu;
    }
    /**
     * @brief verifie si un lieu existe ou pas
     *
     * @param integer $numRue
     * @param string $nomRue
     * @param string $ville
     * @return boolean
     */
    public function existe(int $numRue, string $nomRue, string $ville): bool
    {
        $sql="SELECT count(*) FROM LIEU WHERE numRue= :numRue AND nomRue= :nomRue AND ville= :ville";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numRue"=>$numRue, ":nomRue"=>$nomRue, ":ville"=>$ville));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $count = $pdoStatement->fetch();
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }
    /**
     * @brief permet d'inserer un lieu dans la base de données
     *
     * @param integer|null $numRue
     * @param string|null $nomRue
     * @param string|null $ville
     * @return void
     */
    public function insert(?int $numRue = null,?string $nomRue = null,?string $ville = null): void
    {
        $query = $this->PDO->prepare("INSERT INTO LIEU(numRue, nomRue, ville) VALUES (:numRue, :nomRue, :ville)");

        $query->bindParam(':numRue', $numRue);
        $query->bindParam(':nomRue', $nomRue);
        $query->bindParam(':ville', $ville);
        
        $query->execute();
    }
    /**
     * @brief retourne le numero d'un lieu grace aux parametres de la fonction
     *
     * @param integer|null $numRue
     * @param string|null $nomRue
     * @param string|null $ville
     * @return integer
     */
    public function findNum(?int $numRue = null,?string $nomRue = null,?string $ville = null): int
    {
        $sql="SELECT numero FROM LIEU WHERE numRue= :numRue AND nomRue= :nomRue AND ville= :ville";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numRue"=>$numRue, ":nomRue"=>$nomRue, ":ville"=>$ville));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $num = $pdoStatement->fetch()[0];

        return $num;
    }
    /**
     * @brief permet de remplir un lieu avec les informations du tableau
     *
     * @param array $tableauAssoc
     * @return Lieu|null
     */
    public function hydrate(array $tableauAssoc): ?Lieu
    {
        $lieu = new Lieu($tableauAssoc['numero'], $tableauAssoc['numRue'], $tableauAssoc['nomRue'], $tableauAssoc['ville']);
        return $lieu;
    }
    /**
     * @brief permet de remplir plusieurs lieux avec les informations du tableau
     *
     * @param [type] $tableau
     * @return array|null
     */
    public function hydrateAll($tableau): ?array{
        $lieux = [];
        foreach($tableau as $tableauAssoc){
            $lieu = $this->hydrate($tableauAssoc);
            $lieux[] = $lieu;
        }
        return $lieux;
    }
    /**
     * @brief retourne le numero des lieux correspondant a une ville
     *
     * @param string $ville
     * @return array|null
     */
    public function findNumByVille(string $ville): ?array
    {
        $sql="SELECT numero FROM LIEU WHERE ville= :ville";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":ville"=>$ville));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $lieu = $pdoStatement->fetchAll();

        return $lieu;
    }

}
