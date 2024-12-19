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
    public function find(?int $numero): ?Etudiant
    {
        $sql="SELECT * FROM ETUDIANT WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
    }


    public function findAllAssoc(): ?array
    {
        $sql="SELECT * FROM ETUDIANT";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        return $pdoStatement->fetchAll();
    }


    public function findNbTrajets(?int $numero_etudiant): ?INT
    {
        $sql="SELECT COUNT(T.NUMERO) FROM TRAJET T JOIN ETUDIANT E ON T.NUMERO_CONDUCTEUR = E.NUMERO WHERE E.numero= $numero_etudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $nbTrajet = $pdoStatement->fetchColumn();

        return $nbTrajet;
    }

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

    public function verifMail(string $mail): bool
    {
        $resul = false;
        $sql="SELECT COUNT(*) FROM ETUDIANT WHERE adressemail = :mail";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":mail"=>$mail));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $count = $pdoStatement->fetch();
        if($count[0]<1)
        {
            $resul = true;
        }
        return $resul;
    }

    public function ajoutEtudiant(string $nom,string $prenom,string $mail,string $tel, string $image,string $dateNaiss, string $mdp, string $salt)
    {
        $pdo = Bd::getInstance()->getConnexion();
        $query = "SELECT COUNT(numero) FROM ETUDIANT";
        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->execute();
        $nbNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
        $nbNum[0]++;

        $query = "INSERT INTO ETUDIANT(numero,nom,prenom,dateNaiss,adresseMail,numTelephone,numero_voiture,photoProfil,motDePasse,token_reinitialisation,expiration_token,salt) VALUES ((?),(?),(?),(?),(?),(?),NULL,(?),(?),NULL,NULL,(?) )";

        $pwd = password_hash($mdp,PASSWORD_DEFAULT);
        $date = date($dateNaiss);

        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->bindValue(1, $nbNum[0], PDO::PARAM_INT);
        $pdoStatement->bindValue(2, $nom, PDO::PARAM_STR);
        $pdoStatement->bindValue(3, $prenom, PDO::PARAM_STR);
        $pdoStatement->bindValue(4, $date, PDO::PARAM_STR);
        $pdoStatement->bindValue(5, $mail, PDO::PARAM_STR);
        $pdoStatement->bindValue(6, $tel, PDO::PARAM_STR);
        $pdoStatement->bindValue(7, $image, PDO::PARAM_STR);
        $pdoStatement->bindValue(8, $pwd, PDO::PARAM_STR);
        $pdoStatement->bindValue(9, $salt, PDO::PARAM_STR);
        $pdoStatement->execute();
    }

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
}
