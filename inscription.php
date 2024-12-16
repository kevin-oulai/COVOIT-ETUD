<?php 
//ajout de l’autoload de composer
require_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();
$query = "SELECT COUNT(numero) FROM ETUDIANT";
$pdoStatement = $pdo->prepare($query);
$pdoStatement->execute();
$nbNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
$nbNum[0]++;
if(isset($_POST["Nom"]))
{
    $managerEtudiant = new EtudiantDAO($pdo);
    $mailValide = $managerEtudiant->verifMail($_POST["mail"]);
    if($mailValide){
        $pwd = password_hash($_POST["pwd"],PASSWORD_DEFAULT);
        $date = date($_POST["dateNaiss"]);
        $dir = "images"; // Nom du dossier contenant les photos
        $name = "photoProfilParDefaut.png";
        if(is_uploaded_file($_FILES["image"]["tmp_name"])){
            $name = rand(0,2147483647) . ".png";
            move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
        }
        $managerEtudiant->ajoutEtudiant($_POST["Nom"],$_POST["Prenom"],$_POST["mail"],$_POST["tel"],$name);
        echo '<meta http-equiv="refresh" content="0;URL=connexion.php">';
    }
    else {
        echo '<body onLoad="alert(\'Mail deja utilisé\')">';
        // puis on le redirige vers la page d'accueil
        echo '<meta http-equiv="refresh" content="0;URL=inscription.php">';
    }
}

    $template = $twig->load('inscription.html.twig');
    echo $template->render(array(
    ));