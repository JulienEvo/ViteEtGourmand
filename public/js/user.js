
/**
 *
 */
function setPassAuto()
{
    let nom = document.getElementById('nom').value;
    let prenom = document.getElementById('prenom').value;
    let password = document.getElementById('password');

    password.value = nom + '-' + prenom;
}
