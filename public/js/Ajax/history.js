// Definir la función cargarRejilla fuera de cualquier otra función para asegurar que se ejecute al cargar la página.
function cargarRejilla() {
    // Inicialmente, definir la URL para cargar datos agrupados.
    var urlActual = "/historyAgrupado"; // Estado inicial: datos agrupados
    var table = $("#history-datatable").DataTable({
        ajax: urlActual,
        columns: [
            { data: "artcod" },
            {
                data: "artnom",
                render: function(data, type, row) {
                    if (row.imanom == null || row.imanom == "") {
                        return '<a href="/articles/' + row.artcod + '" class="text-body fw-semibold"><img class="rounded me-3" height="48" width="48" src="' + window.location.origin + '/images/articulos/noimage.jpg" loading="lazy">'+ data + '</a>';
                    }else{
                        return '<a href="/articles/' + row.artcod + '" class="text-body fw-semibold"><img class="rounded me-3" height="48" width="48" src="' + window.location.origin + '/images/articulos/' 
                        + row.imanom + '" loading="lazy">'+ data + '</a>';
                    }
                }
            },
            { data: "estalbfec" },
            {
                "data": "estpre",
                render: function(data, type, row) {
                    if (typeof data === 'undefined') {
                        return '-';
                    }
            
                    // Suponiendo que `data` contiene la información necesaria
                    let precio = data.toLocaleString("es-ES", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " €";
            
                    return precio ? precio : '-';
                }
            },

            { data: "estcan" },
        ],
        stateSave: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            emptyTable: "No se encontraron documentos para mostrar.",
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        columnDefs: [
            { className: "table-action", targets: [2] },
            { visible: false, targets: 0 }
        ],
        order: [[0, "asc"]],
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Desagrupar Artículos', // Texto inicial para el botón.
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    if (urlActual === "/historyAgrupado") {
                        urlActual = "/history"; // Cambiar a la URL para datos no agrupados.
                        dt.button(0).text('Agrupar Artículos'); // Cambiar el texto del botón para la próxima acción.
                    } else {
                        urlActual = "/historyAgrupado"; // Cambiar de nuevo a la URL para datos agrupados.
                        dt.button(0).text('Desagrupar Artículos'); // Restablecer el texto del botón.
                    }
                    dt.ajax.url(urlActual).load(); // Recargar los datos de la tabla con la nueva URL.
                }
            }
        ]
    });
}
