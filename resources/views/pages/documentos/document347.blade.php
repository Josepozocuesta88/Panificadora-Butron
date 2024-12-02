<!-- ============================================================== -->
<!-- CLIENTE: Para ver histórico de productos que ha comprado -->
<!-- ============================================================== -->
<!-- VER SI SE PUEDE MEZCLAR CON LA PAGINA DE PRODUCTOS DEL ADMINISTRADOR -->


@extends('layouts.app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Resumen 347</li>
                    </ol>
                </div>
                <h4 class="page-title">Resumen 347</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if (session('error'))
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
        <div class="toast show bg-primary" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto text-primary">Alerta</strong>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Cerrar"></button>
            </div>
            <div class="toast-body text-white">
                {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col">
            <table id="resultTable" name="resultTable" class="table table-centered w-100 dt-responsive nowrap">
                <thead class="table-primary">
                    <tr>
                        <td>#</td>
                        <td>Año</td>
                        <td>Trimestre 1</td>
                        <td>Trimestre 2</td>
                        <td>Trimestre 3</td>
                        <td>Trimestre 4</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $index => $anio)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $anio->anio }}</td>
                        <td>{{ $anio->trimestre_1 > 0 ? number_format($anio->trimestre_1, 2)  : '-' }} €</td>
                        <td>{{ $anio->trimestre_2 > 0 ? number_format($anio->trimestre_2, 2)  : '-' }} €</td>
                        <td>{{ $anio->trimestre_3 > 0 ? number_format($anio->trimestre_3, 2)  : '-' }} €</td>
                        <td>{{ $anio->trimestre_4 > 0 ? number_format($anio->trimestre_4, 2)  : '-' }} €</td>
                        <td>{{ $anio->total > 0 ? number_format($anio->total, 2)  : '-' }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <span>
                <p class="text-primary">Para descargar los datos correspondiente a un solo año, busque el año y luego puede imprimirlo.</p>
            </span>
        </div>
    </div>





</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#resultTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                text: 'Descargar PDF',
                title: 'Reporte de Totales por Año',
                className: 'btn btn-primary btn-sm mb-3 mt-3',
                orientation: 'portrait',
                pageSize: 'A4',
                customize: function(doc) {
                    doc.content = [{
                            text: 'Reporte Modelo 347',
                            style: 'title',
                            alignment: 'left',
                            margin: [0, 20, 0, 10]
                        },
                        {
                            text: 'Con el motivo de la ]Declaración anual de operaciones realizadas con terceros (Modelo 347), correspondiente al ejercicio anterior, que en próximas fechas hemos de presentar ante la Agencia Tributaría, pasamos a comunicarle/s los datos y cantidades que incluiremos en dicho modelo motivados por nuestra relacion comercial.',
                            style: 'subheader',
                            alignment: 'left',
                            margin: [0, 0, 0, 20]
                        },
                        {
                            table: {
                                widths: ['10%', '15%', '15%', '15%', '15%', '15%', '15%'],
                                body: []
                            },
                            layout: 'lightHorizontalLines',
                            style: 'tableStyle'
                        },
                        {
                            text: 'En caso de estar en desacuerdo con alguno de los datos mencionados, rogamos se ponga en contacto con la persona indicada antes del proximo cierre. De no recibir noticias suyas entenderemos correctos nuestro datos.',
                            style: 'footerText',
                            alignment: 'left',
                            margin: [0, 20, 0, 0]
                        }
                    ];

                    var tableData = [];
                    $('#resultTable tbody tr').each(function() {
                        var rowData = [];
                        $(this).find('td').each(function() {
                            rowData.push($(this).text());
                        });
                        tableData.push(rowData);
                    });

                    doc.content[2].table.body = [
                        ['#', 'Año', 'Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Trimestre 4', 'Total'], // Encabezado de la tabla
                        ...tableData
                    ];

                    // Estilos
                    doc.styles.title = {
                        fontSize: 18,
                        bold: true,
                        alignment: 'center',
                        margin: [0, 20, 0, 10]
                    };

                    doc.styles.subheader = {
                        fontSize: 12,
                        italics: true,
                        alignment: 'center',
                        color: '#555',
                    };

                    doc.styles.tableStyle = {
                        fontSize: 10,
                        alignment: 'center',
                    };

                    doc.styles.footerText = {
                        fontSize: 10,
                        alignment: 'center',
                        margin: [0, 10, 0, 10],
                    };

                    doc.styles.tableHeader = {
                        fontSize: 12,
                        bold: true,
                        alignment: 'center',
                        fillColor: '#daf0f9',
                        color: 'black'
                    };

                    doc.styles.tableBodyEven = {
                        alignment: 'center',
                        fontSize: 10
                    };

                    doc.styles.tableBodyOdd = {
                        alignment: 'center',
                        fontSize: 10
                    };

                    doc.content[2].layout = {
                        hLineWidth: function(i, node) {
                            if (i === 0) return 0;
                            return 0.5;
                        },

                        vLineWidth: function() {
                            return 0;
                        },
                        hLineColor: function() {
                            return '#aaa';
                        },
                        vLineColor: function() {
                            return 'white';
                        },
                        paddingLeft: function() {
                            return 5;
                        },
                        paddingRight: function() {
                            return 5;
                        },
                        paddingTop: function() {
                            return 5;
                        },
                        paddingBottom: function() {
                            return 5;
                        }
                    };

                    doc.footer = function(currentPage, pageCount) {
                        return {
                            text: `Página ${currentPage} de ${pageCount}`,
                            alignment: 'center',
                            margin: [0, 10, 0, 0],
                            fontSize: 8
                        };
                    };
                }
            }],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            initComplete: function() {
                $(".dt-buttons").css({
                    "text-align": "right",
                    "width": "100%"
                });
            }
        });
    });
</script>
@endpush