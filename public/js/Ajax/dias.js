$(document).ready(function() {

    var url = '/listado-dias';
    $('#tablaDias').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: url, 
        columns: [
            { className:'diacod', data: 'diacod' },
            { className:'dianom', data: 'dianom' },
            {
                className: 'acciones',
                data: 'diacod', 
                render: function(data, type, row) {
                    if (data) {
                        var botonEditar = '<a class="open-modal-btn btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-diacod="' + data + '"><i class="bi bi-pencil-fill"></i></a>';
                        botonBorrar ='<button class="delete-btn btn btn-primary" data-diacod="' + data + '"><i class="bi bi-trash3-fill"></i></button></td>';
                        return botonEditar + botonBorrar;
                    }
                    return 'No disponible';
                }
                
            }
        ],
        language: {
            emptyTable: "No se encontraron registros para mostrar.",
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
});



// delete
$('#tabla').on('click', '.delete-btn', function() {
    var id = $(this).data('diacod'); 
    if (confirm('¿Estás seguro de que quieres borrar este día?')) {
        borrarRegistro(id);
    }
});

function borrarRegistro(id) {
    $.ajax({
        url: '/borrarDia/' + id, 
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), 
            _method: 'POST', 
            id: id
        },
        success: function(response) {
            $('#tablaDias').DataTable().ajax.reload();
            alert('Día borrado con éxito.');
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('No se pudo borrar este día, inténtelo de nuevo.');
        }
    });
}


// // añade dia id al formulario del modal
$(document).on("click", ".open-modal-btn", function () {
    var id = $(this).data("diacod");
    $("#idInput").val(id);
});



