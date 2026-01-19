
function setPassAuto()
{
    let nom = document.getElementById('nom').value;
    let prenom = document.getElementById('prenom').value;
    let password = document.getElementById('password');
    let confirm = document.getElementById('confirm');


    nom = nom.replaceAll(' ', '_');
    nom = nom.toLowerCase();
    prenom = prenom.replaceAll(' ', '_');
    prenom = prenom.toLowerCase();

    password.value = '';
    confirm.value = '';
    if (nom !== '' || prenom !== '')
    {
        password.value = nom + '-' + prenom;
        confirm.value = nom + '-' + prenom;
    }
}
