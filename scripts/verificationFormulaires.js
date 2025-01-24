function verifierAdresse(id){
    let champ = document.getElementById(id);
    let regexp = new RegExp("^[0-9]{1,3}\\s[a-zA-Z\\s\u00C0-\u017F]+,[a-zA-Z\\s-]+$");
    if(regexp.test(champ.value)){
        document.querySelector("."+id+"MessageErreur").innerHTML = "";
        champ.classList.remove("invalid-input");
        champ.classList.add("valid-input");
    }
    else{
        document.querySelector("."+id+"MessageErreur").innerHTML = "Veuillez respecter le format d'adresse (ex : 1 Rue Paul, Paris)";
        champ.classList.remove("valid-input");
        champ.classList.add("invalid-input");
    }
}

function checkForm(){}