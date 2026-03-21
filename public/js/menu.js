// Écouteur d'événement lorsque le document HTML est complètement chargé
document.addEventListener('DOMContentLoaded', () => {
    // Récupère le formulaire
    const form = document.getElementById('form_filtre_menu');
    if (!form) return;

    // Écouteur d'événement sur la validation du formulaire
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Récupère les données du formulaire
        const params = new URLSearchParams(new FormData(form));

        // Fonction "fetch" qui intérroge le serveur (fonction du contrôleur) et retourne une promesse
        // Paramètre : URL de la route du serveur
        // Retour : Rendu de la page HTML de la liste des menus, généré selon le résultat de la requête
        fetch(form.action + '?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById('menus-list').innerHTML = html;
            });
    });
});

document.getElementById('reset-filters').addEventListener('click', () => {
    const form = document.getElementById('form_filtre_menu');
    form.reset();

    form.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {input.value = '';});
    form.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    form.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = true);

    fetch(form.action, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(r => r.text())
        .then(html => {
            document.getElementById('menus-list').innerHTML = html;
        });
});
