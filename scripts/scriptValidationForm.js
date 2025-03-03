function verifLogin() {
    // Variables locales
    loginCourant = document.getElementsByName('login')[0].value; // Mail en cours de saisie
    champErreur = document.getElementsByName('erreurLogin')[0];
    messageErreur = 'Format de mail invalide'; // Message d'erreur à afficher
    regexMail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/i; // Expression régulière pour le format du mail

    // Vérification du format du mail via une expression régulière
    mailValide = loginCourant.match(regexMail);

    // Mise à jour du champ de message d'erreur
    if (!mailValide && loginCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (mailValide || loginCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifMail() {
    // Variables locales
    mailCourant = document.getElementsByName('mail')[0].value; // Mail en cours de saisie
    champErreur = document.getElementsByName('erreurMail')[0];
    messageErreur = 'Format de mail invalide'; // Message d'erreur à afficher
    regexMail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/i; // Expression régulière pour le format du mail

    // Vérification du format du mail via une expression régulière
    mailValide = mailCourant.match(regexMail);

    // Mise à jour du champ de message d'erreur
    if (!mailValide && mailCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (mailValide || mailCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifMDP() {
    // Variables locales
    mdpCourant = document.getElementsByName('pwd')[0].value; // Mail en cours de saisie
    champErreur = document.getElementsByName('erreurMdp')[0];
    messageErreur = 'Le mot de passe doit contenir au moins une lettre, un chiffre et un symbole'; // Message d'erreur à afficher

    // Vérification du format du mot de passe via expressions régulières
    mdpValide = (mdpCourant.match(/[A-Za-z]/) && mdpCourant.match(/[0-9]/) && mdpCourant.match(/[\W_]/));

    // Vérification du format du mail via une expression régulière
    if (!mdpValide && mdpCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (mdpValide || mdpCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifPrenom() {
    // Variables locales
    prenomCourant = document.getElementsByName('prenom')[0].value; // Prénom en cours de saisie
    champErreur = document.getElementsByName('erreurPrenom')[0];
    messageErreur = 'Le prénom doit contenir au moins 2 caractères'; // Message d'erreur à afficher

    // Vérification de la longueur du prénom
    if (prenomCourant.length < 2 && prenomCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (prenomCourant.length >= 2 || prenomCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifNom() {
    // Variables locales
    nomCourant = document.getElementsByName('nom')[0].value; // Prénom en cours de saisie
    champErreur = document.getElementsByName('erreurNom')[0];
    messageErreur = 'Le nom doit contenir au moins 2 caractères'; // Message d'erreur à afficher

    // Vérification de la longueur du nom
    if (nomCourant.length < 2 && nomCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (nomCourant.length >= 2 || nomCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifTel() {
    // Variables locales
    telCourant = document.getElementsByName('tel')[0].value; // Telephone en cours de saisie
    champErreur = document.getElementsByName('erreurTel')[0];
    messageErreur = 'Le numéro de téléphone doit contenir 10 chiffres'; // Message d'erreur à afficher

    // Vérification de la longueur du numero de telephone
    if (telCourant.length != 10 && telCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (telCourant.length == 10 || telCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifDateNaiss() {
    // Variables locales
    dateCourant = document.getElementsByName('dateNaiss')[0].value; // Date de naissance en cours de saisie
    champErreur = document.getElementsByName('erreurDateNaiss')[0];
    dateNaiss = new Date(dateCourant);
    dateNaissMin = new Date('1950-01-01');

        // Récupération de la date actuelle
    dateActuelle = new Date();
    anneeActuelle = dateActuelle.getFullYear();
    moisActuel = dateActuelle.getMonth();
    jourActuel = dateActuelle.getDate();
    
    dateNaissMax = new Date(anneeActuelle - 18, moisActuel, jourActuel); // Date de naissance maximale (18 ans)
    if (moisActuel < 10) {
        moisActuel = '0' + (moisActuel + 1);
    }
    
    dateNaissMaxString = jourActuel + '/' + moisActuel + '/' + (anneeActuelle - 18).toString();
    messageErreur = 'La date de naissance doit être entre le 01/01/1950 et le ' + dateNaissMaxString + '.';
    console.log(messageErreur);
    
    console.log(dateNaiss);
    console.log(dateNaissMaxString);
    console.log(dateNaiss > dateNaissMax);

    // Vérification de la date de naissance
    if (dateNaiss < dateNaissMin || dateNaiss > dateNaissMax) {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (dateNaiss >= dateNaissMin && dateNaiss <= dateNaissMax || dateCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifPdp() {
    // Variables locales
    pdpCourant = document.getElementsByName('image')[0].value; // Photo de profil en cours d'upload
    champErreur = document.getElementsByName('erreurPhoto')[0];
    messageErreur = 'Le format de la photo de profil doit être .jpg, .jpeg ou .png'; // Message d'erreur à afficher

    // Vérification du format de la photo de profil
    pdpValide = pdpCourant.match(/\.(jpg|jpeg|png)$/);

    // Vérification du format de la photo de profil
    if (!pdpValide && pdpCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (pdpValide || pdpCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifNumCarte() {
    // Variables locales
    numCarteCourant = document.getElementsByName('num_carte')[0].value.replace(/\s+/g, ''); // Numéro de carte en cours de saisie
    champErreur = document.getElementsByName('erreurNumCarte')[0];
    messageErreur = 'Le numéro de carte doit contenir 16 chiffres'; // Message d'erreur à afficher

    // Vérification de la longueur du numero de carte
    if (numCarteCourant.length != 16 && numCarteCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (numCarteCourant.length == 16 || numCarteCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifDateExp() {
    // Variables locales
    dateExpCourant = document.getElementsByName('date_exp')[0].value; // Date d'expiration en cours de saisie (format mm/aa)
    champErreur = document.getElementsByName('erreurDateExp')[0];
    messageErreur = 'La date d\'expiration doit être ultérieure à la date actuelle'; // Message d'erreur à afficher

    // Conversion de la chaine en date
    dateExpExplode = dateExpCourant.split('/');
    moisExp = parseInt(dateExpExplode[0]);
    anneeExp = parseInt(dateExpExplode[1]);

    dateCourante = new Date("20" + anneeExp, moisExp - 1);

    // Récupération de la date actuelle
    dateActuelle = new Date();

    // Vérification de la date d'expiration
    if ((dateCourante < dateActuelle) && dateExpCourant.length == 5) {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (dateCourante >= dateActuelle || dateExpCourant.length != 5) {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifCVC() {
    // Variables locales
    cvcCourant = document.getElementsByName('cvc')[0].value; // CVC en cours de saisie
    champErreur = document.getElementsByName('erreurCVC')[0];
    messageErreur = 'Le CVC doit contenir 3 chiffres'; // Message d'erreur à afficher

    // Vérification de la longueur du cvc
    if (cvcCourant.length != 3 && cvcCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (cvcCourant.length == 3 || cvcCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifTitre() {
    // Variables locales
    titreCourant = document.getElementsByName('titre')[0].value; // Titre en cours de saisie
    champErreur = document.getElementsByName('erreurTitre')[0];
    messageErreur = 'Le titre doit contenir au moins 2 caractères'; // Message d'erreur à afficher

    // Vérification de la longueur du titre
    if (titreCourant.length < 2 && titreCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (titreCourant.length >= 2 || titreCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifDescription() {
    // Variables locales
    descriptionCourante = document.getElementsByName('description')[0].value; // Description en cours de saisie
    champErreur = document.getElementsByName('erreurDescription')[0];
    messageErreur = 'La description doit contenir au moins 2 caractères'; // Message d'erreur à afficher

    // Vérification de la longueur de la description
    if (descriptionCourante.length < 2 && descriptionCourante != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (descriptionCourante.length >= 2 || descriptionCourante == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifCategorie() {
    // Variables locales
    categorieCourant = document.getElementsByName('categorie')[0].value; // Categorie en cours de saisie
    champErreur = document.getElementsByName('erreurCategorie')[0];
    messageErreur = 'La categorie doit contenir au moins 2 caractères'; // Message d'erreur à afficher

    // Vérification de la longueur de la categorie
    if (categorieCourant.length < 2 && categorieCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (categorieCourant.length >= 2 || categorieCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}

function verifRang() {
    // Variables locales
    rangCourant = document.getElementsByName('rang')[0].value; // Rang en cours de saisie
    champErreur = document.getElementsByName('erreurRang')[0];
    messageErreur = 'Le rang doit contenir 3 chiffres'; // Message d'erreur à afficher

    // Vérification de la longueur du rang
    if (rangCourant.length != 3 && rangCourant != '') {
        // Affichage du message d'erreur
        champErreur.innerHTML = messageErreur;

    } else if (rangCourant.length == 3 || rangCourant == '') {
        // Suppression du message d'erreur
        champErreur.innerHTML = '';
    }
}