@props(['novedades'])

<div class="favoritos">
    <button id="scrollLeft" class="scrollLeft btn btn-light ">
        <i class="bi bi-arrow-left-circle font-24 text-primary"></i>
    </button>
    <div id="categorias" class="gap-3 pt-3 categorias scrollbar row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 bg-light">
        @foreach($novedades as $articulo)
        <div class="col d-flex flex-column align-content-between align-items-center ">
            <div class="border shadow-lg card h-100 border-primary rounded-3 position-relative">
                <figure class="m-0 overflow-hidden bg-white d-flex align-items-center justify-content-center" style="height:325px;">
                    <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}" class="d-block position-relative">
                        @if($articulo->imagenes->isNotEmpty())
                        <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}" class="h-auto d-block w-100" alt="{{ $articulo->artnom }}" title="{{ $articulo->artnom }}" onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                        @else
                        <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100" alt="no hay imagen" title="No hay imagen">
                        @endif
                    </a>
                    <!-- Temporada -->
                    @if(isset($articulo->arttemporada) && $articulo->arttemporada === 1)
                    <div class="top-0 cursor-pointer position-absolute start-0 font-20" style="margin-top: -10px; margin-left: -10px;">
                        <span class="badge bg-primary p-2">
                            <i class="mdi mdi-alert-circle-outline pulse-icon"></i>
                            Temporada
                        </span>
                    </div>
                    @endif
                </figure>
                <div class="pb-0 bg-white card-body">
                    <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}">
                        <h5 class="card-title text-primary">{{ $articulo->artnom }}</h5>
                        <p class="card-text l3truncate">{{ $articulo->artobs }}</p>
                    </a>
                </div>
                <div class="pt-0 card-footer">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a class="pe-1" href="{{ route('info', ['artcod' => $articulo->artcod]) }}" data-toggle="fullscreen" title="Stock disponible o no">
                                    @if($articulo->artstocon == 1)
                                    <i class="mdi mdi-archive-cancel font-24 text-danger"></i>
                                    @else
                                    <i class="mdi mdi-archive-check font-24 text-success"></i>
                                    @endif
                                </a>
                                <a class="pe-1" href="{{ asset('images/' . $articulo->artdocaso) }}" data-toggle="fullscreen" title="Ficha técnica">
                                    <i class="uil-clipboard-alt font-24"></i>
                                </a>
                                <a class="pe-1" href="{{ route('info', ['artcod' => $articulo->artcod]) }}" data-toggle="fullscreen" title="Información">
                                    <i class="mdi mdi-information-outline font-24"></i>
                                </a>
                            </div>
                            <div class="text-end">
                                @if ($articulo->precioOferta)
                                <h5>
                                    <span class="badge badge-danger-lighten">
                                        OFERTA
                                        @if ($articulo->precioDescuento)
                                        {{ $articulo->precioDescuento }}%
                                        @endif
                                    </span>
                                </h5>
                                <span class="font-18 text-danger fw-bolder">
                                    {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioOferta) }}
                                    €
                                </span>
                                <span class="text-decoration-line-through font-14">
                                    {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }}
                                    €
                                </span>
                                @elseif(isset($articulo->precioTarifa))
                                <span class="font-18">
                                    {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }}
                                    €
                                </span>
                                @else
                                <span class="font-18"></span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item">
                            <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}" class="ps-lg-4">
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    onclick="$('#alertaStock').toast('show')"
                                    @if(isset($articulo->arttemporada) && $articulo->arttemporada === 1) disabled @endif>
                                    Añadir al carrito
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <button id="scrollRight" class="scrollRight btn btn-light ">
        <i class="bi bi-arrow-right-circle font-24 text-primary"></i>
    </button>
</div>