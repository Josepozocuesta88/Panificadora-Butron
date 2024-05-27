// resources/js/documentos.js

$(document).ready(function ajaxDashboard() {
    var urlDoc = window.location.origin;
    var doctip = $("#tablaDocumentos").data("doctip");
    var url = doctip ? "/documentos/" + doctip : "/documentos";
    var columnsConfig = [
        { title: "#", data: "doccon" },
        { title: "Serie", data: "docser" },
        { title: "Ejercicio", data: "doceje" },
        {  title: "Número", className: "ser-eje-num text-end", data: "docnum" },
        {
            title: "Fecha",
            data: "docfec",
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
    columnsConfig.push({
        title: "Descargar",
        data: "descarga",
        render: function (data, type, row) {

            if (data) {
                var html =
                    '<a href="/documentos/download/' +
                    data +
                    '" class="btn btn-primary me-2"><i class="bi bi-download"></i></a>';
                if (row.docfichero && row.docfichero.length === 1) {
                    html +=
                        '<a href="' +
                        urlDoc +
                        "/images/files/" +
                        row.docfichero +
                        '" class="btn btn-primary" data-toggle="fullscreen"><i class="bi bi-eye-fill"></i></a>';
                }

                return html;
            }
            return "No disponible";
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
});
