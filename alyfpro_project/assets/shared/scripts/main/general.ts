

function goBack() {
    window.history.back();
}

// function pour fermer l'alert autmatiquement
// Sélectionnez l'élément d'alerte
// const $alert = document.getElementById('alert-success');
//
// // Assurez-vous que $alert est de type HTMLElement ou que vous l'avez vérifié explicitement
// if ($alert instanceof HTMLElement) {
//     // Fermez l'alerte automatiquement après 5 secondes (5000 millisecondes)
//     setTimeout(() => {
//         $alert.style.display = 'none';
//     }, 5000);
// }

document.addEventListener("DOMContentLoaded", function() {
    const $alert = document.getElementById('alert-success');

    // Assurez-vous que $alert est de type HTMLElement ou que vous l'avez vérifié explicitement
    if ($alert instanceof HTMLElement) {
        // Fermez l'alerte automatiquement après 5 secondes (5000 millisecondes)
        setTimeout(() => {
            $alert.style.display = 'none';
        }, 5000);
    }
});
