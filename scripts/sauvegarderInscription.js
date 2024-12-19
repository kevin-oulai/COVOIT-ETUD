 // Charger les valeurs depuis localStorage lorsque la page est chargée
 window.onload = function() {
    const nomsChamps = ['Nom', 'Prenom','mail','tel','dateNaiss','pwd','image'];  // Liste des noms de champs à récupérer

    nomsChamps.forEach(nomChamp => {
        const valeur = localStorage.getItem(nomChamp);
        if (valeur) {
            // Récupère l'élément par son nom et met sa valeur à celle dans localStorage
            const champ = document.querySelector(`[name=${nomChamp}]`);
            if (champ) {
                champ.value = valeur;
            }
        }
    });
};

document.getElementById('lien').addEventListener('click', function(e) {

    // Sauvegarder chaque champ dans localStorage
    const champs = document.querySelectorAll('[name]');
    champs.forEach(champ => {
        const nom = champ.name;
        const valeur = champ.value;
        localStorage.setItem(nom, valeur);  // Sauvegarde la valeur dans localStorage sous le nom du champ
    });
});