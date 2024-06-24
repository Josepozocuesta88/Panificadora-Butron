$(document).ready(function () {
    var url = "/historicoPuntos"; // Estado inicial: datos agrupados
    $("#points").DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        ajax: url,
        columns: [
            { data: "artcod" },
            {
                data: "artnom",
                render: function (data, type, row) {
                    return (
                        '<a href="/articles/' +
                        row.artcod +
                        '" class="text-body fw-semibold">' +
                        data +
                        "</a>"
                    );
                },
            },
            { data: "fecha" },
            { data: "precio" },
            { data: "cantidad" },
            { data: "puntos" },
        ],
        language: {
            emptyTable: "No se encontraron documentos para mostrar.",
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
    });


    const $giftIcon = $('#gift-icon');

    const openGift = () => {
        $giftIcon.addClass('opening');

        setTimeout(() => {

            $giftIcon.removeClass('mdi-gift opening').addClass('mdi-gift-open open');
        }, 500);
    };

    $giftIcon.on('click', openGift);
});
