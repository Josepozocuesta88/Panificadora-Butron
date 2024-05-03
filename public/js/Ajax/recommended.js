$(document).ready(function () {
    var page = 1; // Inicia la página en 1

    // Obtiene el valor de 'artcod'
    var artcod = "{{$articulo->artcod}}";

    // Realiza la petición AJAX
    $.ajax({
        url: "/recomendados?artcod=" + artcod,
        type: "GET",
        data: {
            page: page,
        },
        success: function (response) {
            var productosDiv = $(".productos");

            $.each(response, function (i, articulo) {
                // nuevo div para cada artículo
                var div = $("<div/>", {
                    class: "col d-flex flex-column align-content-between align-items-center",
                });
                div.addClass("producto");
                //  url de la imagen
                var imageUrl =
                    articulo.imagenes.length > 0
                        ? window.location.origin +
                          "/images/articulos/" +
                          articulo.imagenes[0].imanom
                        : "/images/articulos/noimage.jpg";
                //  url para ir a otro articulo
                var artcod = articulo.artcod;
                var url = "/articles/" + artcod;

                var link = $("<a/>", {
                    href: url,
                    title: "",
                });
                var img = $("<img/>", {
                    src: imageUrl,
                    class: "img-fluid",
                    alt: "",
                    style: "width:200px;height:200px;",
                });
                link.append(img);

                var h4 = $("<h4/>", {
                    class: "text-center text-truncate w-75",
                    title: articulo.artnom,
                });
                var h5 = $("<h5/>", {
                    class: "text-center text-truncate w-75",
                    text: articulo.preimp + " €",
                });
                var titleLink = $("<a/>", {
                    href: url,
                    text: articulo.artnom,
                });
                h4.append(titleLink);

                // añadimos el enlace y el título al div
                div.append(link);
                div.append(h4);
                div.append(h5);

                // añadimos el div al div 'productos'
                productosDiv.append(div);
            });
        },
    });
});
