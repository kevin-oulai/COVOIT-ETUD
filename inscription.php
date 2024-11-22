<?php 
//ajout de l’autoload de composer
require_once 'include.php';

$template = $twig->load('inscription.html.twig');

echo $template->render(array(
   ));

   $pdo = Bd::getInstance()->getConnexion();
   $query = "SELECT COUNT(numero) FROM ETUDIANT";
   $pdoStatement = $pdo->prepare($query);
   $pdoStatement->execute();
   $nbNum = $pdoStatement->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
   $nbNum[0]++;
   if(isset($_POST["Nom"]))
   {
      $query = "INSERT INTO ETUDIANT(numero,nom,prenom,dateNaiss,adresseMail,numTelephone,numero_voiture,motDePasse) VALUES ((?),(?),(?),(?),(?),(?),NULL,(?) )";
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


   