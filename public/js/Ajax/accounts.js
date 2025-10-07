$(document).ready(function () {
    $("#tablaAccounts").DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: "/account-change",
        columns: [
            { title: "Código de cliente", data: "usuclicod"},
            { title: "Nombre", data: "name" },
            { title: "Email", data: "email"},
            {
                title: "Acciones",
                data: "id",
                render: function (data, type, row) {
                    if (data) {
                        var html =
                            '<a href="/account-login/' +
                            data +
                            '" class="btn btn-primary me-2"><i class="bi bi-door-open-fill"></i></a>';
    
                        return html;
                    }
                    return "No disponible";
                },
            }
        ],
        order: [[1, "desc"]],
        language: {
            emptyTable: "No se encontraron usuarios para mostrar.",
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });
})