<?php
require_once 'include.php';


// on teste si nos variables sont définies
 if (isset($_POST['login']) && isset($_POST['pwd'])) {

   $pdo = Bd::getInstance()->getConnexion();
   $query = "SELECT motDePasse, numero, numero_voiture FROM ETUDIANT WHERE adresseMail = '" . $_POST['login'] . "'";
   $pdoStatement = $pdo->prepare($query);
   $pdoStatement->execute();
   $result = $pdoStatement->fetch(PDO::FETCH_NUM);
   $verifMDP = password_verify($_POST['pwd'],$result[0]);

   // on vérifie les informations saisies
   if ($verifMDP) {
       // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (
       $_SESSION['login'] = $_POST['login'];
       $_SESSION['pwd'] = $_POST['pwd'];
       $_SESSION['id'] = $result[1];
       if(!is_null($result[2])){
           $_SESSION['voiture'] = $result[2];
       }
       else{
           $_SESSION['voiture'] = null;
       }
       //on redirige notre visiteur vers une page de notre section membre
       echo "<meta http-equiv='refresh' content='0;url=index.php' />";
    }
   else {
       session_destroy();
       echo '<body onLoad="alert(\'Membre non reconnu...\')">';
       // puis on le redirige vers la page d'accueil
       echo '<meta http-equiv="refresh" content="0;URL=connexion.php">';
   }
}