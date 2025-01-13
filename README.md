# COVOIT-ETUD
Covoit'etud est une application de covoiturage dédiée aux étudiants, leur permettant de se connecter facilement, de partager des trajets, et de réduire leurs frais de déplacement tout en contribuant à une mobilité plus durable.

Diagramme des classes
+---------------------+
|       Lieu          |
+---------------------+
| - numero           |
| - numRue           |
| - nomRue           |
| - ville            |
+---------------------+

+---------------------+
|      Voiture        |
+---------------------+
| - numero           |
| - nom              |
| - marque           |
| - nombrePlace      |
+---------------------+

+---------------------+
|       Badge         |
+---------------------+
| - numero           |
| - titre            |
| - image            |
+---------------------+

+---------------------+
|       Trajet        |
+---------------------+
| - numero           |
| - heureDep         |
| - heureArr         |
| - prix             |
| - dateDep          |
| - nbPlace          |
| - numero_conducteur|
+---------------------+

+---------------------+
|       Avis          |
+---------------------+
| - numero           |
| - message          |
| - note             |
| - numero_conducteur|
| - numero_commentateur |
+---------------------+

+---------------------+
|      Étudiant       |
+---------------------+
| - numero           |
| - nom              |
| - prenom           |
| - dateNaiss        |
| - adresseMail      |
| - numTelephone     |
| - numero_voiture   |
+---------------------+

+---------------------+
|      choisir        |
+---------------------+
| - numero_trajet    |
| - numero_passager  |
+---------------------+

+---------------------+
|      obtenir        |
+---------------------+
| - numero_etudiant  |
| - numero_badge     |
+---------------------+

+---------------------+
|      disposer       |
+---------------------+
| - numero_trajet    |
| - numero_lieu_depart |
| - numero_lieu_arrivee |
+---------------------+


Architecture technique
Base de données : MySql
Hebérgement : Lakatxela
IDE : Visual Studio Code

Technologie utilisé
Visual Studio Code
Twig
Php
Html
Bootstrap
JavaScript
YAML

Utilisation
Pour utiliser les fonctionalité de l'application il faut créer un compte.
Puis si vous êtes conducteur vous pouvez proposer un trajet ou alors si vous ne possedez pas de voiture répondre à une offre de trajet

