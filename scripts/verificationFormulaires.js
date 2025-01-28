function verifierAdresse(id){
    let champ = document.getElementById(id);
    let regexp = new RegExp("^[0-9]{1,3}\\s[a-zA-Z\\s\u00C0-\u017F]+,[a-zA-Z\\s-]+$");
    if(regexp.test(champ.value)){
        document.querySelector("."+id+"MessageErreur").innerHTML = "";
        champ.classList.remove("invalid-input");
        champ.classList.add("valid-input");
        return true;
    }
    else{
        document.querySelector("."+id+"MessageErreur").innerHTML = "Veuillez respecter le format d'adresse (ex : 1 Rue Paul, Paris)";
        champ.classList.remove("valid-input");
        champ.classList.add("invalid-input");
        return false;
    }
}

function verifierPrix(id){
    let champ = document.getElementById(id);
    let value = parseFloat(champ.value);
    let valid = true;

    if(value < parseFloat(champ.min)){
        document.querySelector("."+id+"MessageErreur").innerHTML = "Saisir un prix supérieur à "  + champ.min;
        valid = false;
    }
    else if(value > parseFloat(champ.max)){
        document.querySelector("."+id+"MessageErreur").innerHTML = "Saisir un prix inférieur à " + champ.max;
        valid = false;
    }

    if(!valid){
        champ.classList.remove("valid-input");
        champ.classList.add("invalid-input");
    }
    else{
        document.querySelector("."+id+"MessageErreur").innerHTML = "";
        champ.classList.remove("invalid-input");
        champ.classList.add("valid-input");
    }
    return valid;
}
function checkFirstPart(){
    if(verifierAdresse('lieuDepart') && verifierAdresse('lieuArrivee')){
        // Afficher la deuxieme partie du formulaire
        document.querySelector(".form-part-2").style.opacity = 100;
    }

}