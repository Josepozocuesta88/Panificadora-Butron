@if (session('success'))
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
    <!-- Success Toast -->
    <div id="successToast" class="toast show bg-primary" data-bs-delay="2000">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Éxito</strong>
            <button type="button" class="m-auto btn-close me-2" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="text-white toast-body position-relative">
            {{ session('success') }}
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
            const successToastElement = document.getElementById('successToast');
            const successToast = new bootstrap.Toast(successToastElement);
            const successProgressBar = successToastElement.querySelector('.progress-bar .progress');

            // Animate the progress bars
            successProgressBar.style.transition = 'width 2s linear';
            successProgressBar.style.width = '100%';

            // Hide the toasts after 5 seconds
            setTimeout(function() {
                successToast.hide();
            }, 2000); // 15000 milliseconds = 5 seconds
        });
</script>
@endif