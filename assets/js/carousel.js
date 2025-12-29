const track = document.querySelector('.carousel-track');
const items = document.querySelectorAll('.carousel-item');
let index = 0;

setInterval(() => {
    index = (index + 1) % items.length;
    track.style.transform = "translateX(-${index * 100}%)";
}, 4000);
