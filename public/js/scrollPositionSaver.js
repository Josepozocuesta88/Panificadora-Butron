// codigo para guardar posicion de las paginas
window.onbeforeunload = function() {
    if (!sessionStorage.getItem('navegacionIntencionada')) {
        localStorage.setItem('posicionScroll', window.scrollY);
    }
};

window.onload = function() {
    if (sessionStorage.getItem('navegacionIntencionada')) {
        const section = document.getElementById(sessionStorage.getItem('navegacionIntencionada'));
        if (section) {
            section.scrollIntoView();
        }
        sessionStorage.removeItem('navegacionIntencionada'); 
    } else if (localStorage.getItem('posicionScroll')) {
        window.scrollTo(0, parseInt(localStorage.getItem('posicionScroll')));
        localStorage.removeItem('posicionScroll'); 
    }
};

function irAProductos() {
    sessionStorage.setItem('navegacionIntencionada', 'productos');
}