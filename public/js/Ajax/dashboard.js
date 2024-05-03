var chart;
function ajaxGraph(fecha = null) {
    var url = "/dashboard";
    var data = { fecha: fecha };

    $.ajax({
        url: url,
        data: data,
        type: "get",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
        async: "true",
        dataType: "json",

        success: function (response) {
            // Actualiza el DOM con los nuevos datos
            // ordersCount = convertirADecimal(response.data.ordersCount)
            // purchaseAmount = convertirADecimal(response.data.purchaseAmount)
            // accountBalance = convertirADecimal(response.data.accountBalance)
            $("#ordersCount").text(
                response.data.ordersCount.toLocaleString("es-ES")
                // ordersCount
            );
            $("#purchaseAmount").text(
                response.data.purchaseAmount.toLocaleString("es-ES") + " €"
                // purchaseAmount  + " €"
            );

            $("#accountBalance").text(
                response.data.accountBalance.toLocaleString("es-ES", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }) + " €"
                // accountBalance  + " €"

            );

            let top10 = response.topSellingItems;
            let tbody = document.getElementById("top-10-tbody");

            // Limpia los datos antiguos de la tabla
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Ahora agrega los nuevos datos
            top10.forEach((item) => {
                let tr = document.createElement("tr");
                let td1 = document.createElement("td");
                let td2 = document.createElement("td");
                let td3 = document.createElement("td");
                let td4 = document.createElement("td");
                let td5 = document.createElement("td");
                let a = document.createElement("a");
                let i = document.createElement("i");

                td1.textContent = item["artcod"] ? item["artcod"] : "N/A";
                td2.textContent = item["artnom"]
                    ? item["artnom"]
                    : "Artículo no disponible";
                td3.textContent = item["vecesComprado"].toLocaleString("es-ES") + " Ud.";
                td4.textContent = item["estpre"].toLocaleString("es-ES") + " €";

                a.className = "btn btn-primary ms-2";
                a.href = item["artcod"] ? "/articles/" + item["artcod"] : "#";
                i.className = "bi bi-bag-plus-fill";
                td5.className = "p-2";

                a.appendChild(i);
                td5.appendChild(a);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tbody.appendChild(tr);
            });

            // gáfica
            const stringMeses = [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ];

            if (Array.isArray(response.chartPurchasesByMonth)) {
                let totales = [];
                response.chartPurchasesByMonth.forEach((d) => {
                    totales.push(d["importe"].toFixed(2));
                });
                let meses = [];
                response.chartPurchasesByMonth.forEach((d) => {
                    numeroMes = d["mes"];
                    nombreMes = stringMeses[numeroMes - 1];
                    meses.push(nombreMes);
                });
                initCharts(totales, meses);
            } else {
                console.error(
                    "ChartPurchasesByMonth no es un array o no existe en response.data:",
                    response.data
                );
            }
        },
        error: function (respuesta, error) {
            console.error(
                "Error en la petición AJAX:",
                respuesta.responseText,
                error
            );
        },
    });
}

function initCharts(totales, meses) {
    if (chart) {
        chart.destroy();
    }

    ("use strict");
    window.Apex = {
        chart: {
            parentHeightOffset: 0, //ajusta el tamaño del grafico en relacion al elemento padre
            toolbar: { show: !1 }, //desactiva la barra de herramientas de los graficos
        },
        grid: {
            padding: { left: 0, right: 0 },
        },
        colors: ["#727cf5", "#0397d6", "#fa5c7c", "#ffbc00"],
    };

    var t = ["#727cf5", "#0397d6", "#fa5c7c", "#ffbc00"],
        a = $("#sessions-overview").data("colors"),
        e = {
            //define la grafica
            chart: { height: 309, type: "area" }, //se configura un grafico de tipo area con una altura especifica
            dataLabels: { enabled: !1 }, //se deshabilitan las etiquetas de datos
            stroke: { curve: "smooth", width: 4 }, // personalizacion del estilo de la linea del grafico para ser suave y con un ancho especifico
            series: [
                {
                    name: "Articulos",
                    data: totales, //serie de datos para el grafico obtenida de la variable totales
                },
            ],
            zoom: { enabled: !1 }, //zoom desactivado
            legend: { show: !1 }, //leyenda del grafico desactivada
            colors: (t = a ? a.split(",") : t),
            xaxis: {
                //se configura el eje x con las categorías generadas previamente y se ajustan las opciones de estilo y formato
                // type:"string",
                categories: meses,
                // tooltip:{enabled:!1},
                axisBorder: { show: !1 },
                // labels:{}
            },
            yaxis: {
                //se configura el eje y
                categories: totales,
                labels: {
                    formatter: function (value) {
                        return value + " € ";
                    },
                },
                axisBorder: { show: !1 },
            },
            fill: {
                //estilo de relleno de gradiente para el area bajo la linea en el grafico
                type: "gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100],
                },
            },
        };

    chart = new ApexCharts(document.querySelector("#sessions-overview"), e);
    chart.render();
}
