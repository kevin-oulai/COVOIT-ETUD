<?php

class ControllerConnexion extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

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
                        // Connexion à la base de données
                        $baseDeDonnees = BD::getInstance();
                        $pdo = $baseDeDonnees->getConnexion();

                        // Vérification du token et récupération de l'utilisateur
                        $requete = $pdo->prepare(
                            'SELECT numero, expiration_token FROM ETUDIANT WHERE token_reinitialisation = :token'
                        );
                        $requete->execute(['token' => htmlspecialchars($token)]);
                        $etudiant = $requete->fetch(PDO::FETCH_ASSOC);

                        if (!$etudiant) {
                            $listeErreurs[] = 'le token invalide';
                            $valide = false;
                        }

                        // Vérification de la validité temporelle du token
                        if ($valide) {
                            $expiration = strtotime($etudiant['expiration_token']);
                            if ($expiration < time()) {
                                $listeErreurs[] = 'le token à expiré';
                                $valide = false;
                            }
                        }
                        if ($valide) {
                            // Hachage du nouveau mot de passe
                            $passwordHache = password_hash($password, PASSWORD_DEFAULT);

                            //Mise à jour du mot de passe en BD
                            $requete = $pdo->prepare(
                                'UPDATE ETUDIANT 
                                 SET motDePasse = :password, token_reinitialisation = NULL, expiration_token = NULL 
                                 WHERE numero = :numero'
                            );
                            $requete->execute([
                                'password' => $passwordHache,
                                'numero' => $etudiant['numero'],
                            ]);
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

    public function mdpOublie(){
        $template = $this->getTwig()->load('motdepasseoublie.html.twig');
        $listeErreurs = array();
        echo $template->render(array(
        ));

        // Vérification que le formulaire a été soumis via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Récupération de l'email soumis via le formulaire
            $email = $_POST['email'] ?? '';

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

                // Simuler l'envoi d'un email en affichant un lien fictif
                $lienReinitialisation = "?controleur=connexion&methode=reinitialisation_mdp&token=$token";

                echo "<div class=\"modal fade\" id=linkModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true style=\"backdrop-filter: blur(2px)\">
                                <div class=\"modal-dialog modal-dialog-centered modal-lg\" role=document>
                                    <div class=\"modal-content bg-gradient-primary border-2\">
                                    <div class='modal-title ms-3 mt-4'>Réinitialisation</div>
                                    <hr>
                                        <div class='modal-body text-break'>
                                            <p>Votre lien de réinitialisation : </p>
                                            <a href='$lienReinitialisation'>$lienReinitialisation</a>
                                        </div>
                                        <div class=modal-footer>
                                            <button type=button class='btn btn-primary' onclick=\"location = '$lienReinitialisation';\">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id=linkModalTrigger></div>";
            }
            catch (Exception $e)
            {
                // Gestion des erreurs (par exemple, utilisateur introuvable)
                $listeErreurs[] = $e->getMessage();
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
            // Si le fichier est accédé directement sans soumission du formulaire
             //echo "<meta http-equiv='refresh' content='0;url=?controleur=connexion&methode=afficher' />";
            exit;
        }
    }

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
}