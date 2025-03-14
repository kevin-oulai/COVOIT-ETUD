<?php
/**
* @file    etudiant.class.php
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

#[\AllowDynamicProperties]
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
    /**
     * @brief Temps restant avant la fin de la validité du token
     * @var string|null
     */
    private string|null $expiration_token;

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
     * @param string|null $expiration_token Temps restant avant la fin de la validité du token
     */
    public function __construct(?int $numero=null, ?string $nom = null, ?string $prenom = null, ?string $dateNaiss = null, ?string $adresseMail = null, ?string $numTelephone = null, ?int $numero_voiture = null, ?string $photoProfil = null, ?string $expirationToken = null) {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaiss = $dateNaiss;
        $this->adresseMail = $adresseMail;
        $this->numTelephone = $numTelephone;
        $this->numero_voiture = $numero_voiture;
        $this->photoProfil = $photoProfil;
        $this->expiration_token = $expirationToken;
    }

    //getters & setters
    /**
     * @brief
     * @return integer|null
     */
    public function getNumero(): ?int
    {
        if($this->numero){
            return $this->numero;
        }
        else{
            $pdo = Bd::getInstance()->getConnexion();
            $query = "SELECT numero FROM ETUDIANT WHERE adresseMail = '". $this->getAdresseMail() ."'";
            $pdoStatement = $pdo->prepare($query);
            $pdoStatement->execute();
            $result = $pdoStatement->fetch(PDO::FETCH_NUM);
            return $result[0];
        }
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
    /**
     * @brief retourne le nom d'un étudiant
     *
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }
    /**
     * @brief Assigne un nouveau nom a l'étudiant
     *
     * @param string|null $nom
     * @return void
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }
    /**
     * retourne le prénom de l'étudiant
     *
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    /**
     * @brief Assigne un nouveau prénom a l'étudiant
     *
     * @param string|null $prenom
     * @return void
     */
    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }
    /**
     * @brief retourne la date de naissance de l'étudiant
     *
     * @return string|null
     */
    public function getDateNaiss(): ?string
    {
        return $this->dateNaiss;
    }
    /**
     * @brief Assigne une date de naissance a l'étudiant
     *
     * @param string|null $dateNaiss
     * @return void
     */
    public function setDateNaiss(?string $dateNaiss): void
    {
        $this->dateNaiss = $dateNaiss;
    }
    /**
     * @brief retourne l'adresse mail de l'étudiant
     *
     * @return string|null
     */
    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }
    /**
     * @brief Assigne une nouvelle adresse mail a l'étudiant
     *
     * @param string|null $adresseMail
     * @return void
     */
    public function setAdresseMail(?string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }
    /**
     * @brief retourne le numéro de téléphone de l'étudiant
     *
     * @return string|null
     */
    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }
    /**
     * @brief Assigne un nouveau numero de téléphone de l'étudiant
     *
     * @param string|null $numTelephone
     * @return void
     */
    public function setNumTelephone(?string $numTelephone): void
    {
        $this->numTelephone = $numTelephone;
    }
    /**
     * @brief retourne le numero de la voiture de l'étudiant
     *
     * @return integer|null
     */
    public function getNumeroVoiture(): ?int
    {
        return $this->numero_voiture;
    }
    /**
     * @brief Assigne un nouveau numero a la voiture de l'étudiant
     *
     * @param integer|null $numero_voiture
     * @return void
     */
    public function setNumeroVoiture(?int $numero_voiture): void
    {
        $this->numero_voiture = $numero_voiture;
    }
    /**
     * @brief retourne la photo de profil de l'étudiant
     *
     * @return string|null
     */
    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }
    /**
     * @brief Assigne une nouvelle photo de profil a l'étudiant
     *
     * @param string|null $photoProfil
     * @return void
     */
    public function setPhotoProfil(?string $photoProfil): void
    {
        $this->photoProfil = $photoProfil;
    }
    /**
     * @brief
     * @return string|null
     */
    public function getExpirationToken(): ?string
    {
        return $this->expiration_token;
    }

    /**
     * @brief Assigne un temps d'expiration au token
     * @param string|null $expirationToken
     * @return void
     */
    public function setExpirationToken(?int $expirationToken): void
    {
        $this->expiration_token = $expirationToken;
    }


    /**
     * @brief Génère un token de reinitialisation
     *
     * @return string
     */
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

    /**
     * @brief vérifie si le mail existe déjà dans la bd
     *
     * @return void
     */
    public function verifEmail()
    {
        $baseDeDonnees = BD::getInstance();
        $pdo = $baseDeDonnees->getConnexion();

        // Verification dans la table étudiant
        $sql="SELECT COUNT(*) FROM ETUDIANT WHERE adressemail = :mail";
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute(array(":mail"=>$this->adresseMail));
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $countEtudiant = $pdoStatement->fetch();

        // Verification dans la table administrateur
        $sql="SELECT COUNT(*) FROM ADMINISTRATEUR WHERE adresseMail = :mail";
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute(array(":mail"=>$this->adresseMail));
        $countAdmin = $pdoStatement->fetch();
        if($countAdmin[0]<1 && $countEtudiant[0]<1)
        {
            return true;
        }
        return false;
    }

    function validerToken(?array &$listeErreurs): bool{
        $expiration = strtotime($this->getExpirationToken());
        if ($expiration < time()) {
            $listeErreurs[] = 'le token a expiré';
            return false;
        }
        return true;
    }

    function MAJMotDePasse(?string $mdp): void{
        $baseDeDonnees = BD::getInstance();
        $pdo = $baseDeDonnees->getConnexion();

        $managerEtudiant = new EtudiantDao($pdo);
        $managerEtudiant->updateMdp($this->getNumero(), $mdp);
    }

    function log(?string $password): bool{
        $pdo = Bd::getInstance()->getConnexion();
        $query = "SELECT motDePasse FROM ETUDIANT WHERE adresseMail = '". $this->getAdresseMail() ."'";
        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->execute();
        $result = $pdoStatement->fetch(PDO::FETCH_NUM);
        if(!empty($result)) {
            return password_verify($_POST['pwd'], $result[0]);
        }
        return false;
    }

}