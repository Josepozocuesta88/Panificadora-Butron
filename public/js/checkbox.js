document.addEventListener('DOMContentLoaded', function() {

    function handleCheckboxChange(checkbox, className) {
        // console.log("Checkbox changed:", checkbox);
        if (checkbox.checked) {
            document.querySelectorAll('.' + className).forEach(function(other) {
                if (other !== checkbox) {
                    other.checked = false;
                }
            });
        }
    }

    // orden alfabetico
    document.querySelectorAll('.checkbox-orden-nombre').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            handleCheckboxChange(this, 'checkbox-orden-nombre');
            // console.log("Checkbox changed:", this);
        });
    });

    // orden precio
    document.querySelectorAll('.checkbox-orden-precio').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            handleCheckboxChange(this, 'checkbox-orden-precio');
            // console.log("Checkbox changed:", this);
        });
    });

    // orden relevancia
    document.querySelectorAll('.checkbox-orden-relevancia').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            handleCheckboxChange(this, 'checkbox-orden-relevancia');
            // console.log("Checkbox changed:", this);
        });
    });
    
});
