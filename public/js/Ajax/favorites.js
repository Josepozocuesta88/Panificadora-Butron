function heart(e) {
    e.classList.toggle("bi-suit-heart");
    e.classList.toggle("bi-suit-heart-fill");
    e.classList.toggle("red-heart");

    var action = "/delete";

    if (e.classList.contains("bi-suit-heart-fill")) {
        e.classList.add("enlarge");
        setTimeout(() => {
            e.classList.remove("enlarge");
        }, 300);
        action = "/store";
    }

    var artcod = e.getAttribute("data-artcod");

    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: "/favoritos" + action,
        type: "POST",
        data: {
            artcod: artcod,
            _token: csrfToken,
        },
        success: function (response) {
            // console.log(response.message);
            if (action === "/delete") {
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}
