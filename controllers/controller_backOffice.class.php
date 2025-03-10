<?php
/**
 * @file    controller_backOffice.class.php
 * @author  Candice Dutournier

 * @brief Classe ControllerBackOffice traite les informations envoyées et gére l'ouverture de la vue concernant le back office
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données des modèles et des vues
 *
 * @version 0.1
 * @date    26/02/2025
 */

class ControllerBackOffice extends Controller{
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
     * @brief Affiche la page du back office
     *
     * @return void
     */
    public function afficher(){
        $managerBadge = new BadgeDao($this->getPdo());
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $listeEtudiant = $managerEtudiant->findAllAssoc();
        $listeBadge = $managerBadge->findAllBadge();
        // Récupération des fichiers de backup
        $files = array_filter(scandir('./data/backup/'), function ($file) {
            return $file !== '.' && $file !== '..' && str_starts_with($file, "backup");
        });

        // Vérification si une restauration a été demandée
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectionBackup'])) {
            $message = $this->restaurerBackup($_POST['selectionBackup']);
        }

        $twigparams = array('badges' => $listeBadge, 'etudiants' => $listeEtudiant, 'files' => $files, 'message' => $message);
        if(isset($listeErreurs)){
            $twigparams['listeErreurs'] = $listeErreurs;
        }
        $template = $this->getTwig()->load('backOffice.html.twig');
        echo $template->render($twigparams);

        if(isset($_GET['action'])){
            if($_GET['action'] == "ajouter"){
                $messagesErreurs = [];
                if(isset($_POST["titre"])) {
                    $managerBadge = new BadgeDao($this->getPdo());
                    $titreValide = validerTitre($_POST["titre"], $messagesErreurs);
                    $descriptionValide = validerDescription($_POST["description"], $messagesErreurs);
                    $imageValide = validerUploadEtPdp($_FILES["image"], $messagesErreurs);
                    $categorieValide = validerCategorie($_POST["categorie"], $messagesErreurs);
                    $rangValide = validerRang($_POST["rang"], $messagesErreurs);

                    if(!empty($messagesErreurs)) {
                    
                    } else {
                            $dir = "images/assets"; // Nom du dossier contenant les photos
                            $name = "etoile-icon.png";
                            if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                                $name = $_FILES['image']["name"];
                                move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
                            }
                            $managerBadge->insert($_POST["titre"], $name, $_POST["description"], $_POST["categorie"], $_POST["rang"]);
        
                    }
                    echo "<div id=modalTrigger></div>";
                }
                else{
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
                                        <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=backOffice&methode=afficher';\">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id=errorModalTrigger></div>";
                                            
                }
            }
            elseif ($_GET['action'] == "modifier") {
                if (isset($_GET['id'])) {
                    $numero = $_GET['id'];
                    var_dump($numero);
                } else {
                    // Gérer l'erreur si 'id' n'est pas présent
                    echo "Le paramètre 'id' est manquant.";
                    exit;
                }
                $badge = $managerBadge->findBadge($numero);
                if ($badge === null) {
                    // Le badge n'existe pas, gérer l'erreur
                    echo "Le badge avec l'ID $numero n'a pas été trouvé.";
                    exit;
                }
                $messagesErreurs = [];
                var_dump($badge);

                validerTitre($_POST['titre'], $messagesErreurs);
                if (isset($_POST['description']) && isset($_POST["categorie"]) && isset($_POST["rang"])) {
                    validerDescription($_POST['description'], $messagesErreurs);
                    validerCategorie($_POST["categorie"], $messagesErreurs);
                    validerRang($_POST["rang"], $messagesErreurs);
                }
                var_dump($_POST['titre']);
                var_dump($_POST['categorie']);

                $nomPhoto = $badge->getImage();
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    validerUploadEtPdp($_FILES["image"], $messagesErreurs);
                    $image = $_FILES["image"]["tmp_name"];

                    if (empty($messagesErreurs)) {
                        $dir = "images/assets"; // Nom du dossier contenant les photos
                        $nomPhoto = $_FILES['image']["name"];
                        move_uploaded_file($image, "$dir/$nomPhoto");
                    }
                }
                var_dump($nomPhoto);

                if (!empty($messagesErreurs)) {
                    $template = $this->getTwig()->load('backOffice.html.twig');
                    
                    $twig_params['erreurs'] = $messagesErreurs;
                    $twig_params['badges'] = $listeBadge;

                } else {
                    $managerBadge->update($numero, $_POST['titre'], $nomPhoto, $_POST['description'], $_POST["categorie"], $_POST["rang"]);
                    echo "<div id=modalTriggerModif></div>";
                }
            }
            elseif ($_GET['action'] == "supprimer") {
                $numero = $_GET['id'];
                $managerBadge->delete($numero);
            }
        }
    }

    private function restaurerBackup($filename) {
        $path = "./data/backup/";
        $file = fopen($path . $filename, 'r');

        if (!$file) {
            return "Erreur : impossible d'ouvrir le fichier.";
        }

        while (!feof($file)) {
            $query = trim(fgets($file, 255));
            while (!str_ends_with($query, ";")) {
                $query .= trim(fgets($file, 255));
            }
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
            } catch (Exception $e) {
                fclose($file);
                return "Erreur lors de la restauration : " . $e->getMessage();
            }
        }
        fclose($file);
        return "La base de données a été restaurée avec succès.";
    }

}