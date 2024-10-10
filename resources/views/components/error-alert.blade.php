@if (session('error'))
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
    <div id="errorToast" class="toast show bg-primary" data-bs-delay="5000">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Alerta</strong>
            <button type="button" class="m-auto btn-close me-2" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
        <div class="text-white toast-body">
            {{ session('error') }}
            <div class="progress-bar">
                <div class="bg-white progress"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .progress-bar {
        width: 100%;
        height: 5px;
        background-color: rgba(255, 255, 255, 0.5);
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .progress-bar .progress {
        width: 0;
        height: 100%;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {

            const errorToastElement = document.getElementById('errorToast');
            const errorToast = new bootstrap.Toast(errorToastElement);
            const errorProgressBar = errorToastElement.querySelector('.progress-bar .progress');

            // Animate the progress bars
            errorProgressBar.style.transition = 'width 2s linear';
            errorProgressBar.style.width = '100%';

            // Hide the toasts after 5 seconds
            setTimeout(function() {
                errorToast.hide();
            }, 2000); // 2000 milliseconds = 2 seconds
        });
</script>
@endif