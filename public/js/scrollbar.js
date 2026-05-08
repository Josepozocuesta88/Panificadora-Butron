document.querySelectorAll('.scrollLeft').forEach(button => {
    button.addEventListener('click', function() {
        let scrollbar = this.parentNode.querySelector('.scrollbar');
        scrollbar.scrollBy({
            left: -100,
            behavior: 'smooth'
        });
    });
});

document.querySelectorAll('.scrollRight').forEach(button => {
    button.addEventListener('click', function() {
        let scrollbar = this.parentNode.querySelector('.scrollbar');
        scrollbar.scrollBy({
            left: 100,
            behavior: 'smooth'
        });
    });
});
