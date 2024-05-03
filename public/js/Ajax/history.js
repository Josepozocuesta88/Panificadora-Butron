// var agrupado = false;

// // Función para sumar y agrupar los artículos por código
// function sumarYAgruparArticulos(api) {
//     var data = api.rows().data().toArray();
//     var agrupados = {};

//     // Suma las cantidades de los artículos con el mismo código
//     data.forEach(function (item) {
//         if (!agrupados[item.artcod]) {
//             // Si no existe el grupo, crea uno nuevo con la misma estructura de datos
//             agrupados[item.artcod] = {
//                 artcod: item.artcod,
//                 artnom: item.artnom,
//                 estalbfec: item.estalbfec,
//                 estalbimptot: item.estalbimptot,
//                 estcan: item.estcan
//             };
//         } else {
//             // Si ya existe, suma las cantidades
//             agrupados[item.artcod].estcan += item.estcan;
//         }
//     });
//     // Actualizamos la tabla con los artículos agrupados y las cantidades sumadas
//     api.clear(); 
//     api.rows.add(Object.values(agrupados));
//     api.draw(); 
// }
// function desagruparArticulos(api) {
//     // Función para revertir la agrupación y mostrar la lista original
//     api.ajax.reload(); // Recarga los datos originales desde el servidor
// }


// function cargarRejilla() {
//     var url = "/history";
//     var columns = [
//         { data: "artcod" },
//         {
//             data: "artnom",
//             render: function(data, type, row) {
//                 return '<a href="/articles/' + row.artcod + '" class="text-body fw-semibold"><img class="rounded me-3" height="48" width="48" src="' + window.location.origin + '/images/articulos/' 
//                 + row.imanom + '">'+ data + '</a>';
//             }
//         },
//         { data: "estalbfec" },
//         { data: "estalbimptot" },
//         { data: "estcan" },
//     ];

//     var table = $("#history-datatable").DataTable({
//         ajax: url,
//         columns: columns,
//         stateSave: true,
//         language: {
//             paginate: {
//                 previous: "<i class='mdi mdi-chevron-left'>",
//                 next: "<i class='mdi mdi-chevron-right'>"
//             },
//             emptyTable: "No se encontraron documentos para mostrar."
//         },
//         columnDefs: [
//             { className: "table-action", targets: [2] },
//             { visible: false, targets: 0 }
//         ],
//         order: [[0, "asc"]],
//         dom: 'Bfrtip', // Agregamos el botón al DOM de DataTables
//         buttons: [
//             {
//                 text: 'Sumar y Agrupar Artículos', // Este texto será actualizado después de la primera carga
//                 className: 'btn btn-primary',
//                 action: function (e, dt, node, config) {
//                     // La lógica para alternar se maneja aquí
//                 }
//             }
//         ],
//         initComplete: function(settings, json) {
//             // Llamada inicial para agrupar los artículos
//             sumarYAgruparArticulos(this.api());
//             // Actualiza el texto del botón y la variable de estado después de la carga inicial
//             table.button(0).text('Desagrupar Artículos');
//             agrupado = true;
//         }
//     });

//     // Configuración del botón para alternar entre agrupado y desagrupado
//     table.button(0).action(function (e, dt, node, config) {
//         if (!agrupado) {
//             sumarYAgruparArticulos(dt);
//             dt.button(0).text('Desagrupar Artículos'); // Cambia el texto del botón
//             agrupado = true; // Actualiza el estado a agrupado
//         } else {
//             desagruparArticulos(dt);
//             dt.button(0).text('Sumar y Agrupar Artículos'); // Restablece el texto original del botón
//             agrupado = false; // Actualiza el estado a no agrupado
//         }
//     });
// }




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
            { data: "estalbfec"},
            { 
                "data": "estpre", 
                render: function(data, type, row) {
                    if (typeof data === 'undefined') {
                        return '-';
                    }
                    return data ? data : '-';
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
