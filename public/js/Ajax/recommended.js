$(document).ready(function () {
    let page = 1;
    let artcod = $("#categorias").data();

    $.ajax({
        url: "/recomendados",
        type: "GET",
        data: {
            page: page,
            artcod: artcod.artcod,
        },
        success: function (response) {
            $.each(response, function (i, articulo) {
                let slide = $("<div/>", {
                    class: "swiper-slide d-flex flex-column align-items-center text-center",
                });

                let imageUrl =
                    articulo.imagenes.length > 0
                        ? window.location.origin +
                          "/images/articulos/" +
                          articulo.imagenes[0].imanom
                        : "/images/articulos/noimage.jpg";

                let url = "/articles/" + articulo.artcod;

                let img = $("<img/>", {
                    src: imageUrl,
                    alt: articulo.artnom,
                    class: "img-fluid mb-2",
                    style: "width: 180px; height: 180px; object-fit: contain;",
                });

                let title = $("<h6/>", {
                    class: "text-truncate w-100 px-2",
                    title: articulo.artnom,
                }).append(
                    $("<a/>", {
                        href: url,
                        text: articulo.artnom,
                        class: "text-decoration-none text-dark",
                    })
                );

                let price = $("<div/>", {
                    class: "fw-bold text-primary",
                    text: articulo.preimp + " €",
                });

                slide.append(img, title, price);
                $("#carousel-recomendados").append(slide);
            });
        },
    });

    new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1024: { slidesPerView: 4 },
            768: { slidesPerView: 2 },
            480: { slidesPerView: 1 },
        },
    });
});
