# COVOIT-ETUD
Covoit'etud est une application de covoiturage dédiée aux étudiants, leur permettant de se connecter facilement, de partager des trajets, et de réduire leurs frais de déplacement tout en contribuant à une mobilité plus durable.

Diagramme des classes

|  Voiture  |
| --- |
| - numero |
| - modele |
| - marque |
| - nbPlace |

|  Badge  |
|--- |
| - numero |
| - titre |
| - image |

|  Lieu  |
| --- |
| - numero |
| - numRue |
| - nomRue |
| - ville |

| Etudiant |
|--- |
| - numero         |
| - nom            |
| - prenom         |
| - dateNaiss      |
| - adresseMail    |
| - numTelephone   |
| - numero_voiture |
| - photoProfil |
| - motDePasse |
| - token_reinitialisation |
| - expiration_token |
| - salt |

|  Trajet  |
| --- |
| - numero |
| - heureDep |
| - heureArr |
| - prix |
| - dateDep |
| - nbPlace |
| - numero_conducteur |
| - numero_lieu_depart |
| - numero_lieu_arrivee |

|       Avis          |
| --- |
| - numero              |
| - datePost            |
| - message             |
| - note                |
| - numero_conducteur   |
| - numero_commentateur |

|      choisir        |
| --- |
| - numero_trajet    |
| - numero_passager  |

|      obtenir        |
| --- |
| - numero_etudiant  |
| - numero_badge     |

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

Documentation : https://kevin-oulai.github.io/COVOIT-ETUD/docs

Utilisation
Pour utiliser les fonctionalité de l'application il faut créer un compte.
Puis si vous êtes conducteur vous pouvez proposer un trajet ou alors si vous ne possedez pas de voiture répondre à une offre de trajet
