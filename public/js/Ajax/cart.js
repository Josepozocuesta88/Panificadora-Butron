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

// update quantity
$(document).ready(function () {
    // para habilitar o deshabilitar los inputs
    $(".quantity-update").each(function () {
        var enableType = $(this).data("enable-type");
        var updateType = $(this).data("update-type");

        if (enableType === "unidades" && updateType === "bulto") {
            $(this).prop("disabled", true);
        } else if (enableType !== "unidades" && updateType === "unidades") {
            $(this).prop("disabled", true);
        }
    });

    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    $(".quantity-update").on("change", function () {
        var productId = $(this).data("cartcod");
        var quantity = $(this).val();
        var updateType = $(this).data("update-type"); // "bulto" o "unidades"

        $.ajax({
            url: "/update-cart/" + productId,
            type: "POST",
            data: {
                _token: csrfToken,
                quantity: quantity,
                cartcod: productId,
                updateType: updateType,
            },
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                console.log(response.message);
            },
        });
    });
});

// Logica para alternar entre cajas y unidades (en article-details)
$("input[type=radio][name=caja]").change(function () {
    if ($(this).val() === "unidades" || $(this).val() === "0003") {
        $("#box-quantity-input").hide();
        $("#unit-quantity-input").show();
    } else {
        // Si no es 'unidades', asumimos que cualquier otro valor es una caja
        $("#box-quantity-input").show();
        $("#unit-quantity-input").hide();
    }
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
