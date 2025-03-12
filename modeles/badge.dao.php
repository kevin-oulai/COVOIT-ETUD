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
     * @brief Permet de trouver un badge en fonction de son numéro
     *
     * @param int $numero
     * @return Badge|null
     */
    public function findBadge(int $numero): ?Badge
    {
        $sql="SELECT * FROM BADGE B WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Badge');
        $badge = $pdoStatement->fetch();

        return $badge;
    }

    /**
     * @brief Permet de trouver tous les badges
     *
     * @param int|null $numero
     * @return array
     */
    public function findAllBadge(): array
    {
        $requete = "SELECT * from BADGE B";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $pdoStatement->fetchAll();
        $listeAvisCommentateur = $this->hydrateAll($tableau);
        return $listeAvisCommentateur;
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
        $requete = "SELECT * from BADGE B join OBTENIR O on B.numero = O.numero_badge WHERE numero_etudiant= :numero_etudiant";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_etudiant"=>$numero_etudiant));
        $tableau = $pdoStatement->fetchAll();
        $listeAvisCommentateur = $this->hydrateAll($tableau);
        return $listeAvisCommentateur;
    }

    public function hydrate(array $tableauAssoc): ?Badge
    {
        $badge = new Badge($tableauAssoc['numero'], $tableauAssoc['titre'], $tableauAssoc['image'], $tableauAssoc['description'], $tableauAssoc['categorie'], $tableauAssoc['rang']);
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

    public function getAll(): array {
        $requete = "SELECT * FROM BADGE ORDER BY rang";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->execute();

        $tableau = $pdoStatement->fetchAll();
        $listeBadges = $this->hydrateAll($tableau);

        return $listeBadges;
    }
    public function insert(string $titre, string $image, string $description, string $categorie, int $rang): void {
        $query = $this->PDO->prepare("INSERT INTO BADGE(titre, image, description, categorie, rang) VALUES (:titre, :image, :description, :categorie, :rang)");

        $query->bindParam(':titre', $titre);
        $query->bindParam(':image', $image);
        $query->bindParam(':description', $description);
        $query->bindParam(':categorie', $categorie);
        $query->bindParam(':rang', $rang);
        
        $query->execute();
    }

    /**
     * @brief permet de modifier un badge
     *
     * @param integer|null $numero
     * @param string|null $titre
     * @param string|null $description
     * @param string|null $image
     * @param string|null $categorie
     * @param int|null $rang
     * @return void
     */
    public function update(?int $numero = null, ?string $titre = null,?string $image = null,?string $description = null,?string $categrie = null,?int $rang = null){
        $query = $this->PDO->prepare("UPDATE BADGE SET titre = :titre, image = :image, description = :description, categorie = :categorie, rang = :rang WHERE numero = :numero");
        $query->bindParam(':numero', $numero);
        $query->bindParam(':titre', $titre);
        $query->bindParam(':image', $image);
        $query->bindParam(':description', $description);
        $query->bindParam(':categorie', $categorie);
        $query->bindParam(':rang', $rang);
        $query->execute();
    }

    public function delete(int $numero): void {
        $query1 = $this->PDO->prepare("DELETE FROM OBTENIR WHERE numero_badge= :numero");
        $query1->bindParam(":numero",$numero);
        $query1->execute();
        $query2 = $this->PDO->prepare("DELETE FROM BADGE WHERE numero= :numero");
        $query2->bindParam(":numero",$numero);
        $query2->execute();
    }
}