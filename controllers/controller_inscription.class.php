<?php
/**
* @file    controller_inscription.class.php
* @author  Birembaux Théo

* @brief   Classe ControllerInscription s'occupe de gérer l'ouverture des vues concernant la page d'inscription
*     
*/
class ControllerInscription extends Controller
{
    /**
     * @brief Permet de créer l'instance du controller
     *
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     */
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @brief Permet d'afficher la page d'inscription
     * 
     * @details Appelle la fonction pour ajouter l'étudiant et s'occupe du salage
     *
     * @return void
     */
    public function afficher()
    {
        if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) && isset($_POST["tel"])) {
            $messagesErreurs = [];
            
            $prenomValide = validerPrenom($_POST["Prenom"], $messagesErreurs);
            $nomValide = validerNom($_POST["Nom"], $messagesErreurs);
            $mailValide = validerMail($_POST["mail"], $messagesErreurs);
            $dateNaissanceValide = validerDateDeNaissance($_POST["dateNaiss"], $messagesErreurs);
            $telValide = validerTelephone($_POST["tel"], $messagesErreurs);
            $mdpValide = validerMdp($_POST["pwd"], $messagesErreurs);
            $photoValide = validerUploadEtPdp($_FILES["image"], $messagesErreurs);

            if(!empty($messagesErreurs)) {
                $template = $this->getTwig()->load('inscription.html.twig');

                echo $template->render(array(
                    'erreurs'=> $messagesErreurs,
                ));
            
            } else {
                    $managerEtudiant = new EtudiantDAO($this->getPdo());
                    $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                    $date = date($_POST["dateNaiss"]);
                    $dir = "images"; // Nom du dossier contenant les photos
                    $name = "photoProfilParDefaut.png";
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        $name = rand(0, 2147483647) . ".png";
                        move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
                    }
                    $managerEtudiant->insert($_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["tel"], $name, $_POST["dateNaiss"], $pwd);
                    $template = $this->getTwig()->load('connexion.html.twig');

                    echo $template->render(array(
                    ));
            }
        } else {
            $template = $this->getTwig()->load('inscription.html.twig');
            echo $template->render(array(
            ));
        }

    }
}