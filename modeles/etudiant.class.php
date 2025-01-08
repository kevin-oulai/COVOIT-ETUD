<?php
/**
* @file    avis.class.php
* @author  Candice Dutournier

* @brief   Classe Etudiant pour représenter les étudiants.
*
* @details Cette classe permet de gérer les informations d'un étudiant, telles que 
* le numero (identifiant), le nom, le prénom, la date de naissance, l'adresse mail, le numéro de téléphone
* et le numéro de la voiture de l'étudiant.
* 
* Le numéro de voiture d'un étudiant est représentés par
* un objet Voiture.
*          
* @version 0.1
* @date    14/11/2024

*/

class Etudiant {
    //attributs
    /**
     * @brief Numéro de l'étudiant.
     * @var integer|null
     */
    private int|null $numero;
    /**
     * @brief Nom de l'étudiant.
     * @var string|null
     */
    private string|null $nom;
    /**
     * @brief Prénom de l'étudiant.
     * @var string|null
     */
    private string|null $prenom;
    /**
     * @brief Date de naissance de l'étudiant.
     * @var string|null
     */
    private string|null $dateNaiss;
    /**
     * @brief Adresse mail de l'étudiant.
     * @var string|null
     */
    private string|null $adresseMail;
    /**
     * @brief Numéro de téléphone de l'étudiant.
     * @var string|null
     */
    private string|null $numTelephone;
    /**
     * @brief Numéro de la voiture de l'étudiant (seul un étudiant qui possède une voiture peut être conducteur et donc proposer des trajets).
     * @var integer|null
     */
    private int|null $numero_voiture;

    /**
     * @brief Chemin d'acces de la photo de profil de l'étudiant
     * @var string|null
     */
    private string|null $photoProfil;

    //constructeur
    /**
     * @brief Constructeur de la classe étudiant.
     *
     * @param integer|null $numero Identifiant de l'étudiant.
     * @param string|null $nom Nom de l'étudiant.
     * @param string|null $prenom Prénom de l'étudiant.
     * @param string|null $dateNaiss Date de naissance de l'étudiant.
     * @param string|null $adresseMail Adresse mail de l'étudiant.
     * @param string|null $numTelephone Numéro de téléphone de l'étudiant.
     * @param integer|null $numero_voiture Numéro de la voiture de l'étudiant.
     * @param string|null $photoProfil Chemin d'acces de la photo de profil de l'étudiant
     */
    public function __construct(?int $numero=null, ?string $nom = null, ?string $prenom = null, ?string $dateNaiss = null, ?string $adresseMail = null, ?string $numTelephone = null, ?int $numero_voiture = null, ?string $photoProfil = null) {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaiss = $dateNaiss;
        $this->adresseMail = $adresseMail;
        $this->numTelephone = $numTelephone;
        $this->numero_voiture = $numero_voiture;
        $this->photoProfil = $photoProfil;
    }

    //getters & setters
    /**
     * @brief
     * @return integer|null
     */
    public function getNumero(): ?int
    {
        return $this->numero;
    }

    /**
     * @brief Assigne un numéro à l'étudiant
     * @param integer|null $numero
     * @return void
     */
    public function setNumero(?int $numero): void
    {
        $this->numero = $numero;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getDateNaiss(): ?string
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(?string $dateNaiss): void
    {
        $this->dateNaiss = $dateNaiss;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(?string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(?string $numTelephone): void
    {
        $this->numTelephone = $numTelephone;
    }

    public function getNumeroVoiture(): ?int
    {
        return $this->numero_voiture;
    }

    public function setNumeroVoiture(?int $numero_voiture): void
    {
        $this->numero_voiture = $numero_voiture;
    }

    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(?string $photoProfil): void
    {
        $this->photoProfil = $photoProfil;
    }

    public function genererTokenReinitialisation(): string
    {
        // Connexion à la base de données
        $baseDeDonnees = BD::getInstance();
        $pdo = $baseDeDonnees->getConnexion();

        // Vérification de l'existence de l'utilisateur
        $requete = $pdo->prepare('SELECT numero FROM ETUDIANT WHERE adresseMail = :email');
        $requete->execute(['email' => $this->adresseMail]);
        $etudiant = $requete->fetch(PDO::FETCH_ASSOC);

        if (!$etudiant)
        {
                throw new Exception("Utilisateur introuvable");
        }

        // Génération d'un token unique
        $token = bin2hex(random_bytes(32));

        // Le token sera valide pendant 1 heure à partir de sa génération :
        $dateExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Mémorisation du token et de sa date d'expiration en BD
        $requete = $pdo->prepare(
            'UPDATE ETUDIANT SET token_reinitialisation = :token, expiration_token = :expiration 
             WHERE adresseMail = :email'
        );
        $requete->execute([
            'token' => $token,
            'expiration' => $dateExpiration,
            'email' => $this->adresseMail,
        ]);

        return $token;
    }

    public function verifEmail()
    {
        $baseDeDonnees = BD::getInstance();
        $pdo = $baseDeDonnees->getConnexion();

        $sql="SELECT COUNT(*) FROM ETUDIANT WHERE adressemail = :mail";
        $pdoStatement = $pdo->prepare($sql);
        var_dump($this->adresseMail);
        $pdoStatement->execute(array(":mail"=>$this->adresseMail));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $count = $pdoStatement->fetch();
        echo "$count[0]";
        if($count[0]<1)
        {
            return true;
        }
        return false;
    }
}