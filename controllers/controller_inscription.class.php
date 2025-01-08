<?php

class ControllerInscription extends Controller
{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    public function afficher()
    {
        if (isset($_POST["Nom"]) && isset($_POST["Prenom"]) && isset($_POST["mail"]) && isset($_POST["tel"])) {
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
                $salt = bin2hex(random_bytes(16));
                $managerEtudiant = new EtudiantDAO($this->getPdo());
                    $pwd = password_hash($salt . $_POST["pwd"], PASSWORD_DEFAULT);
                    $date = date($_POST["dateNaiss"]);
                    $dir = "images"; // Nom du dossier contenant les photos
                    $name = "photoProfilParDefaut.png";
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        $name = rand(0, 2147483647) . ".png";
                        move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
                    }
                    $managerEtudiant->ajoutEtudiant($_POST["Nom"], $_POST["Prenom"], $_POST["mail"], $_POST["tel"], $name, $_POST["dateNaiss"], $pwd,$salt);
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