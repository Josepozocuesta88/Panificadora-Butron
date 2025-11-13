@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary: #0166a3;
    --primary-dark: #1e40af;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-600: #4b5563;
    --gray-900: #111827;
  }

  /* ===== BOOTSTRAP CAROUSEL FULL WIDTH ===== */
  .full-width-banner {
    margin: 0;
    padding: 0;
    width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    margin-bottom: 3rem;
  }

  .full-width-banner .carousel-item img {
    height: 500px;
    object-fit: cover;
  }

  @media (max-width: 768px) {
    .full-width-banner .carousel-item img {
      height: 300px;
    }
  }

  /* PRODUCT CARDS */
  .product-card {
    background: white;
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    height: 100%;
    position: relative;
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  }

  .product-image {
    height: 220px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }

  .product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .product-card:hover .product-image img {
    transform: scale(1.05);
  }

  .heart-icon {
    position: absolute;
    top: 12px;
    right: 12px;
    background: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    z-index: 2;
    transition: all 0.3s ease;
  }

  .heart-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .heart-icon.active i {
    color: #ef4444;
  }

  .product-content {
    padding: 1.5rem;
  }

  .product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    line-height: 1.4;
  }

  .product-description {
    color: var(--gray-600);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
  }

  .product-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
  }

  .action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--gray-100);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0166a3;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .action-btn:hover {
    background: #0166a3;
    color: white;
    transform: translateY(-2px);
  }

  .product-price {
    margin-bottom: 1rem;
  }

  .offer-badge {
    display: inline-block;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .price-current {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0166a3;
  }

  .price-original {
    font-size: 0.9rem;
    color: #4b5563;
    text-decoration: line-through;
    margin-left: 0.5rem;
  }

  .add-to-cart {
    width: 100%;
    background: #0166a3;
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .add-to-cart:hover {
    background: #014f7f;
    transform: translateY(-2px);
  }

  /* SECTION HEADERS */
  .section-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #0166a3;
    margin-bottom: 0.5rem;
  }

  .section-subtitle {
    color: #4b5563;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
  }

  /* RESPONSIVE */
  /* Ofertas Section */
  .offers-section {
    padding: var(--section-padding) 0;
    background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
  }

  .section-header {
    margin-bottom: 3rem;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #0166a3;
    margin-bottom: 0.5rem;
  }

  .section-subtitle {
    color: #4b5563;
    font-size: 1.1rem;
    margin: 0;
  }

  .minimal-banner-link:hover .minimal-badge {
    background: #0166a3;
    color: white;
  }

  /* Minimal Navigation Controls */
  .minimal-control {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
  }

  .minimal-carousel:hover .minimal-control {
    opacity: 1;
  }

  .minimal-control:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: scale(1.05);
  }

  .minimal-control .carousel-control-prev-icon,
  .minimal-control .carousel-control-next-icon {
    width: 16px;
    height: 16px;
    background-size: 100%;
  }

  /* Minimal Indicators */
  .minimal-indicators {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .minimal-indicators button {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.5);
    transition: all 0.3s ease;
    cursor: pointer;
    padding: 0;
    margin: 0;
    text-indent: -9999px;
  }

  .minimal-indicators button.active {
    background: white;
    transform: scale(1.2);
  }

  .minimal-indicators button:hover {
    background: rgba(255, 255, 255, 0.8);
  }

  /* Responsive Design for Minimal Banner */
  @media (max-width: 768px) {
    .minimal-carousel {
      height: 250px;
    }

    .minimal-overlay {
      top: 15px;
      right: 15px;
    }

    .minimal-badge {
      padding: 0.4rem 0.8rem;
      font-size: 0.8rem;
    }
  }

  @media (max-width: 576px) {
    .minimal-carousel {
      height: 200px;
    }

    .minimal-overlay {
      top: 10px;
      right: 10px;
    }

    .minimal-badge {
      padding: 0.3rem 0.6rem;
      font-size: 0.75rem;
    }
  }

  /* ===== OFERTAS SECTION HEADER ===== */
  .offers-header {
    padding: 2rem 0;
    margin-bottom: 3rem;
    position: relative;
  }

  .offers-title {
    font-size: 2.5rem;
    font-weight: 300;
    color: #1e293b;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
    position: relative;
  }

  .offers-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, #2563eb, #3b82f6);
    border-radius: 1px;
  }

  .offers-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 300;
    margin: 0;
    margin-top: 1rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
  }

  @media (max-width: 768px) {
    .offers-header {
      padding: 1.5rem 0;
      margin-bottom: 2rem;
    }

    .offers-title {
      font-size: 2rem;
    }

    .offers-subtitle {
      font-size: 1rem;
    }
  }

  @media (max-width: 576px) {
    .offers-title {
      font-size: 1.75rem;
    }

    .offers-subtitle {
      font-size: 0.95rem;
    }
  }

  /* ===== OFERTAS PRODUCTS GRID ===== */
  @media (min-width: 992px) {
    .offers-products .col-lg {
      flex: 0 0 20%;
      max-width: 20%;
    }
  }

  @media (min-width: 1200px) {
    .offers-products .col-xl {
      flex: 0 0 20%;
      max-width: 20%;
    }
  }

  /* ===== CLEAN MINIMAL CARDS DESIGN ===== */
  .clean-product-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    padding: 0;
    border: 1px solid #f0f0f0;
  }

  .clean-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: #0166a3;
  }

  /* Product Heart Icon */
  .product-heart {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
    background: white;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    color: #0166a3;
  }

  .product-heart:hover {
    transform: scale(1.1);
    color: #0166a3;
  }

  .product-heart.active {
    color: #0166a3;
    background: #fef2f2;
  }

  /* Product Image Container */
  .product-image-container {
    position: relative;
    overflow: hidden;
    background: #f8fafc;
    height: 200px;
  }

  .product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .clean-product-card:hover .product-image {
    transform: scale(1.05);
  }

  /* Red Offer Badge with Border */
  .offer-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #dc3545;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Product Content */
  .product-content {
    padding: 16px;
  }

  /* Product Title with Blue Accent */
  .product-title {
    margin: 0 0 10px 0;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.3;
    height: 36px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  .product-title a {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .product-title a:hover {
    color: #2563eb;
  }

  /* Price Info with Blue Highlights */
  .price-info {
    margin: 12px 0;
    min-height: 30px;
  }

  .price-offer {
    font-size: 18px;
    font-weight: 700;
    color: #0166a3;
    margin-bottom: 2px;
  }

  .price-original {
    font-size: 14px;
    color: #64748b;
    text-decoration: line-through;
  }

  .price-normal {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
  }

  /* Stock Status with Blue/Red Colors */
  .stock-status {
    margin: 12px 0;
  }

  .stock-available {
    color: #2563eb;
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .stock-unavailable {
    color: #dc3545;
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* Package Selector */
  .package-info {
    margin: 12px 0;
  }

  .package-selector {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    color: #64748b;
    background: white;
    transition: border-color 0.3s ease;
  }

  .package-selector:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
  }

  /* Action Buttons Side by Side */
  .action-buttons {
    display: flex;
    gap: 8px;
    margin-top: 16px;
  }

  .btn-detail,
  .btn-detail,
  .btn-add {
    flex: 1;
    padding: 8px 6px;
    border-radius: 5px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 3px;
    text-align: center;
    width: 100%;
  }

  .btn-detail {
    background: white;
    color: #0166a3;
    border: 1px solid #0166a3;
  }

  .btn-detail:hover {
    background: #0166a3;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(1, 102, 163, 0.3);
  }

  .btn-add {
    background: #0166a3;
    color: white;
    border: 1px solid #0166a3;
  }

  .btn-add:hover {
    background: #0166a3;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(1, 102, 163, 0.4);
  }

  .add-form {
    flex: 1;
    margin: 0;
  }

  /* Icons in buttons */
  .btn-detail i,
  .btn-add i {
    font-size: 10px;
  }

  /* ===== MOBILE CAROUSEL FOR PRODUCTS ===== */
  .mobile-products-carousel {
    display: none;
  }

  @media (max-width: 767px) {
    .desktop-products-grid {
      display: none;
    }

    .mobile-products-carousel {
      display: block;
      margin-bottom: 40px;
    }

    .mobile-carousel .carousel-inner {
      padding: 0 15px;
    }

    .mobile-carousel .carousel-item {
      padding: 0 8px;
    }

    .mobile-carousel .clean-product-card {
      width: 300px;
      margin: 0 auto;
      max-width: 90vw;
    }

    /* Adjustments for mobile cards */
    .mobile-carousel .product-image-container {
      height: 180px;
    }

    .mobile-carousel .product-content {
      padding: 14px;
    }

    .mobile-carousel .product-title {
      font-size: 14px;
      height: 40px;
    }

    .mobile-carousel .price-offer,
    .mobile-carousel .price-normal {
      font-size: 20px;
    }

    .mobile-carousel .stock-available,
    .mobile-carousel .stock-unavailable {
      font-size: 13px;
    }

    .mobile-carousel .btn-detail,
    .mobile-carousel .btn-add {
      font-size: 11px;
      padding: 10px 8px;
    }

    /* Mobile Carousel Controls */
    .mobile-carousel .carousel-control-prev,
    .mobile-carousel .carousel-control-next {
      width: 45px;
      height: 45px;
      background: rgba(1, 102, 163, 0.9);
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0.9;
      border: 2px solid white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .mobile-carousel .carousel-control-prev {
      left: -22px;
    }

    .mobile-carousel .carousel-control-next {
      right: -22px;
    }

    .mobile-carousel .carousel-control-prev:hover,
    .mobile-carousel .carousel-control-next:hover {
      opacity: 1;
      transform: translateY(-50%) scale(1.05);
    }

    .mobile-carousel .carousel-control-prev-icon,
    .mobile-carousel .carousel-control-next-icon {
      width: 20px;
      height: 20px;
    }

    /* Mobile Carousel Indicators */
    .mobile-carousel .carousel-indicators {
      bottom: -35px;
      margin-bottom: 0;
    }

    .mobile-carousel .carousel-indicators button {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: rgba(1, 102, 163, 0.3);
      border: none;
      margin: 0 4px;
      transition: all 0.3s ease;
    }

    .mobile-carousel .carousel-indicators button.active {
      background-color: #0166a3;
      transform: scale(1.2);
    }

    .mobile-carousel .carousel-indicators button:hover {
      background-color: rgba(1, 102, 163, 0.6);
    }
  }

  /* Responsive adjustments */
  @media (max-width: 576px) {
    .clean-product-card {
      margin-bottom: 20px;
    }

    .product-content {
      padding: 12px;
    }

    .action-buttons {
      flex-direction: column;
      gap: 4px;
    }

    .btn-detail,
    .btn-add {
      flex: none;
      font-size: 9px;
      padding: 6px 4px;
    }
  }

  /* ===== DISEÑO RESPONSIVO PARA CARDS DE ESCRITORIO (BASADO EN VIEWPORT) ===== */
  /* Estas reglas hacen que las cards escalen proporcionalmente con el tamaño de la pantalla */

  @media (min-width: 768px) {

    /* Altura de imagen proporcional al viewport */
    .desktop-product-image {
      height: clamp(200px, 18vh, 400px);
    }

    /* Padding del body proporcional */
    .desktop-card-body {
      padding: clamp(0.8rem, 1vw, 1.5rem);
    }

    /* Título escalable */
    .desktop-product-title {
      font-size: clamp(0.9rem, 1.1vw, 1.4rem);
      line-height: 1.3;
    }

    /* Descripción escalable */
    .desktop-product-description {
      font-size: clamp(0.75rem, 0.9vw, 1.1rem);
      line-height: 1.4;
    }

    /* Iconos escalables */
    .desktop-icon {
      font-size: clamp(18px, 1.5vw, 28px);
    }

    /* Icono corazón */
    .desktop-heart-icon {
      font-size: clamp(16px, 1.3vw, 24px);
    }

    /* Badge escalable */
    .desktop-badge {
      font-size: clamp(0.65rem, 0.8vw, 1rem);
      padding: clamp(0.2rem, 0.3vw, 0.5rem) clamp(0.4rem, 0.6vw, 0.8rem);
    }

    /* Precios escalables */
    .desktop-price-offer {
      font-size: clamp(1rem, 1.2vw, 1.6rem);
    }

    .desktop-price-original {
      font-size: clamp(0.8rem, 0.95vw, 1.2rem);
    }

    .desktop-price-normal {
      font-size: clamp(1rem, 1.2vw, 1.6rem);
    }

    /* Footer padding */
    .desktop-card-footer {
      padding: clamp(0.6rem, 0.9vw, 1.2rem);
    }

    /* Input y labels escalables */
    .desktop-input {
      font-size: clamp(0.8rem, 0.95vw, 1.1rem);
      padding: clamp(0.3rem, 0.5vw, 0.7rem);
    }

    .desktop-label {
      font-size: clamp(0.75rem, 0.9vw, 1.05rem);
    }

    .desktop-radio {
      width: clamp(14px, 1.1vw, 20px);
      height: clamp(14px, 1.1vw, 20px);
    }

    /* Botón escalable */
    .desktop-btn {
      font-size: clamp(0.85rem, 1vw, 1.2rem);
      padding: clamp(0.4rem, 0.6vw, 0.9rem) clamp(0.6rem, 0.9vw, 1.2rem);
    }

    /* Border radius proporcional */
    .desktop-product-card {
      border-radius: clamp(8px, 0.8vw, 16px);
    }
  }

  /* Ajustes específicos para pantallas medianas (tablets grandes y laptops pequeños) */
  @media (min-width: 768px) and (max-width: 1199px) {
    .desktop-product-image {
      height: clamp(180px, 16vh, 280px);
    }
  }

  /* Ajustes para pantallas grandes (laptops y monitores pequeños) */
  @media (min-width: 1200px) and (max-width: 1599px) {
    .desktop-product-image {
      height: clamp(220px, 17vh, 320px);
    }
  }

  /* Ajustes para pantallas extra grandes (monitores grandes 24"-27") */
  @media (min-width: 1600px) and (max-width: 1919px) {
    .desktop-product-image {
      height: clamp(240px, 18vh, 360px);
    }

    .desktop-product-title {
      font-size: clamp(1rem, 1.15vw, 1.5rem);
    }
  }

  /* Ajustes para pantallas XXL (monitores 27"+ y 4K) */
  @media (min-width: 1920px) and (max-width: 2559px) {
    .desktop-product-image {
      height: clamp(280px, 19vh, 420px);
    }

    .desktop-product-title {
      font-size: clamp(1.1rem, 1.2vw, 1.6rem);
    }

    .desktop-icon {
      font-size: clamp(22px, 1.6vw, 32px);
    }
  }

  /* Ajustes para pantallas ultra anchas (monitores 32"+ y ultra-wide) */
  @media (min-width: 2560px) {
    .desktop-product-image {
      height: clamp(320px, 20vh, 480px);
    }

    .desktop-product-title {
      font-size: clamp(1.2rem, 1.25vw, 1.8rem);
    }

    .desktop-product-description {
      font-size: clamp(0.9rem, 1vw, 1.3rem);
    }

    .desktop-icon {
      font-size: clamp(24px, 1.7vw, 36px);
    }

    .desktop-price-offer,
    .desktop-price-normal {
      font-size: clamp(1.2rem, 1.3vw, 1.8rem);
    }
  }
</style>

<!-- Sección de Ofertas Unificada -->
@if(($articulosOferta && !$articulosOferta->isEmpty()) || ($existeOferta == 1) || ($articulosOfertaPer && !$articulosOfertaPer->isEmpty()))
<div class="offers-section">
  <div class="container">

    <!-- Banner Carousel de Ofertas Personalizadas -->
    @if($existeOferta == 1 && $ofertasPer && !$ofertasPer->isEmpty())
  </div> <!-- Cierre temporal del container -->

  <div class="full-width-banner">
    <div id="offersCarousel" class="carousel slide" data-bs-ride="carousel">
      <!-- Indicadores -->
      @if(count($ofertasPer) > 1)
      <div class="carousel-indicators">
        @foreach ($ofertasPer as $index => $image)
        <button type="button" data-bs-target="#offersCarousel" data-bs-slide-to="{{ $index }}"
          class="{{ $loop->first ? 'active' : '' }}"
          aria-current="{{ $loop->first ? 'true' : 'false' }}"
          aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
      </div>
      @endif

      <!-- Carousel Inner -->
      <div class="carousel-inner">
        @foreach ($ofertasPer as $image)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
          <img src="{{ asset('images/ofertas/' . trim($image->ofcima)) }}"
            class="d-block w-100"
            alt="Oferta especial">
        </div>
        @endforeach
      </div>

      <!-- Controles -->
      @if(count($ofertasPer) > 1)
      <button class="carousel-control-prev" type="button" data-bs-target="#offersCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#offersCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
      @endif
    </div>
  </div>

  <div class="container-fluid px-2"> <!-- Reapertura del container -->
    @endif <!-- Grid de Productos en Oferta -->
    @php
    $allOffers = collect();
    if($articulosOferta && !$articulosOferta->isEmpty()) {
    $allOffers = $allOffers->merge($articulosOferta);
    }
    if($articulosOfertaPer && !$articulosOfertaPer->isEmpty()) {
    $allOffers = $allOffers->merge($articulosOfertaPer);
    }
    $allOffers = $allOffers->unique('artcod');
    @endphp

    @if($allOffers->isNotEmpty())
    <section id="productos" class="mb-5">
      <!-- Sección Header Minimalista -->
      <div class="offers-header text-center mb-2">
        <h2 class="offers-title">Ofertas especiales</h2>
        <p class="offers-subtitle">Descubre nuestra selección de productos con los mejores precios</p>
      </div>

      <div class="offers-products mt-2">
        <!-- Desktop/Tablet Grid -->
        <div class="desktop-products-grid">
          <div class="row g-2">
            @foreach ($allOffers as $offerProduct)
            <div class="col-6 col-md-4 col-lg col-xl">
              <div class="clean-product-card">
                <!-- Heart Icon -->
                @if (in_array($offerProduct->artcod, $favoritos))
                <i onclick="heart(this)" data-artcod="{{ $offerProduct->artcod }}"
                  class="product-heart active bi bi-suit-heart-fill"></i>
                @else
                <i onclick="heart(this)" data-artcod="{{ $offerProduct->artcod }}"
                  class="product-heart bi bi-suit-heart"></i>
                @endif

                <!-- Product Image -->
                <div class="product-image-container">
                  <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}">
                    @if ($offerProduct->imagenes->isNotEmpty())
                    <img src="{{ asset('images/articulos/' . $offerProduct->imagenes->first()->imanom) }}"
                      alt="{{ $offerProduct->artnom }}"
                      class="product-image"
                      onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                    @else
                    <img src="{{ asset('images/articulos/noimage.jpg') }}" alt="Sin imagen" class="product-image">
                    @endif
                  </a>

                  <!-- Offer Badge with Red Border -->
                  @if ($offerProduct->precioOferta)
                  <div class="offer-badge">
                    @if ($offerProduct->precioDescuento)
                    -{{ $offerProduct->precioDescuento }}%
                    @else
                    OFERTA
                    @endif
                  </div>
                  @endif
                </div>

                <!-- Product Info -->
                <div class="product-content">
                  <!-- Product Name -->
                  <h6 class="product-title">
                    <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}">
                      {{ $offerProduct->artnom }}
                    </a>
                  </h6>

                  <!-- Price Section -->
                  <div class="price-info">
                    @if ($offerProduct->precioOferta)
                    <div class="price-offer">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioOferta) }} €</div>
                    <div class="price-original">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioTarifa) }} €</div>
                    @elseif(isset($offerProduct->precioTarifa))
                    <div class="price-normal">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioTarifa) }} €</div>
                    @endif
                  </div>

                  <!-- Stock Status -->
                  <div class="stock-status">
                    @if ($offerProduct->artstocon == 1 || $offerProduct->artstock > 1)
                    <span class="stock-available">
                      <i class="bi bi-check-circle-fill"></i> Disponible
                    </span>
                    @else
                    <span class="stock-unavailable">
                      <i class="bi bi-x-circle-fill"></i> Sin stock
                    </span>
                    @endif
                  </div>

                  <!-- Package Selection -->
                  @if ($offerProduct->cajas->isNotEmpty() && config('app.caja') == 'si')
                  <div class="package-info">
                    <select name="package-{{ $offerProduct->artcod }}" class="package-selector" id="package-{{ $offerProduct->artcod }}">
                      @foreach ($offerProduct->cajas as $caja)
                      <option value="{{ $caja->cajcod }}" @if($caja->cajdef == 1) selected @endif>
                        @if ($caja->cajreldir > 0){{ $caja->cajreldir }} {{ $offerProduct->promedcod }} @endif
                        @if ($caja->cajcod == '0003')(Pieza)@elseif($caja->cajcod == '0002')(Media)@else(Caja)@endif
                      </option>
                      @endforeach
                    </select>
                  </div>
                  @endif

                  <!-- Action Buttons Side by Side -->
                  <div class="action-buttons">
                    <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}" class="btn-detail">
                      <i class="bi bi-eye"></i>
                      VER DETALLE
                    </a>

                    <form method="POST" action="{{ route('cart.add', ['artcod' => $offerProduct->artcod]) }}" class="add-form">
                      @csrf
                      <input type="hidden" name="quantity" value="1">
                      <input type="hidden" name="input-tipo" value="{{ $offerProduct->cajas->isNotEmpty() ? $offerProduct->cajas->where('cajdef', 1)->first()->cajcod ?? $offerProduct->cajas->first()->cajcod : '' }}">
                      <button type="submit" class="btn-add" onclick="$('#alertaStock').toast('show')">
                        <i class="bi bi-cart-plus"></i>
                        AÑADIR
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Mobile Carousel -->
        <div class="mobile-products-carousel">
          <div id="mobileProductsCarousel" class="carousel slide mobile-carousel" data-bs-ride="carousel">
            <!-- Indicators -->
            @if(count($allOffers) > 1)
            <div class="carousel-indicators">
              @foreach ($allOffers as $index => $product)
              <button type="button" data-bs-target="#mobileProductsCarousel" data-bs-slide-to="{{ $index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                aria-label="Producto {{ $index + 1 }}"></button>
              @endforeach
            </div>
            @endif

            <!-- Carousel Inner -->
            <div class="carousel-inner">
              @foreach ($allOffers as $offerProduct)
              <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="clean-product-card">
                  <!-- Heart Icon -->
                  @if (in_array($offerProduct->artcod, $favoritos))
                  <i onclick="heart(this)" data-artcod="{{ $offerProduct->artcod }}"
                    class="product-heart active bi bi-suit-heart-fill"></i>
                  @else
                  <i onclick="heart(this)" data-artcod="{{ $offerProduct->artcod }}"
                    class="product-heart bi bi-suit-heart"></i>
                  @endif

                  <!-- Product Image -->
                  <div class="product-image-container">
                    <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}">
                      @if ($offerProduct->imagenes->isNotEmpty())
                      <img src="{{ asset('images/articulos/' . $offerProduct->imagenes->first()->imanom) }}"
                        alt="{{ $offerProduct->artnom }}"
                        class="product-image"
                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                      @else
                      <img src="{{ asset('images/articulos/noimage.jpg') }}" alt="Sin imagen" class="product-image">
                      @endif
                    </a>

                    <!-- Offer Badge with Red Border -->
                    @if ($offerProduct->precioOferta)
                    <div class="offer-badge">
                      @if ($offerProduct->precioDescuento)
                      -{{ $offerProduct->precioDescuento }}%
                      @else
                      OFERTA
                      @endif
                    </div>
                    @endif
                  </div>

                  <!-- Product Info -->
                  <div class="product-content">
                    <!-- Product Name -->
                    <h6 class="product-title">
                      <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}">
                        {{ $offerProduct->artnom }}
                      </a>
                    </h6>

                    <!-- Price Section -->
                    <div class="price-info">
                      @if ($offerProduct->precioOferta)
                      <div class="price-offer">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioOferta) }} €</div>
                      <div class="price-original">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioTarifa) }} €</div>
                      @elseif(isset($offerProduct->precioTarifa))
                      <div class="price-normal">{{ \App\Services\FormatoNumeroService::convertirADecimal($offerProduct->precioTarifa) }} €</div>
                      @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="stock-status">
                      @if ($offerProduct->artstocon == 1 || $offerProduct->artstock > 1)
                      <span class="stock-available">
                        <i class="bi bi-check-circle-fill"></i> Disponible
                      </span>
                      @else
                      <span class="stock-unavailable">
                        <i class="bi bi-x-circle-fill"></i> Sin stock
                      </span>
                      @endif
                    </div>

                    <!-- Package Selection -->
                    @if ($offerProduct->cajas->isNotEmpty() && config('app.caja') == 'si')
                    <div class="package-info">
                      <select name="package-{{ $offerProduct->artcod }}" class="package-selector" id="package-mobile-{{ $offerProduct->artcod }}">
                        @foreach ($offerProduct->cajas as $caja)
                        <option value="{{ $caja->cajcod }}" @if($caja->cajdef == 1) selected @endif>
                          @if ($caja->cajreldir > 0){{ $caja->cajreldir }} {{ $offerProduct->promedcod }} @endif
                          @if ($caja->cajcod == '0003')(Pieza)@elseif($caja->cajcod == '0002')(Media)@else(Caja)@endif
                        </option>
                        @endforeach
                      </select>
                    </div>
                    @endif

                    <!-- Action Buttons Side by Side -->
                    <div class="action-buttons">
                      <a href="{{ route('info', ['artcod' => $offerProduct->artcod]) }}" class="btn-detail">
                        <i class="bi bi-eye"></i>
                        VER DETALLE
                      </a>

                      <form method="POST" action="{{ route('cart.add', ['artcod' => $offerProduct->artcod]) }}" class="add-form">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="input-tipo" value="{{ $offerProduct->cajas->isNotEmpty() ? $offerProduct->cajas->where('cajdef', 1)->first()->cajcod ?? $offerProduct->cajas->first()->cajcod : '' }}">
                        <button type="submit" class="btn-add" onclick="$('#alertaStock').toast('show')">
                          <i class="bi bi-cart-plus"></i>
                          AÑADIR
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            <!-- Controls -->
            @if(count($allOffers) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#mobileProductsCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mobileProductsCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
            @endif
          </div>
        </div>
      </div>
      @endif
  </div>
</div>
</section>
@endif
<!-- Fin Sección de Ofertas Unificada -->

<section class="py-2 mt-3" id="productos">
  <div class="container">
    @isset($catnom)
    <h3 class="pb-2 text-primary">{{$catnom}}</h3>
    @endisset

    <!-- Controles para móviles -->
    <div class="d-block d-lg-none pb-3">
      <div class="row g-2">
        @isset($catnom)
        <div class="col-12">
          <a class="btn btn-outline-primary w-100" href="{{ route('search') }}">
            <i class="bi bi-arrow-left me-1"></i>Ver todos los productos
          </a>
        </div>
        @endisset

        <div class="col-6">
          <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#categoriasCollapse"
            aria-expanded="false" aria-controls="categoriasCollapse">
            <i class="bi bi-grid-3x3-gap me-1"></i>Categorías
          </button>
        </div>

        <div class="col-6">
          <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#menuLateralFormulario"
            aria-expanded="false" aria-controls="menuLateralFormulario">
            <i class="bi bi-funnel me-1"></i>Filtros
          </button>
        </div>

        <div class="col-12">
          <form method="GET" action="{{ route('search') }}">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="Buscar artículos..." name="query">
              <button class="btn btn-primary" type="submit">
                <i class="mdi mdi-magnify"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Controles para pantallas grandes (diseño original) -->
    <div class="gap-3 pb-3 d-none d-lg-flex justify-content-end">
      @isset($catnom)
      <a class="btn btn-primary" href="{{ route('search') }}">
        Ver todos los productos
      </a>
      @endisset

      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#categoriasCollapse"
        aria-expanded="false" aria-controls="categoriasCollapse">
        Categorías
      </button>

      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#menuLateralFormulario"
        aria-expanded="false" aria-controls="menuLateralFormulario">
        Opciones de Ordenación
      </button>

      <div class="app-search dropdown" style="width: auto;">
        <!-- buscar producto -->
        <form method="GET" action="{{ route('search') }}">
          <div class="input-group">
            <input type="search" class="form-control dropdown-toggle" placeholder="Buscar artículos..." id="top-search"
              name="query">
            <span class="mdi mdi-magnify search-icon"></span>
            <button class="input-group-text btn btn-primary" type="submit">Buscar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Collapse ordenaciones  -->
    <div class="collapse" id="menuLateralFormulario">

      <div class="card card-body">

        <form action="{{ route('filtrarArticulos', ['catnom' => $catnom ?? null]) }}" method="GET"
          class="container mt-4 ordenacion-formulario">

          <h3 class="mb-4 text-center">Ordenar Productos</h3>
          <p class="text-center">Seleccione cómo desea ordenar los productos. Puede combinar múltiples
            criterios.</p>

          <!-- Opciones de Ordenación -->
          <div class="ordenacion-opciones row justify-content-center">

            <!-- Sección: Ordenar por Nombre -->
            <div class="mb-3 col-md-4">
              <p class="font-weight-bold">Ordenar por nombre:</p>
              <div class="form-check">
                <input type="checkbox" name="orden_nombre" value="asc" id="orden_nombre_asc"
                  class="form-check-input checkbox-orden-nombre">
                <label class="form-check-label" for="orden_nombre_asc">A - Z</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="orden_nombre" value="desc" id="orden_nombre_desc"
                  class="form-check-input checkbox-orden-nombre">
                <label class="form-check-label" for="orden_nombre_desc">Z - A</label>
              </div>

            </div>

            <!-- Sección: Ordenar por Precio -->
            <div class="mb-3 col-md-4">
              <p class="font-weight-bold">Ordenar por precio:</p>
              <div class="form-check">
                <input type="checkbox" name="orden_precio" value="asc" id="orden_precio_asc"
                  class="form-check-input checkbox-orden-precio" @guest disabled @endguest>
                <label class="form-check-label" for="orden_precio_asc">Menor a Mayor</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="orden_precio" value="desc" id="orden_precio_desc"
                  class="form-check-input checkbox-orden-precio" @guest disabled @endguest>
                <label class="form-check-label" for="orden_precio_desc">Mayor a Menor</label>
              </div>
            </div>

            <!-- Sección: Ofertas Especiales -->
            <div class="mb-3 text-center col-12">
              <p class="m-0 align-middle font-weight-bold d-inline-block pe-2">
                <i class="fas fa-star"></i> Ofertas Especiales:
              </p>
              <div class="ml-2 form-check d-inline-block">
                <input type="checkbox" name="orden_oferta" value="1" id="orden_oferta" class="form-check-input" @guest
                  disabled @endguest>
                <label class="form-check-label" for="orden_oferta">Mostrar primero productos en
                  oferta</label>
              </div>
            </div>

          </div>

          <!-- Botón de Envío -->
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Aplicar Ordenación</button>
          </div>
        </form>

      </div>
    </div>
    <!--end Collapse ordenaciones  -->

    <!-- Collapse categorias  -->
    <div class="collapse" id="categoriasCollapse">
      <div class="p-3 card">
        <x-categorias :categorias="$categorias" />

      </div>
    </div>
    <!--end Collapse categorias  -->

    <div class="p-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
      @if($articulos->isNotEmpty())
      @foreach($articulos as $articulo)

      <!-- DISEÑO MÓVIL REDISEÑADO -->
      <div class="col-12 d-block d-md-none">
        <div class="card border-0 shadow-sm mb-3 position-relative" style="border-radius: 12px;">
          <!-- Corazón de favoritos -->
          @if(in_array($articulo->artcod, $favoritos))
          <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
            class="position-absolute top-0 end-0 m-3 cursor-pointer bi bi-suit-heart-fill text-danger heartIcon"
            style="z-index: 5; font-size: 1.2rem;"></i>
          @else
          <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
            class="position-absolute top-0 end-0 m-3 cursor-pointer bi bi-suit-heart text-muted heartIcon"
            style="z-index: 5; font-size: 1.2rem;"></i>
          @endif

          <div class="card-body p-3">
            <!-- Imagen y contenido principal -->
            <div class="row g-3">
              <!-- Imagen -->
              <div class="col-5 d-flex align-items-center">
                <div class="position-relative bg-light rounded-3 overflow-hidden w-100" style="aspect-ratio: 1/1; max-width: 130px; min-width: 90px;">
                  <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block w-100 h-100">
                    @if($articulo->imagenes->isNotEmpty())
                    <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                      class="w-100 h-100 object-fit-cover" alt="{{ $articulo->artnom }}" title="{{ $articulo->artnom }}"
                      style="border-radius: 8px; object-fit: cover;"
                      onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                    @else
                    <img src="{{ asset('images/articulos/noimage.jpg') }}" class="w-100 h-100 object-fit-cover"
                      alt="no hay imagen" title="No hay imagen" style="border-radius: 8px; object-fit: cover;">
                    @endif
                  </a>
                </div>
              </div>

              <!-- Información del producto -->
              <div class="col-7">
                <div class="h-100 d-flex flex-column">
                  <!-- Título -->
                  <div class="d-flex align-items-start justify-content-between" style="gap: 0.5rem;">
                    <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="text-decoration-none flex-grow-1" style="min-width:0;">
                      <h6 class="fw-bold text-primary mb-1" style="font-size: 0.95rem; line-height: 1.2; word-break: break-word; white-space: normal;">
                        {{ Str::limit($articulo->artnom, 50) }}
                      </h6>
                    </a>
                    <!-- Espacio para el corazón, ya está en la esquina, solo reservamos espacio -->
                    <span style="width: 28px; min-width: 28px; flex-shrink:0;"></span>
                  </div>

                  <!-- Descripción -->
                  @isset($articulo->artobs)
                  <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.3;">
                    {{ Str::limit($articulo->artobs, 80) }}
                  </p>
                  @endisset

                  <!-- Estado y acciones -->
                  <div class="d-flex align-items-center gap-2 mb-2">
                    @if($articulo->artstocon == 1 || $articulo->artstock > 1)
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.7rem;">
                      <i class="mdi mdi-check-circle me-1"></i>Disponible
                    </span>
                    @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.7rem;">
                      <i class="mdi mdi-close-circle me-1"></i>Agotado
                    </span>
                    @endif

                    <div class="d-flex gap-1">
                      <a class="text-muted" href="{{ asset('images/files/' . $articulo->artdocaso) }}" title="Ficha técnica">
                        <i class="uil-clipboard-alt" style="font-size: 1rem;"></i>
                      </a>
                      <a class="text-primary" href="{{route('info', ['artcod' => $articulo->artcod])}}" title="Más información">
                        <i class="mdi mdi-information-outline" style="font-size: 1rem;"></i>
                      </a>
                    </div>
                  </div>

                  <!-- Precio -->
                  <div class="mt-auto">
                    @if ($articulo->precioOferta)
                    <div class="d-flex align-items-center gap-2">
                      <span class="badge bg-danger text-white" style="font-size: 0.65rem;">
                        -@if($articulo->precioDescuento){{$articulo->precioDescuento}}@endif%
                      </span>
                      <div>
                        <div class="fw-bold text-danger" style="font-size: 1rem;">
                          {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioOferta) }}€
                        </div>
                        <div class="text-decoration-line-through text-muted" style="font-size: 0.8rem;">
                          {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }}€
                        </div>
                      </div>
                    </div>
                    @elseif(isset($articulo->precioTarifa))
                    <div class="fw-bold text-dark" style="font-size: 1rem;">
                      {{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }}€
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <!-- Formulario de compra -->
            <div class="border-top pt-3 mt-3">
              <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}">
                @csrf
                @if($articulo->cajas->isNotEmpty() && config('app.caja') == 'si')
                <div class="row g-2 mb-3">
                  <div class="col-4">
                    <label class="form-label small text-muted mb-1">Cantidad</label>
                    <input type="number" class="form-control form-control-sm text-center" name="quantity" min="1" value="1">
                  </div>
                  <div class="col-8">
                    <label class="form-label small text-muted mb-1">Tipo</label>
                    <select class="form-select form-select-sm" name="input-tipo">
                      @foreach($articulo->cajas as $index => $caja)
                      <option value="{{ $caja->cajcod }}" @if($caja->cajdef == 1) selected @endif>
                        @if($caja->cajreldir > 0){{ $caja->cajreldir }} {{ $articulo->promedcod }} @endif
                        @if($caja->cajcod == "0003")(Pieza)
                        @elseif($caja->cajcod == "0002")(Media)
                        @else(Caja)
                        @endif
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif

                <button type="submit" class="btn btn-primary w-100"
                  style="border-radius: 8px; font-weight: 600;"
                  onclick="$('#alertaStock').toast('show')">
                  <i class="mdi mdi-cart-plus me-2"></i>Añadir al carrito
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- DISEÑO ORIGINAL PARA PANTALLAS GRANDES -->
      <div class="col d-none d-md-block">
        <div class="border shadow-lg card h-100 border-primary rounded-3 position-relative desktop-product-card">
          <!-- Ícono de la corazon -->
          @if(in_array($articulo->artcod, $favoritos))
          <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
            class="top-0 m-2 cursor-pointer bi bi-suit-heart-fill red-heart position-absolute end-0 heartIcon desktop-heart-icon"></i>
          @else
          <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
            class="top-0 m-2 cursor-pointer bi bi-suit-heart position-absolute end-0 heartIcon desktop-heart-icon"></i>
          @endif

          <figure class="m-0 overflow-hidden bg-white d-flex align-items-center justify-content-center desktop-product-image">
            <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block">
              @if($articulo->imagenes->isNotEmpty())
              <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                class="h-auto d-block w-100" alt="{{ $articulo->artnom }}" title="{{ $articulo->artnom }}"
                onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
              @else
              <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100" alt="no hay imagen"
                title="No hay imagen">
              @endif
            </a>
          </figure>

          <div class="pb-0 bg-white card-body desktop-card-body">
            <a href="{{route('info', ['artcod' => $articulo->artcod])}}">
              <h5 class="m-0 card-title text-primary desktop-product-title">{{ $articulo->artnom }}</h5>
              @isset($articulo->artobs)<p class="card-text l3truncate desktop-product-description">{{$articulo->artobs}}</p>@endisset
            </a>
          </div>

          <div class="pt-0 card-footer desktop-card-footer">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}" data-toggle="fullscreen"
                    title="Stock disponible o no">
                    @if($articulo->artstocon == 1 || $articulo->artstock > 1)
                    <i class="mdi mdi-archive-check desktop-icon text-success"></i>
                    @else
                    <i class="mdi mdi-archive-cancel desktop-icon text-danger"></i>
                    @endif
                  </a>
                  <a class="pe-2" href="{{ asset('images/files/' . $articulo->artdocaso) }}" data-toggle="fullscreen"
                    title="Ficha técnica">
                    <i class="uil-clipboard-alt desktop-icon"></i>
                  </a>
                  <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}" data-toggle="fullscreen"
                    title="Información">
                    <i class="mdi mdi-information-outline desktop-icon"></i>
                  </a>
                </div>
                <div class="text-end">
                  @if ($articulo->precioOferta)
                  <h5>
                    <span class="badge badge-danger-lighten desktop-badge">
                      OFERTA
                      @if($articulo->precioDescuento)
                      {{$articulo->precioDescuento}}%
                      @endif
                    </span>
                  </h5>
                  <span class="text-danger fw-bolder desktop-price-offer">
                    {{
                    \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioOferta)
                    }}
                    €
                  </span>
                  <span class="text-decoration-line-through desktop-price-original">
                    {{
                    \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa)
                    }}
                    €
                  </span>
                  @elseif(isset($articulo->precioTarifa))
                  <span class="desktop-price-normal">
                    {{
                    \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa)
                    }}
                    €</span>
                  @else
                  <span class="desktop-price-normal"></span>
                  @endif
                </div>
              </li>
              <li class="list-group-item product-card">
                <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}">
                  @csrf
                  <div class="row">
                    <div class="col">
                      @if($articulo->cajas->isNotEmpty() && config('app.caja') == 'si')
                      <div class="row">
                        <div class="quantity-input col">
                          <input type="number" class="quantity form-control desktop-input" name="quantity" min="1" value="1">
                        </div>
                        <div class="col-auto">
                          @foreach($articulo->cajas as $index => $caja)
                          <div class="form-check">
                            <input class="form-check-input desktop-radio" type="radio" data-id="$caja->cajartcod"
                              value="{{ $caja->cajcod }}" name="input-tipo" id="caja{{ $index }}" @if($caja->cajdef ==
                            1)
                            checked
                            @endif
                            >
                            <label class="form-check-label desktop-label" for="caja{{ $index }}">
                              @if($caja->cajreldir > 0)
                              {{ $caja->cajreldir }} {{ $articulo->promedcod }}
                              @endif
                              @if($caja->cajcod == "0003")
                              (Pieza)
                              @elseif($caja->cajcod == "0002")
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
                      <button type="submit" class="btn btn-primary ms-2 col desktop-btn"
                        onclick="$('#alertaStock').toast('show')"><i class="mdi mdi-cart me-1"></i> Añadir</button>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
      @endforeach

      @else
      <div class="container text-center alert alert-primary" role="alert">
        <i class="align-middle ri-information-line me-1 font-22"></i>
        <strong>Actualmente no disponemos de artículos en esta categoría</strong>
      </div>

      @endif
    </div>

    <!-- Paginación responsive -->
    <div class="d-flex justify-content-center mt-4">
      <div class="d-block d-md-none">
        <!-- Paginación móvil simplificada -->
        <div class="d-flex align-items-center gap-2">
          @if($articulos->onFirstPage())
          <span class="btn btn-outline-secondary btn-sm disabled">
            <i class="bi bi-chevron-left"></i>
          </span>
          @else
          <a href="{{ $articulos->previousPageUrl() }}" class="btn btn-primary btn-sm">
            <i class="bi bi-chevron-left"></i>
          </a>
          @endif

          <span class="px-3 py-1 bg-light rounded text-center small fw-bold">
            {{ $articulos->currentPage() }} de {{ $articulos->lastPage() }}
          </span>

          @if($articulos->hasMorePages())
          <a href="{{ $articulos->nextPageUrl() }}" class="btn btn-primary btn-sm">
            <i class="bi bi-chevron-right"></i>
          </a>
          @else
          <span class="btn btn-outline-secondary btn-sm disabled">
            <i class="bi bi-chevron-right"></i>
          </span>
          @endif
        </div>

        <div class="text-center mt-2">
          <small class="text-muted">
            Mostrando {{ $articulos->firstItem() ?? 0 }} - {{ $articulos->lastItem() ?? 0 }}
            de {{ $articulos->total() }} productos
          </small>
        </div>
      </div>

      <!-- Paginación desktop original -->
      <div class="d-none d-md-block">
        {{ $articulos->links('vendor.pagination.bootstrap-5') }}
      </div>
    </div>
  </div>
</section>

<!-- FIN CARDS DE PRODUCTOS -->
@endsection

@push('scripts')
<script src="{{ asset('js/checkbox.js') }}"></script>
<script src="{{ asset('js/scrollbar.js') }}"></script>
<script src="{{ asset('js/Ajax/favorites.js') }}"></script>
@endpush