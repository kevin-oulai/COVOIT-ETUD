<?php
/**
* @file    avis.dao.php
* @author  Thibault ROSALIE

* @brief Classe AvisDao pour gérer les avis dans la base de données
* 
* @details Cette classe permet de gérer les avis dans la base de données
* 
* La connexion est représenté par l'objet PDO de PHP
* 
* Les étudiants concernés et commentateurs sont représentés par
* un objet Etudiant.
*          
* @version 0.1
* @date    10/01/2025
*/

class AvisDao{
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

    // Méthodes
    /**
     * @brief Trouve un avis dans la base de données
     *
     * @param int|null $numero
     * @return Avis|null
     */
    public function find(?int $numero): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    /**
     * @brief Trouve tous les avis dans la base de données
     *
     * @return array
     */
    public function findAllConcerne(?int $numero_concerne): array
    {
        $requete = "SELECT A.*, E.nom as nomEtudiant, E.prenom as prenomEtudiant from AVIS A join ETUDIANT E on A.numero_commentateur = E.numero WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $listeAvisConcerne = $pdoStatement->fetchAll();
        return $listeAvisConcerne;
    }

    /**
     * @brief Trouve tous les avis dans la base de données
     *
     * @return array
     */
    public function findAllCommentateur(?int $numero_commentateur): array
    {
        $requete = "SELECT A.*, E.nom as nomEtudiant, E.prenom as prenomEtudiant from AVIS A join ETUDIANT E on A.numero_concerne = E.numero WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $listeAvisCommentateur = $pdoStatement->fetchAll();
        return $listeAvisCommentateur;
    }

    /**
     * @brief Insère un avis dans la base de données
     *
     * @param string $datePost
     * @param string $message
     * @param int $note
     * @param int $concerne
     * @param int $commentateur
     * @return void
     */
    public function insert($datePost, $message, $note, $concerne, $commentateur): void
    {
        $query = $this->PDO->prepare("INSERT INTO AVIS(datePost, message, note, numero_concerne, numero_commentateur) VALUES (:datePost, :message, :note, :numero_concerne, :numero_commentateur)");

        $query->bindParam(':datePost', $datePost);
        $query->bindParam(':message', $message);
        $query->bindParam(':note', $note);
        $query->bindParam(':numero_concerne', $concerne);
        $query->bindParam(':numero_commentateur', $commentateur);
        
        $query->execute();
    }
  
    /**
     * @brief Retourne un avis via son numéro
     *
     * @param int $numero_concerne
     * @return Avis
     */
    public function findConcerne(?int $numero_concerne): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    /**
     * @brief Retourne un commentateur via son numéro
     *
     * @param int $numero_commentateur
     * @return Avis
     */
    public function findCommentateur(?int $numero_commentateur): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }
}