<?php
require_once 'vendor/autoload.php';
require_once 'config/twig.php';
//Ajout du fichier constantes qui permet de configurer le site
require_once 'config/constantes.php';

//Ajout du modèle qui gère la connexion mysql
require_once 'modeles/bd.class.php';

//Ajout des controleurs
require_once 'controllers/controller.class.php';
require_once 'controllers/controller_trajet.class.php';
require_once 'controllers/controller_avis.class.php';
require_once 'controllers/controller_factory.class.php';

//Ajout des modeles
require_once 'modeles/avis.class.php';
require_once 'modeles/avis.dao.php';
require_once 'modeles/badge.class.php';
require_once 'modeles/badge.dao.php';
require_once 'modeles/etudiant.class.php';
require_once 'modeles/etudiant.dao.php';
require_once 'modeles/lieu.class.php';
require_once 'modeles/lieu.dao.php';
require_once 'modeles/trajet.class.php';
require_once 'modeles/trajet.dao.php';
require_once 'modeles/voiture.class.php';
require_once 'modeles/voiture.dao.php';
