var productos = document.getElementById('productos');
document.getElementById('scrollLeft').addEventListener('click', function() {
    productos.scrollBy({
        left: -100,
        behavior: 'smooth'
    });
});

document.getElementById('scrollRight').addEventListener('click', function() {
    productos.scrollBy({
        left: 100,
        behavior: 'smooth'
    });
});

// productos.addEventListener('wheel', function(e) {
//     // Scroll horizontal con el ratón
//     productos.scrollLeft += e.deltaY;
//     e.preventDefault();
// }, {
//     passive: false
// });

