<?php 
//ajout de l’autoload de composer
require_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();

echo $template->render(array(
    'listeLieux'=>$listeLieux
   ));
=======
// echo $template->render(array(
//    ));
try {
   if (isset($_GET['controleur'])) {
      $controleurName = $_GET['controleur'];
   }else {
      $controleurName = "";
   }
   if (isset($_GET['methode'])) {
      $methode = $_GET['methode'];
   }
   else {
      $methode = "";
   }
   if ($controleurName == "" && $methode == "") {
      $controleurName = "trajet";
      $methode = "lister";
   }
   if ($controleurName == "") {
      throw new Exception("Le controleur n'est pas defini");
   }
   if ($methode == "") {
      throw new Exception("La methode n'est pas defini");
   }
   $controleur = ControllerFactory::getController($controleurName, $loader, $twig);

   $controleur->call($methode);
} catch (Exception $e) {
   die("Erreur : ".$e->getMessage());
}
