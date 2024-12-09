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

    public function findConcerneParAvis(?int $numero_commentateur): ?Etudiant
    {
        $sql="SELECT * FROM ETUDIANT E JOIN AVIS A ON E.NUMERO = A.NUMERO_CONCERNE WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
    }

    public function findCommentateurDAvis(?int $numero_concerne): ?Etudiant
    {
        $sql="SELECT * FROM ETUDIANT E JOIN AVIS A ON E.NUMERO = A.NUMERO_COMMENTATEUR WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
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

    public function estConducteur(?int $numero_etudiant): ?bool
    {
        $sql="SELECT COUNT(numero) FROM ETUDIANT WHERE numero = :numero AND numero_voiture != NULL";
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
        $sql="SELECT COUNT(numero) FROM AVIS WHERE numero_concerne = :numero";
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

    public function ajoutEtudiant(string $nom,string $prenom,string $mail,string $tel, string $image)
    {
        $pdo = Bd::getInstance()->getConnexion();
        $query = "SELECT COUNT(numero) FROM ETUDIANT";
        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->execute();
        $nbNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
        $nbNum[0]++;

        $query = "INSERT INTO ETUDIANT(numero,nom,prenom,dateNaiss,adresseMail,numTelephone,numero_voiture,photoProfil,motDePasse) VALUES ((?),(?),(?),(?),(?),(?),'1',(?),(?) )";

        $pwd = password_hash($_POST["pwd"],PASSWORD_DEFAULT);
        $date = date($_POST["dateNaiss"]);

        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->bindValue(1, $nbNum[0], PDO::PARAM_INT);
        $pdoStatement->bindValue(2, $nom, PDO::PARAM_STR);
        $pdoStatement->bindValue(3, $prenom, PDO::PARAM_STR);
        $pdoStatement->bindValue(4,  $date, PDO::PARAM_STR);
        $pdoStatement->bindValue(5, $mail, PDO::PARAM_STR);
        $pdoStatement->bindValue(6, $tel, PDO::PARAM_STR);
        $pdoStatement->bindValue(7, $image, PDO::PARAM_STR);
        $pdoStatement->bindValue(8, $pwd, PDO::PARAM_STR);
        $pdoStatement->execute();
    }
}
