
const menu_image = document.getElementById('menu_image');
const preview = document.getElementById('preview');

let tab_images = [];

menu_image.addEventListener('change', (e) => {
    tab_images = Array.from(e.target.files);
    renderPreviews();
});

function renderPreviews()
{
    preview.innerHTML = '';
    preview.hidden = false;

    tab_images.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const div = document.createElement('div');
            div.classList.add('preview-item');

            div.innerHTML = `
                <img src="${e.target.result}">
                <button type="button" onclick="removeFile(${index})">×</button>
            `;

            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    });

    updateInputFiles();
}

function removeFile(index)
{
    tab_images.splice(index, 1);
    renderPreviews();
}

function updateInputFiles()
{
    const dataTransfer = new DataTransfer();

    tab_images.forEach(file => dataTransfer.items.add(file));
    menu_image.files = dataTransfer.files;
}
