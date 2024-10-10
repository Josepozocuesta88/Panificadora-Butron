// resources/js/documentos.js

$(document).ready(function ajaxDashboard() {
    var urlDoc = window.location.origin;
    var doctip = $("#tablaDocumentos").data("doctip");
    var url = doctip ? "/documentos/" + doctip : "/documentos";
    var columnsConfig = [
        { title: "#", data: "doccon" },
        { title: "Serie", data: "docser" },
        { title: "Ejercicio", data: "doceje", className: "text-end" },
        { title: "Número", className: "ser-eje-num text-end", data: "docnum" },
        {
            title: "Fecha",
            data: "docfec",
            className: "text-end",
            render: function (data, type, row) {
                if (type === "display" && data) {
                    var date = new Date(data);
                    return new Intl.DateTimeFormat("es-ES", {
                        day: "2-digit",
                        month: "2-digit",
                        year: "numeric",
                    }).format(date);
                }
                return data;
            },
        },
        {
            title: "Importe",
            data: "docimp",
            className: "text-end",
            render: function (data, type, row) {
                return data.toLocaleString("es-ES") + " €";
            },
        },
        {
            title: "Importe Total",
            data: "docimptot",
            className: "text-end",
            render: function (data, type, row) {
                return data.toLocaleString("es-ES") + " €";
            },
        },
    ];

    if (doctip !== "Albaranes") {

        columnsConfig.push(
            {
                title: "Pendiente De Pago",
                data: "docimppen",
                className: "text-end",
                render: function (data, type, row) {
                    return data.toLocaleString("es-ES") + " €";
                },
            },
            {
                title: "Estado",
                data: "doccob",
                className: "text-end",
                render: function (data, type, row) {
                    if (data == 1) {
                        estado = "PAGADO";
                        html =
                            '<span class="badge badge-success-lighten"> <i class="mdi mdi-bitcoin"></i> ' +
                            estado +
                            "</span>";
                    } else {
                        estado = "PENDIENTE";
                        html =
                            '<span class="badge badge-warning-lighten"> <i class="bi bi-hourglass-split"></i> ' +
                            estado +
                            "</span>";
                    }
                    return html;
                },
            }
        );
    }

    $("#estadoFiltro").on("change", function () {
        let table = $("#tablaDocumentos").DataTable();
        table.draw();
    })
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            let filterSelected = $("#estadoFiltro").val();
            let estado = data[8];

            if (filterSelected === "todas") {
                return true;
            } else if (filterSelected === "1" && estado.includes("PAGADO")) {
                return true;
            } else if (filterSelected === "0" && estado.includes("PENDIENTE")) {
                return true;
            }
            return false;
        }
    )

    columnsConfig.push({
        title: "Descargar",
        data: "descarga",
        className: "text-end",
        render: function (data, type, row) {
            if (data) {
                var html =
                    '<a href="/documentos/download/' +
                    data +
                    '" class="btn btn-primary me-2"><i class="bi bi-download"></i></a>';
                if (row.docfichero && row.docfichero.length === 1) {
                    html +=
                        '<button class="ver-documento btn btn-primary" data-href="' +
                        urlDoc +
                        "/documentos/ver/" +
                        row.docfichero +
                        '" data-toggle="fullscreen"><i class="bi bi-eye-fill"></i></button>';
                }

                return html;
            }
            return "No disponible";
        },
    })

    columnsConfig.push({
        title: "Acciones",
        data: "doccob",
        className: "text-end",
        className: "text-end",
        render: function (data, type, row) {
            if (data !== 1) {
                estado = "PENDIENTE";
                html = '<a href="#" class="btn btn-primary me-2"><i class="bi bi-credit-card"></i></a>';
            }
            return html;
        },
    });


    $("#tablaDocumentos").DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: url,
        columns: columnsConfig,
        columnDefs: [{ type: "date", targets: 4 }],
        order: [[4, "desc"]],
        language: {
            emptyTable: "No se encontraron documentos para mostrar.",
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });

    $(document).on('click', '.ver-documento', (e) => {
        e.preventDefault(); // Prevent default action
        const url = e.currentTarget.dataset.href; // Get the URL from data attribute

        // Fetch the new URL
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    window.open(data.url, '_blank'); // Open the new URL in a new tab
                } else {
                    console.error('No se encontró la nueva URL en la respuesta.');
                }
            })
            .catch(error => console.error('Error al realizar la petición:', error));
    });
});
