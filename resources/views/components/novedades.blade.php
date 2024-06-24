@props(['novedades'])


<div class="favoritos">
    <button id="scrollLeft" class="scrollLeft btn btn-light ">
        <i class="bi bi-arrow-left-circle font-24 text-primary"></i>
    </button>
    <div id="categorias" class="categorias scrollbar gap-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 bg-light pt-3">
        @foreach($novedades as $articulo)
            <div class="col d-flex flex-column align-content-between align-items-center ">
                <div class="card h-100 border border-primary rounded-3 shadow-lg position-relative">
                    <figure class="d-flex bg-white overflow-hidden align-items-center justify-content-center m-0" style="height:325px;">
                        <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}" class="d-block">
                            @if($articulo->imagenes->isNotEmpty())
                                <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}" class="d-block w-100 h-auto" alt="{{ $articulo->artnom }}" title="{{ $articulo->artnom }}" onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                            @else
                                <img src="{{ asset('images/articulos/noimage.jpg') }}" class="d-block w-100 h-auto" alt="no hay imagen" title="No hay imagen">
                            @endif
                        </a>
                    </figure>

                    <div class="card-body pb-0 bg-white">
                        <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}">
                            <h5 class="card-title text-primary">{{ $articulo->artnom }}</h5>
                            <p class="card-text l3truncate">{{ $articulo->artobs }}</p>
                        </a>
                    </div>

                    <div class="card-footer pt-0">
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
                            </li>

                            <li class="list-group-item">
                                <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}" class="ps-lg-4">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" onclick="$('#alertaStock').toast('show')">
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
