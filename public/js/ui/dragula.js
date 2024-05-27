document.addEventListener('DOMContentLoaded', function() {
    "use strict";
    
    function initDragula() {
        var dragulaElements = document.querySelectorAll('[data-plugin="dragula"]');
        
        dragulaElements.forEach(function(element) {
            var containersAttr = element.getAttribute('data-containers');
            var containers = [];
            
            if (containersAttr) {
                var containerIDs = JSON.parse(containersAttr);
                containerIDs.forEach(function(id) {
                    var containerElement = document.getElementById(id);
                    if (containerElement) containers.push(containerElement);
                });
            } else {
                containers = [element];
            }
            
            var handleClass = element.getAttribute('data-handleclass');
            var drake;
            
            if (handleClass) {
                drake = dragula(containers, {
                    moves: function(el, container, handle) {
                        return handle.classList.contains(handleClass);
                    }
                });
            } else {
                drake = dragula(containers);
            }

            // dragula y orden de elementos
            drake.on('drop', function(el, target, source, sibling) {
                var ordenes = [];
                $('#lista-ordenada').children().each(function(index) {
                    ordenes.push({
                        ordcod: $(this).data('ordcod'),
                        orddiacod: $(this).data('orddiacod'),
                        ordtracod: $(this).data('ordtracod'),
                        ordcorcod: $(this).data('ordcorcod'),
                        ordord: index + 1 
                    });
                });
                // console.log(ordenes)
                enviarOrdenAlServidor(ordenes);
            });
            
            drake.on('dragend', function(el) {
                var simpleBarContainers = document.querySelectorAll('[data-simplebar]');
                simpleBarContainers.forEach(function(container) {
                    if (container.SimpleBar) {
                        container.SimpleBar.recalculate();
                    }
                });
            });
            
        });
    }
    
    initDragula();

});


function enviarOrdenAlServidor(ordenes) {
    $.ajax({
        url: '/actualizarOrden',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            ordenes: ordenes,
            tracod: $('#tramoSelect').val(), 
            diacod: $('#diaSelect').val()
        },
        success: function(response) {
            console.log('Orden actualizado con éxito');
            realizarAccion($('#diaSelect').val(), $('#tramoSelect').val());

        },
        error: function(xhr, status, error) {
            console.error('Error actualizando el orden:', error);
        }
    });
}