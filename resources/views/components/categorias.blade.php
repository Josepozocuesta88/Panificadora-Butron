@props(['categorias'])


<div class="favoritos p-0">
    <button id="scrollLeft" class="scrollLeft btn btn-link"><i
            class="bi bi-arrow-left-circle-fill font-24 text-primary"></i></button>
    <div id="categorias" class="categorias scrollbar gap-2">
        @foreach($categorias as $category)
        <div class="categoria col-6 col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('categories', ['catcod' => $category->id]) }}" title="" onclick="irAProductos()">
                    <img src="{{ asset('images/categorias/' . $category->imagen) }}"
                        class="object-fit-fill border rounded w-100" alt="{{ $category->nombre_es }}"
                        style="height:200px;"
                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                </a>
                <div class="nombre-categoria bg-primary text-center">
                    <h5>
                        <a href="{{route('categories', ['catcod' => $category->id])}}" class="text-white"
                            onclick="irAProductos()">
                            {{ $category->nombre_es }}
                        </a>
                    </h5>
                    <a href="{{route('categories', ['catcod' => $category->id])}}" onclick="irAProductos()"
                        class="categoria-link text-warning font-20">Ver más <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        @endforeach
    </div>
    <button id="scrollRight" class="scrollRight btn btn-link"><i
            class="bi bi-arrow-right-circle-fill font-24 text-primary"></i></button>
</div>