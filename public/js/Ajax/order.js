$(document).ready(function () {
    var columnsConfig = [
        { title: "Nº de Pedido", data: "id" },
        {
            title: "Fecha",
            data: "fecha",
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
            title: "Total",
            data: "total",
            className: "text-end",
            render: function (data, type, row) {
                if (typeof data === "number") {
                    return data.toLocaleString("es-ES") + " €";
                }
                return data;
            },
        },
        {
            title: "Ver Detalles",
            data: "id",
            class: "size",
            render: function (data, type, row) {
                if (data) {
                    var html =
                        '<a href="/pedidos/pedido/' +
                        data +
                        '" class="btn btn-primary me-2"><i class="bi bi-arrow-right-circle-fill"></i></a>';
                    return html;
                }
                return "No disponible";
            },
        },
    ];

    $("#tablaPedidos").DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "/pedidos",
            dataSrc: "data", // Especifica la fuente de datos
            error: function (xhr, error, thrown) {
                console.error("Error al cargar los datos: ", error);
            },
        },
        columns: columnsConfig,
        columnDefs: [{ type: "date", targets: 1 }],
        order: [[1, "desc"]],
        language: {
            emptyTable: "Actualmente no tiene pedidos.",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 registros",
            infoFiltered: "", // Esto elimina el mensaje cuando se aplica un filtro
            lengthMenu: "", // Oculta el filtro de "Mostrar x artículos"
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron registros coincidentes",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
        lengthChange: false,
        pageLength: 3,
    });

    // estado de los pedidos
    var estado = $("#tooltip-container").data("estado");
    var progress = $(".process-line");
    var stepItems = document.querySelectorAll(".step-item");

    if (estado == 2) {
        progress.css("width", "0%");
        stepItems[0].classList.add("current");
    } else if (estado == 6) {
        progress.css("width", "33%");
        stepItems[1].classList.add("current");
    } else if (estado === 20) {
        progress.css("width", "66%");
        stepItems[2].classList.add("current");
    } else {
        progress.css("width", "100%");
        stepItems[3].classList.add("current");
    }
});
