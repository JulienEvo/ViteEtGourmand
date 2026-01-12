/* Affichage d'un flash-message */
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.flash-message').forEach(el => {
            el.classList.add('fade-out');
            setTimeout(() => el.remove(), 500);
        });
    }, 3000); // 3 secondes
});
