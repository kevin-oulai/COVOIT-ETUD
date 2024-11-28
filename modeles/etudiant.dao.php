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
    public function find(int $numero): Etudiant
    {
        $sql="SELECT * FROM ETUDIANT WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
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

    public function ajoutEtudiant(string $nom,string $prenom,string $mail,string $tel,bool $resul)
    {
        $pdo = Bd::getInstance()->getConnexion();
        $query = "SELECT COUNT(numero) FROM ETUDIANT";
        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->execute();
        $nbNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT); 
        print($nbNum[0]);
        $nbNum[0]++;
        if(isset($_POST["Nom"]))
        {

            if ($resul == true)
            {
                $query = "INSERT INTO ETUDIANT(numero,nom,prenom,dateNaiss,adresseMail,numTelephone,numero_voiture,motDePasse) VALUES ((?),(?),(?),(?),(?),(?),'1',(?) )";
                $pwd = password_hash($_POST["pwd"],PASSWORD_DEFAULT);
            $date = date($_POST["dateNaiss"]);
            $pdoStatement = $pdo->prepare($query);
            $pdoStatement->bindValue(1, $nbNum[0], PDO::PARAM_INT);
            $pdoStatement->bindValue(2, $_POST["Nom"], PDO::PARAM_STR);
            $pdoStatement->bindValue(3, $_POST["Prenom"], PDO::PARAM_STR);
            $pdoStatement->bindValue(4,  $date, PDO::PARAM_STR);
            $pdoStatement->bindValue(5, $_POST["mail"], PDO::PARAM_STR);
            $pdoStatement->bindValue(6, $_POST["tel"], PDO::PARAM_STR);
            $pdoStatement->bindValue(7, $pwd, PDO::PARAM_STR);
            $pdoStatement->execute();
            echo "<meta http-equiv='refresh' content='0;url=connexion.php' />";
            }
            else
            {
                echo '<body onLoad="alert(\'Mail deja utilisé\')">';
                // puis on le redirige vers la page d'accueil
                echo '<meta http-equiv="refresh" content="0;URL=index.php?controleur=inscription&methode=afficher">';
            }
    }
    }
}
