<?php
/**
 * @file    etudiant.dao.php
 * @author  Thibault ROSALIE
 * @brief Classe EtudiantDao pour gérer les étudiants dans la base de données
 *
 * @details Cette classe permet de gérer les étudiants dans la base de données
 *
 * La connexion est représenté par l'objet PDO de PHP
 * @version 0.1
 * @date    14/11/2024
 */
class EtudiantDao
{
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
     * @brief Retourne un étudiant à partir de son numéro
     *
     * @param int $numero
     * @return Etudiant
     */
    public function find(?int $numero): ?Etudiant
    {
        $sql="SELECT * FROM ETUDIANT WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();
        return $etudiant;
    }



    /**
     * @brief retourne toutes les informations des étudiants
     *
     * @return array|null
     */
    public function findAllAssoc(): ?array
    {
        $sql="SELECT * FROM ETUDIANT";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $pdoStatement->fetchAll();
        $infoEtud = $this->hydrateAll($tableau);
        return $infoEtud;
    }

    public function hydrate(array $tableauAssoc): ?Etudiant
    {
        $etudiant = new Etudiant($tableauAssoc['numero'], $tableauAssoc['nom'], $tableauAssoc['prenom'], $tableauAssoc['dateNaiss'], $tableauAssoc['adresseMail'], $tableauAssoc['numTelephone'], $tableauAssoc['numero_voiture'], $tableauAssoc['photoProfil'], $tableauAssoc['expiration_token']);
        return $etudiant;
    }

    public function hydrateAll($tableau): ?array{
        $etudiants = [];
        foreach($tableau as $tableauAssoc){
            $etudiant = $this->hydrate($tableauAssoc);
            $etudiants[] = $etudiant;
        }
        return $etudiants;
    }

    /**
     * @brief retourne le nombre de trajet n'un étudiant
     * @param integer|null $numero_etudiant
     * @return INT|null
     */
    public function findNbTrajets(?int $numero_etudiant): ?INT
    {
        $sql="SELECT COUNT(T.NUMERO) FROM TRAJET T JOIN ETUDIANT E ON T.NUMERO_CONDUCTEUR = E.NUMERO WHERE E.numero= $numero_etudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $nbTrajet = $pdoStatement->fetchColumn();
        return $nbTrajet;
    }
    /**
     * @brief retourne vrai si l'etudiant a un badge
     *
     * @param integer|null $numero_etudiant
     * @return boolean|null
     */
    public function possedeBadge(?int $numero_etudiant): ?bool
    {
        $sql="SELECT COUNT(numero_badge) FROM OBTENIR WHERE numero_etudiant = :numero ";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero", $numero_etudiant);
        $pdoStatement->execute();
        $count = $pdoStatement->fetch();
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }
    /**
     * @brief retourne vrai si l'etudiant a commenté
     *
     * @param integer|null $numero_etudiant
     * @return boolean|null
     */
    public function aPosteAvis(?int $numero_etudiant): ?bool
    {
        $sql="SELECT COUNT(numero) FROM AVIS WHERE numero_commentateur = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero", $numero_etudiant);
        $pdoStatement->execute();
        $count = $pdoStatement->fetch();
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }
    /**
     * @brief retourne vrai si l'etudiant a reçu un avis
     *
     * @param integer|null $numero_etudiant
     * @return boolean|null
     */
    public function aRecuAvis(?int $numero_etudiant): ?bool
    {
        $sql = "SELECT COUNT(numero) FROM AVIS WHERE numero_concerne = :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->bindParam(":numero", $numero_etudiant);
        $pdoStatement->execute();
        $count = $pdoStatement->fetch();
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }
    /**
     * @brief Permet d'ajouter un étudiant à la bd avec les informations en paramètre.
     *
     * @param string $nom
     * @param string $prenom
     * @param string $mail
     * @param string $tel
     * @param string $image
     * @param string $dateNaiss
     * @param string $mdp
     * @return void
     */
    public function insert(string $nom, string $prenom, string $mail, string $tel, string $image, string $dateNaiss, string $mdp)
    {
        $date = date($dateNaiss);
        $query = $this->PDO->prepare("INSERT INTO ETUDIANT(nom, prenom, dateNaiss, adresseMail, numTelephone, numero_voiture, photoProfil, motDePasse, token_reinitialisation, expiration_token) VALUES (:nom, :prenom, :dateNaiss, :mail, :tel, NULL, :image, :mdp, NULL, NULL)");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':prenom', $prenom);
        $query->bindParam(':dateNaiss', $date);
        $query->bindParam(':mail', $mail);
        $query->bindParam(':tel', $tel);
        $query->bindParam(':image', $image);
        $query->bindParam(':mdp', $mdp);
        $query->execute();
    }
    /**
     * @brief permet de modifier le profil d'un étudiant
     *
     * @param integer|null $numero
     * @param string|null $nom
     * @param string|null $prenom
     * @param string|null $dateNaiss
     * @param string|null $mail
     * @param string|null $tel
     * @param integer|null $numVoiture
     * @param string|null $image
     * @return void
     */
    public function update(?int $numero = null, ?string $nom = null,?string $prenom = null,?string $dateNaiss = null,?string $mail = null,?string $tel = null,?int $numVoiture = null,?string $image = null){
        $query = $this->PDO->prepare("UPDATE ETUDIANT SET nom = :nom, prenom = :prenom, dateNaiss = :dateNaiss, adresseMail = :adresseMail, numTelephone = :numTelephone, numero_voiture = :numero_voiture, photoProfil = :photoProfil WHERE numero = :numero");
        $query->bindParam(':numero', $numero);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':prenom', $prenom);
        $query->bindParam(':dateNaiss', $dateNaiss);
        $query->bindParam(':adresseMail', $mail);
        $query->bindParam(':numTelephone', $tel);
        $query->bindParam(':numero_voiture', $numVoiture);
        $query->bindParam(':photoProfil', $image);
        $query->execute();
    }

    public function getToken(?string $token){
        $query = $this->PDO->prepare('SELECT * FROM ETUDIANT WHERE token_reinitialisation = :token');
        $query->bindParam('token', $token);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $query->fetch();
        return $this->hydrate($tableau);
    }

    public function updateMdp(?int $numero = null,?string $mdp = null){
        $query = $this->PDO->prepare("UPDATE ETUDIANT SET motDePasse = :mdp WHERE numero = :numero");
        $query->bindParam(':numero', $numero);
        $query->bindParam(':mdp', $mdp);
        $query->execute();
    }
    
    public function delete(int $numero)
    {
        $query = $this->PDO->prepare("SELECT * FROM TRAJET WHERE numero_conducteur = :numero");
        $query->bindParam(':numero', $numero);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $tableau = $query->fetchAll();
        for($i=0; $i< sizeof($tableau) ; $i++)
        {
            $query = $this->PDO->prepare("DELETE FROM CHOISIR WHERE numero_trajet = :numero");
            $query->bindParam(':numero', $tableau[$i].getNuemero());
            $query->execute();
        }

        $query = $this->PDO->prepare("DELETE FROM CHOISIR WHERE numero_passager = :numero");
        $query->bindParam(':numero', $numero);
        $query->execute();

        $query = $this->PDO->prepare("DELETE FROM TRAJET WHERE numero_conducteur = :numero");
        $query->bindParam(':numero', $numero);
        $query->execute();



}

}
