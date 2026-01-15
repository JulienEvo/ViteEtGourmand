document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filters-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const params = new URLSearchParams(new FormData(form));

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
    const form = document.getElementById('filters-form');
    form.reset();

    form.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {input.value = '';});
    form.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    form.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);

    fetch(form.action, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(r => r.text())
        .then(html => {
            document.getElementById('menus-list').innerHTML = html;
        });
});
