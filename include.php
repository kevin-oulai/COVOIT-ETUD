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
require_once 'controllers/controller_backOffice.class.php';
require_once 'controllers/controller_etudiant.class.php';
require_once 'controllers/controller_inscription.class.php';
require_once 'controllers/controller_factory.class.php';
require_once 'controllers/controller_paiement.class.php';
require_once 'controllers/controller_connexion.class.php';
require_once 'controllers/controller_badge.class.php';

//Ajout des modeles
require_once 'modeles/administrateur.class.php';
require_once 'modeles/administrateur.dao.php';
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

//Ajout des validations de formulaires
require_once 'fonctionValidation/fonctionsValidation.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

