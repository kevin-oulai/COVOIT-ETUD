<?php
/**
* @file    badge.dao.php
* @author  Thibault ROSALIE

* @brief La classe BadgeDao permet de gérer les informations des badges des étudiants.
* 
* @details Elle permet de gérer les badges en base de données.

* @version 0.1
* @date    10/01/2025
*/
class BadgeDao{
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
     * @brief Permet de trouver un badge en fonction du numéro de l'étudiant
     *
     * @param int $numeroEtudiant
     * @return Badge|null
     */
    public function find(int $numeroEtudiant): ?Badge
    {
        $sql="SELECT * FROM BADGE B JOIN OBTENIR O ON B.NUMERO = O.NUMERO_BADGE WHERE numero_etudiant= :numeroEtudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numeroEtudiant"=>$numeroEtudiant));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Badge');
        $badge = $pdoStatement->fetch();

        return $badge;
    }

    /**
     * @brief Permet de trouver tous les badges en fonction du numéro de l'étudiant
     *
     * @param int|null $numero_etudiant
     * @return array
     */
    public function findAll(?int $numero_etudiant): array
    {
        $requete = "SELECT B.numero, B.titre, B.image from BADGE B join OBTENIR O on B.numero = O.numero_badge WHERE numero_etudiant= :numero_etudiant";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_etudiant"=>$numero_etudiant));
        $tableau = $pdoStatement->fetchAll();
        $listeAvisCommentateur = $this->hydrateAll($tableau);
        return $listeAvisCommentateur;
    }

    public function hydrate(array $tableauAssoc): ?Badge
    {
        $badge = new Badge($tableauAssoc['numero'], $tableauAssoc['titre'], $tableauAssoc['image']);
        return $badge;
    }

    public function hydrateAll($tableau): ?array{
        $badges = [];
        foreach($tableau as $tableauAssoc){
            $badge = $this->hydrate($tableauAssoc);
            $badges[] = $badge;
        }
        return $badges;
    }
}