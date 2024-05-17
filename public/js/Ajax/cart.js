$(document).ready(function () {
    $(".quantity-update").on("change", function () {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var cartcod = $(this).data("cartcod");
        var box_quantity = $(".box_quantity[data-cartcod='" + cartcod + "']").val();
        var type = $(".tipoCajaSelect[data-cartcod='" + cartcod + "']").val();

        $.ajax({
            url: "/update-cart/" + cartcod,
            type: "POST",
            data: {
                _token: csrfToken,
                box_quantity: box_quantity,
                type: type,
            },
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                console.log(response.message);
            },
        });
    });

    $(".tipoCajaSelect").on("change", function () {
        var select = $(this);
        var selectedValue = select.val();
        var cartcant = select.data("cartcant");
        var cartcod = select.data("cartcod");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/update-select/" + cartcod + "/" + cartcant + "/" + selectedValue,
            type: "POST",
            data: {
                _token: csrfToken,
            },
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                console.log("Error: " + response.responseText);
            },
        });
    });

    rellenarSelects();
});

function rellenarSelects() {
    $(".tipoCajaSelect").each(function () {
        var select = $(this);
        var productId = select.data("artcod");

        if (select.val() === 'unidades') {
            select.html('<option value="unidades" selected>Unidad</option>');
            return; // No realizar AJAX para artículos sin cajas/piezas
        }

        $.ajax({
            url: "/selectTipo/" + productId,
            type: "GET",
            success: function (response) {
                var cajas = response.cajas;
                select.empty();
                var cajcod = select.data("cajcod");

                $.each(cajas, function (i, caja) {
                    var tipo = "";
                    if (caja.cajcod == "0001") {
                        tipo = "Caja";
                    } else if (caja.cajcod == "0003") {
                        tipo = "Pieza";
                    } else {
                        tipo = "Media";
                    }

                    var isSelected = cajcod == caja.cajcod;

                    var option = $("<option>", {
                        value: caja.cajcod,
                        text: tipo,
                        selected: isSelected,
                    });

                    select.append(option);
                });
            },
            error: function (response) {
                console.log(response);
            },
        });
    });
}

// removeItem
$("#removeItem").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function (data) {
            location.reload();
        },
        error: function (e) {
            console.log(e.message);
        },
    });
});

// showModalCart
function cargarCarrito() {
    $.ajax({
        url: "/modalCart",
        type: "GET",

        success: function (response) {
            // Seleccionar el contenedor del contenido del modal
            var modalContent = document.querySelector(".modalCesta");
            // Limpiar el contenido anterior
            var simpleBarInstance = SimpleBar.instances.get(modalContent);

            if (!response.items && response.items.length < 0) {
                // No hay datos
                var mensaje = response.message;
                modalContent.textContent = mensaje;
            } else {
                if (simpleBarInstance) {
                    // Destruir la instancia actual de SimpleBar
                    simpleBarInstance.unMount();
                }
                modalContent.innerHTML = "";
                modalContent.style.maxHeight = "300px";
                modalContent.style.overflowY = "auto";
                
                response.items.forEach(function (item) {
                    
                    var dropdownItem = document.createElement("div");
                    dropdownItem.className =
                        "dropdown-item p-0 notify-item card read-noti shadow-none mb-2";

                    var cardBody = document.createElement("div");
                    cardBody.className = "card-body";

                    var closeSpan = document.createElement("span");
                    closeSpan.className = "float-end noti-close-btn text-muted";
                    var icoClose = document.createElement("i");
                    icoClose.className = "mdi mdi-close d-none";

                    var itemInfoDiv = document.createElement("div");
                    itemInfoDiv.className = "d-flex align-items-center";

                    var img = document.createElement("img");
                    img.className = "w-25 rounded-circle flex-shrink-0";
                    img.src =
                        item.image == "" || item.image == null
                            ? window.location.origin +
                              "/images/articulos/noimage.jpg"
                            : window.location.origin +
                              "/images/articulos/" +
                              item.image;
                    img.onerror = function () {
                        this.onerror = null;
                        this.src =
                            window.location.origin +
                            "/images/articulos/noimage.jpg";
                    };

                    var itemDetailsDiv = document.createElement("div");
                    itemDetailsDiv.className = "flex-grow-1 text-truncate ms-2";

                    var itempriceDiv = document.createElement("div");
                    itempriceDiv.className = "item-price fw-bold";
                    itempriceDiv.textContent = item.total + "€ ";

                    if (item.isOnOffer) {
                        var tarifaSmall = document.createElement("small");
                        tarifaSmall.className = "text-decoration-line-through";
                        itempriceDiv.className = "text-danger";
                        tarifaSmall.textContent = item.tarifa + "€";
                        itempriceDiv.appendChild(tarifaSmall);
                    }

                    var titleH5 = document.createElement("h5");
                    titleH5.className = "noti-item-title fw-semibold font-13";
                    titleH5.textContent = item.name;

                    var quantitySpan = document.createElement("span");
                    quantitySpan.className = "noti-item-subtitle text-muted";
                    quantitySpan.textContent =
                        "Cantidad: " + item.cantidad_unidades;

                    // Construir la estructura del elemento del carrito
                    itemDetailsDiv.appendChild(titleH5);
                    itemDetailsDiv.appendChild(quantitySpan);

                    itemInfoDiv.appendChild(img);
                    itemInfoDiv.appendChild(itemDetailsDiv);
                    itemInfoDiv.appendChild(itempriceDiv);
                    closeSpan.appendChild(icoClose);
                    cardBody.appendChild(closeSpan);
                    cardBody.appendChild(itemInfoDiv);
                    dropdownItem.appendChild(cardBody);

                    // Añadir el elemento del carrito al contenido del modal
                    modalContent.appendChild(dropdownItem);
                });
                new SimpleBar(modalContent);
            }
        },
        error: function (error) {
            console.log(error.message);
        },
    });
}
