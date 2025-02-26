let floatingButton = document.getElementById("ajout");
floatingButton.addEventListener("mouseover", function (){
    this.style.width = "200px";
    this.innerText = "Ajouter un trajet";
})

floatingButton.addEventListener("mouseout", defaultButton);

floatingButton.addEventListener("click", function (){
    location.href = "index.php?controleur=trajet&methode=enregistrer";
})

function defaultButton(){
    this.innerText = "+";
    this.style.width = "60px";
}

