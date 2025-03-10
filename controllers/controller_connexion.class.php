<?php
/**
* @file    controller_connexion.class.php
* @author  Birembaux Théo

* @brief   Classe ControllerConnexion s'occupe de gérer l'ouverture des vues concernant la page de connexion
*     
*/

class ControllerConnexion extends Controller{
    /**
     * @brief Permet de créer l'instance du controller
     *
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     */
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    /**
     * @brief Affiche la page connexion et vérifie si le login et le mot de passe correspondent
     *
     * @return void
     */

    public function afficher(){
        $template = $this->getTwig()->load('connexion.html.twig');

        if(isset($_GET['origin'])){
            if($_GET['origin'] == "reinitialisationMdp") {
                $password = $_POST['pwd'] ?? '';
                $passwordConfirm = $_POST['confirmationPwd'] ?? '';
                $token = $_POST['token'] ?? '';
                $valide = true;
                $listeErreurs = array();

                // Validation des champs
                if (empty($token)) {
                    $listeErreurs[] = 'token invalide.';
                    $valide = false;
                }

                // Vérification de la correspondance des mots de passe
                if (($password !== $passwordConfirm)) {
                    $listeErreurs[] = 'Les mots de passes ne correspondent pas.';
                    $valide = false;
                }

                if(!validerMdp($password, $listeErreurs)){
                    $valide = false;
                }

                if ($valide){
                    try {
                        $managerEtudiant = new EtudiantDao($this->getPdo());
                        $etudiant = $managerEtudiant->getToken(htmlspecialchars($token));

                        if (!$etudiant) {
                            $listeErreurs[] = 'le token invalide';
                            $valide = false;
                        }

                        // Vérification de la validité temporelle du token
                        if ($valide) {
                            $valide = $etudiant->validerToken($listeErreurs);
                        }
                        if ($valide){
                            $passwordHache = password_hash($password, PASSWORD_DEFAULT);
                            //Mise à jour du mot de passe en BD
                            $etudiant->MAJMotDePasse($passwordHache);
                        }
                    } catch (Exception $e) {
                        $listeErreurs[] = $e->getMessage();
                        $valide = false;
                    }
                    echo $template->render(array(
                        'reinitialisation' => $valide
                    ));
                }
                else{
                    $url = '<meta http-equiv="refresh" content="0;URL=?controleur=connexion&methode=reinitialisation_mdp&token=' . $token;
                    foreach($listeErreurs as $erreur){
                        $url .= '&erreur=' . $erreur;
                    }
                    $url .= '">';
                    echo $url;
                }
            }
            else{
                echo $template->render(array(
                ));
            }
        }
        else{
            echo $template->render(array(
            ));
        }
    }
    /**
     * @brief permet d'afficher la page qui gere la reinitialisation du mot de passe lorsqu'il est oublié
     *
     * @return void
     */
    public function mdpOublie(){
        $template = $this->getTwig()->load('motdepasseoublie.html.twig');
        $listeErreurs = array();
        echo $template->render();

        // Vérification que le formulaire a été soumis via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Récupération de l'email soumis via le formulaire
            $email = $_POST['mail'] ?? '';

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Vérifier que la chaîne récupérée a bien la forme d'un email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $listeErreurs[] = 'Adresse mail invalide.';
            }

            try
            {
                // Création d'une instance de la classe Etudiant

                $etudiant = new Etudiant(null,null,null,null, $email);

                // Génération du token de réinitialisation
                $token = $etudiant->genererTokenReinitialisation();
                $to = $email;
                $subject = "Reinitialisation de votre mot de passe";
                $message = "<!DOCTYPE html>
                <html lang='fr'>
                  <head>
                    <meta charset='UTF-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    <title>Réinitialisation de Mot de Passe</title>
                    <style>
                      body {
                          font-family: Arial, sans-serif;
                          background-color: #6b97fd;
                          margin: 0;
                          padding: 0;
                      }
                      .container {
                          width: 100%;
                          max-width: 600px;
                          margin: 20px auto;
                          background-color: #c5d7ff;
                          padding: 20px;
                          border-radius: 8px;
                          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                      }
                      .header {
                          text-align: center;
                          color: #333333;
                      }
                      .content {
                          font-size: 16px;
                          color: #555555;
                          line-height: 1.5;
                      }
                      .button {
                          display: inline-block;
                          padding: 12px 24px;
                          background-color: #4357BD;
                          color: white !important;
                          text-decoration: none;
                          border-radius: 7px;
                          margin-top: 20px;
                          text-align: center;
                      }
                      
                      .button:hover{
                        text-decoration: none;
                      }
                      
                      .footer {
                          font-size: 14px;
                          color: #777777;
                          text-align: center;
                          margin-top: 30px;
                      }
                    </style>
                  </head>
                  <body>
                    <div class='container'>
                      <div class='header'>
                        <h2>Réinitialisation de votre mot de passe</h2>
                      </div>
                      <div class='content'>
                        <p>Bonjour,</p>
                        <p>
                          Nous avons reçu une demande pour réinitialiser le mot de passe associé
                          à votre compte. Si vous êtes à l'origine de cette demande, veuillez
                          cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :
                        </p>
                        <a
                          href='http://lakartxela.iutbayonne.univ-pau.fr/~koulai001/SAE/COVOIT-ETUD/?controleur=connexion&methode=reinitialisation_mdp&token=$token'
                          class='button'
                          >Réinitialiser mon mot de passe</a
                        >
                        <p>
                          Si vous n'avez pas fait cette demande, ignorez simplement ce message.
                          Votre mot de passe restera inchangé.
                        </p>
                        <p>Cordialement, <br />L'équipe de COVOIT'ETUD</p>
                      </div>
                      <div class='footer'>
                        <p>
                          Si vous avez des questions, contactez notre support à
                          <a href='mailto:covoit-etud@gmail.com'>covoit-etud@gmail.com</a>.
                        </p>
                      </div>
                    </div>
                  </body>
                </html>";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <covoit-etud@gmail.com>' . "\r\n";

                // Envoi de l'email
//                mail($to, $subject, $message, $headers);
               
                //Recipients
                

                //Content


                //echo "<div id=sentModalTrigger></div>";

            }
            catch (Exception $e)
            {
                // Gestion des erreurs (par exemple, utilisateur introuvable)
                echo $mail->ErrorInfo;
            }
            if(!empty($listeErreurs)){
                echo "<div class=\"modal fade\" id=errorModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true style=\"backdrop-filter: blur(2px)\">
                                <div class=\"modal-dialog modal-dialog-centered\" role=document>
                                    <div class=\"modal-content bg-gradient-danger border-2\">
                                    <div class='modal-title ms-3 mt-4'>Attention !</div>
                                    <hr>
                                        <div class=modal-body>
                                            <p>Erreurs :</p>
                                            <ul>";
                foreach($listeErreurs as $erreur){
                    echo "<li>$erreur</li>";
                }
                echo "</ul>
                                        </div>
                                        <div class=modal-footer>
                                            <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=trajet&methode=enregistrer';\">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id=errorModalTrigger></div>";
            }
        }
        else
        {
            exit;
        }
    }
    /**
     * @brief Affiche le formulaire pour changer le mot de passe
     *
     * @return void
     */
    public function reinitialisation_mdp(){
        $erreur = "";
        if(isset($_GET['erreur'])){
            $erreur = $_GET['erreur'];
        }
        // Vérification de la présence du token dans l'URL
        if (!isset($_GET['token']))
        {
            $erreur = 'token inexistant';
        }

        // Récupération et nettoyage du token
        $token = htmlspecialchars($_GET['token']); // Nettoyage pour éviter des failles XSS

        // Vérification de la validité du token
        try
        {
            // Connexion à la base de données
            $baseDeDonnees = BD::getInstance();
            $pdo = $baseDeDonnees->getConnexion();

            // Recherche du token en base de données
            $requete = $pdo->prepare(
                'SELECT numero, expiration_token FROM ETUDIANT WHERE token_reinitialisation = :token'
            );
            $requete->execute(['token' => $token]);
            $etudiant = $requete->fetch(PDO::FETCH_ASSOC);

            if (!$etudiant)
            {
                $erreur = 'token invalide.';
            }

            // Vérification de la date d'expiration du token
            $expiration = strtotime($etudiant['expiration_token']);
            if ($expiration < time())
            {
                $erreur = 'token expiré.';
            }
        }
        catch (Exception $e)
        {
            $erreur = $e->getMessage();
        }

        // Si le token est valide, afficher le formulaire pour définir un nouveau mot de passe
        $template = $this->getTwig()->load('reinitialisation_mdp.html.twig');
        echo $template->render(array(
            'token' => $token,
            'erreur' => $erreur
        ));
    }
    /**
     * @brief Ouvre une session si l'étudiant à réussi à se connecter
     *
     * @return void
     */
    public function login()
    {
        if (isset($_POST['login']) && isset($_POST['pwd'])) {
            $connexionFalse = True;
            $etudiant = new Etudiant(null, null, null, null, $_POST['login']);
            $administrateur = new Administrateur(null, $_POST['login']);
            
            // on vérifie les informations saisies
            if ($etudiant->log($_POST['pwd'])) {
                $pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
                $managerEtudiant = new EtudiantDao($pdo);
                $_SESSION['CLIENT'] = $managerEtudiant->find($etudiant->getNumero());
                $_SESSION['ADMIN'] = false;
                //on redirige notre visiteur vers une page de notre section membre
                echo "<meta http-equiv='refresh' content='0;url=index.php' />";
             }
            else if($administrateur->log($_POST['pwd'])){
                    $pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $managerEtudiant = new EtudiantDao($pdo);
                    $_SESSION['CLIENT'] = $managerEtudiant->find(0);
                    $_SESSION['ADMIN'] = true;
                    //Redirection
                    echo "<meta http-equiv='refresh' content='0;url=index.php' />";
            }
            else{
                session_destroy();
                // Redirection vers la page d'accueil
                $connexionFalse = False;
                $template = $this->getTwig()->load('connexion.html.twig');
                echo $template->render(array(
                    'connexionFalse' => $connexionFalse
                ));  
            }
        }
    }
}