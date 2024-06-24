$(document).ready(function () {
    var page = 1; 

    var artcod = $(".categorias").data();

    $.ajax({
        url: "/recomendados",
        type: "GET",
        data: {
            page: page,
            artcod: artcod,
        },
        success: function (response) {
            var categoriasDiv = $(".categorias");

            $.each(response, function (i, articulo) {
                var div = $("<div/>", {
                    class: "col d-flex flex-column align-content-between align-items-center",
                });
                div.addClass("producto");
                var imageUrl =
                    articulo.imagenes.length > 0
                        ? window.location.origin +
                          "/images/articulos/" +
                          articulo.imagenes[0].imanom
                        : "/images/articulos/noimage.jpg";
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

                div.append(link);
                div.append(h4);
                div.append(h5);

                categoriasDiv.append(div);
            });
        },
    });
});
