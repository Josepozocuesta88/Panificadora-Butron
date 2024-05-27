$(document).ready(function() {
    var url = '/usuarios';
    $('#tablaUsuarios').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: url, 
        columns: [
            { className:'name', data: 'name' },
            { className:'email', data: 'email' },
            { className:'usutip', data: 'usutip' },
            {
                className: 'acciones',
                data: 'id', 
                render: function(data, type, row) {
                    if (data) {

                        var botonEditar = '<a class="edit-btn btn btn-primary me-2" href="/usuarios/' + data + '/editar/"><i class="bi bi-pencil-fill"></i></a>';
                        botonBorrar ='<button class="delete-btn btn btn-primary" data-id="' + data + '"><i class="bi bi-trash3-fill"></i></button></td>';
                        return botonEditar + botonBorrar;
                    }
                    return 'No disponible';
                }
                
            }
        ],
        language: {
            emptyTable: "No se encontraron usuarios para mostrar.",
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
});


// delete
$('#tablaUsuarios').on('click', '.delete-btn', function() {
    var id = $(this).data('id'); 
    if (confirm('¿Estás seguro de que quieres borrar este usuario?')) {
        borrarUsuario(id);
    }
});

function borrarUsuario(id) {
    $.ajax({
        url: '/usuarios/' + id, 
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), 
            _method: 'DELETE',
        },
        success: function(response) {
            $('#tablaUsuarios').DataTable().ajax.reload();
            alert('Usuario borrado con éxito.');
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('No se pudo borrar el usuario.');
        }
    });
}
