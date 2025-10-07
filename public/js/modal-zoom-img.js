function changeMainImage(newImageUrl) {
    document.getElementById('mainImage').src = newImageUrl;
    var modalImage = document.querySelector('#miModal .modal-body img');
    if (modalImage) {
        modalImage.src = newImageUrl;
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var modalImage = document.querySelector('#miModal .modal-body img');
    var modalBody = document.querySelector('#miModal .modal-body');
    
    modalImage.addEventListener('click', function() {
        this.classList.toggle('zoomed-in');
        
        if (this.classList.contains('zoomed-in')) {
            modalBody.style.overflow = 'auto'; 
        } else {
            modalBody.style.overflow = 'hidden';
        }
    });
});