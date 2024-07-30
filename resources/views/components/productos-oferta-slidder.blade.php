<div class="slider">
    <div class="slider-wrapper">
        <!-- Slide 1 -->
        <div class="slide">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border border-primary rounded-3 shadow-lg position-relative">
                    <!-- Ícono de la corazon -->
                    @if (in_array($ofertaArticulo->artcod, $favoritos))
                    <i onclick="heart(this)" data-artcod="{{ $ofertaArticulo->artcod }}"
                        class="bi bi-suit-heart-fill red-heart position-absolute top-0 end-0 m-2 font-20 cursor-pointer heartIcon"></i>
                    @else
                    <i onclick="heart(this)" data-artcod="{{ $ofertaArticulo->artcod }}"
                        class="bi bi-suit-heart position-absolute top-0 end-0 m-2 font-20 cursor-pointer heartIcon"></i>
                    @endif
                    <figure class="d-flex bg-white overflow-hidden align-items-center justify-content-center m-0"
                        style="height:325px;">
                        <a href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}" class="d-block">
                            @if ($ofertaArticulo->imagenes->isNotEmpty())
                            <img src="{{ asset('images/articulos/' . $ofertaArticulo->imagenes->first()->imanom) }}"
                                class="d-block w-100 h-auto" alt="{{ $ofertaArticulo->artnom }}"
                                title="{{ $ofertaArticulo->artnom }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                            @else
                            <img src="{{ asset('images/articulos/noimage.jpg') }}" class="d-block w-100 h-auto"
                                alt="no hay imagen" title="No hay imagen">
                            @endif
                        </a>
                    </figure>
                    <div class="card-body pb-0 bg-white">
                        <a href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}">
                            <h5 class="card-title text-primary m-0">{{ $ofertaArticulo->artnom }}</h5>
                            @isset($ofertaArticulo->artobs)
                            <p class="card-text l3truncate">{{ $ofertaArticulo->artobs }}</p>
                            @endisset
                        </a>
                    </div>
                    <div class="card-footer pt-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a class="pe-1" href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}"
                                        data-toggle="fullscreen" title="Stock disponible o no">
                                        @if ($ofertaArticulo->artstocon == 1 || $ofertaArticulo->artstock > 1)
                                        <i class="mdi mdi-archive-check font-24 text-success"></i>
                                        @else
                                        <i class="mdi mdi-archive-cancel font-24 text-danger"></i>
                                        @endif
                                    </a>
                                    <a class="pe-1" href="{{ asset('images/' . $ofertaArticulo->artdocaso) }}"
                                        data-toggle="fullscreen" title="Ficha técnica">
                                        <i class="uil-clipboard-alt font-24"></i>
                                    </a>
                                    <a class="pe-1" href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}"
                                        data-toggle="fullscreen" title="Información">
                                        <i class="mdi mdi-information-outline font-24"></i>
                                    </a>
                                </div>
                                <div class="text-end">
                                    @if ($ofertaArticulo->precioOferta)
                                    <h5>
                                        <span class="badge badge-danger-lighten">
                                            OFERTA
                                            @if ($ofertaArticulo->precioDescuento)
                                            {{ $ofertaArticulo->precioDescuento }}%
                                            @endif
                                        </span>
                                    </h5>
                                    <span class="font-18 text-danger fw-bolder">
                                        {{
                                        \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioOferta)
                                        }}
                                        €
                                    </span>
                                    <span class="text-decoration-line-through font-14">
                                        {{
                                        \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioTarifa)
                                        }}
                                        €
                                    </span>
                                    @elseif(isset($ofertaArticulo->precioTarifa))
                                    <span class="font-18">
                                        {{
                                        \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioTarifa)
                                        }}
                                        €
                                    </span>
                                    @else
                                    <span class="font-18"></span>
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item product-card">
                                <form method="POST"
                                    action="{{ route('cart.add', ['artcod' => $ofertaArticulo->artcod]) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            @if ($ofertaArticulo->cajas->isNotEmpty() && config('app.caja') ==
                                            'si')
                                            <div class="row">
                                                <div class="quantity-input col">
                                                    <input type="number" class="quantity form-control" name="quantity"
                                                        min="1" value="1">
                                                </div>
                                                <div class="col-auto">
                                                    @foreach ($ofertaArticulo->cajas as $index => $caja)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            data-id="$caja->cajartcod" value="{{ $caja->cajcod }}"
                                                            name="input-tipo" id="caja{{ $index }}" @if($caja->cajdef==
                                                        1) checked
                                                        @endif
                                                        >
                                                        <label class="form-check-label" for="caja{{ $index }}">
                                                            @if ($caja->cajreldir > 0)
                                                            {{ $caja->cajreldir }}
                                                            {{ $ofertaArticulo->promedcod }}
                                                            @endif
                                                            @if ($caja->cajcod == '0003')
                                                            (Pieza)
                                                            @elseif($caja->cajcod == '0002')
                                                            (Media)
                                                            @else
                                                            (Caja)
                                                            @endif
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                            <!-- end product price unidades-->
                                        </div>
                                    </div>
                                    <!-- submit -->
                                    <div class="mt-3">
                                        <div class="row align-items-end ">
                                            <button type="submit" class="btn btn-primary ms-2 col"
                                                onclick="$('#alertaStock').toast('show')"><i
                                                    class="mdi mdi-cart me-1"></i>
                                                Añadir</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Repite la estructura de slide para los otros elementos -->
    </div>
    <!-- Botones de navegación -->
    <button class="slider-button prev-button">◀</button>
    <button class="slider-button next-button">▶</button>
</div>
<style>
    /* Contenedor del slider */
    .slider {
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.5s ease;
    }

    .slide {
        flex: 1 0 100%;
    }

    /* Botones de navegación */
    .slider-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 1;
    }

    .prev-button {
        left: 10px;
    }

    .next-button {
        right: 10px;
    }

    /* Responsividad */
    @media (min-width: 576px) {
        .slide {
            flex: 1 0 50%;
        }
    }

    @media (min-width: 992px) {
        .slide {
            flex: 1 0 25%;
        }
    }
</style>

<script>
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const sliderWrapper = document.querySelector('.slider-wrapper');
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;
    const slideWidth = slides[0].clientWidth;

    function updateSlider() {
        sliderWrapper.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
        updateSlider();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateSlider();
    });

    window.addEventListener('resize', () => {
        // Actualiza el ancho del slide en caso de redimensionamiento
        const slideWidth = slides[0].clientWidth;
        updateSlider();
    });

    updateSlider(); // Inicializa el slider
</script>