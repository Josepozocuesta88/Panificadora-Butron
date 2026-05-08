@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary: #594b42;
    --primary-dark: #473b32;
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
    color: #594b42;
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
    color: #594b42;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .action-btn:hover {
    background: #594b42;
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
    color: #594b42;
  }

  .price-original {
    font-size: 0.9rem;
    color: #4b5563;
    text-decoration: line-through;
    margin-left: 0.5rem;
  }

  .add-to-cart {
    width: 100%;
    background: #594b42;
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
    background: #473b32;
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
    color: #594b42;
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
    background: linear-gradient(90deg, #594b42, #473b32);
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
    color: #594b42;
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
    color: #594b42;
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
    border-color: #594b42;
    box-shadow: 0 0 0 2px rgba(89, 75, 66, 0.1);
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
    color: #594b42;
    border: 1px solid #594b42;
  }

  .btn-detail:hover {
    background: #594b42;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(89, 75, 66, 0.3);
  }

  .btn-add {
    background: #594b42;
    color: white;
    border: 1px solid #594b42;
  }

  .btn-add:hover {
    background: #473b32;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(89, 75, 66, 0.4);
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

  /* ===== NOVEDADES SECTION STYLES ===== */
  .novedades-section {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 4rem 0;
    margin-top: 1rem;
  }

  /* Header Styles */
  .novedades-header {
    margin-bottom: 3rem;
  }

  .novedades-title {
    font-size: 2.5rem;
    font-weight: 300;
    color: #1e293b;
    margin-bottom: 0.75rem;
    letter-spacing: -0.5px;
    position: relative;
  }

  .novedades-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 300;
    margin: 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
  }

  .title-divider {
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #594b42, #473b32);
    margin: 1.5rem auto 0;
    border-radius: 2px;
  }

  /* Grid Container */
  .novedades-grid {
    max-width: 1600px;
    margin: 0 auto;
  }

  /* Product Cards */
  .novedad-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(89, 75, 66, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 2px solid transparent;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    backdrop-filter: blur(10px);
  }

  .novedad-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(89, 75, 66, 0.02) 0%, rgba(71, 59, 50, 0.02) 100%);
    border-radius: 18px;
    z-index: -1;
  }

  .novedad-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 25px 60px rgba(89, 75, 66, 0.15), 0 8px 32px rgba(0, 0, 0, 0.08);
    border-color: rgba(89, 75, 66, 0.2);
  }

  .novedad-card:hover::before {
    background: linear-gradient(135deg, rgba(89, 75, 66, 0.05) 0%, rgba(71, 59, 50, 0.05) 100%);
  }

  /* Image Container */
  .novedad-image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px 18px 0 0;
  }

  .novedad-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    filter: brightness(1.02) contrast(1.05);
  }

  .novedad-card:hover .novedad-image {
    transform: scale(1.08);
    filter: brightness(1.05) contrast(1.08) saturate(1.1);
  }

  /* Badges */
  .season-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background: linear-gradient(135deg, #594b42 0%, #473b32 100%);
    color: white;
    padding: 8px 14px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 16px rgba(89, 75, 66, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 10;
  }

  .offer-badge-novedad {
    position: absolute;
    top: 16px;
    right: 16px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 8px 14px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 800;
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 10;
    animation: pulse-badge 2s infinite;
  }

  @keyframes pulse-badge {

    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.05);
    }
  }

  /* Content */
  .novedad-content {
    padding: 1.5rem 1.25rem 1.25rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: white;
    position: relative;
  }

  .novedad-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(89, 75, 66, 0.1) 50%, transparent 100%);
  }

  .novedad-title {
    margin: 0 0 0.75rem 0;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.35;
    height: 2.7rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    color: #1e293b;
  }

  .novedad-title a {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #1e293b 0%, #594b42 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .novedad-title a:hover {
    background: linear-gradient(135deg, #594b42 0%, #473b32 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .novedad-description {
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.5;
    margin-bottom: 1rem;
    height: 3rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    font-weight: 400;
  }

  /* Stock Info */
  .stock-info-novedad {
    margin-bottom: 1rem;
  }

  .stock-available-novedad {
    color: #594b42;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(89, 75, 66, 0.1);
    border-radius: 20px;
    border: 1px solid rgba(89, 75, 66, 0.2);
  }

  .stock-unavailable-novedad {
    color: #ef4444;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 20px;
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  /* Price Section */
  .price-section-novedad {
    margin-bottom: 1.25rem;
    min-height: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .price-offer-novedad {
    font-size: 1.25rem;
    font-weight: 800;
    color: #594b42;
    margin-bottom: 4px;
    text-shadow: 0 1px 2px rgba(89, 75, 66, 0.1);
  }

  .price-original-novedad {
    font-size: 0.9rem;
    color: #94a3b8;
    text-decoration: line-through;
    font-weight: 500;
  }

  .price-normal-novedad {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    text-shadow: 0 1px 2px rgba(30, 41, 59, 0.1);
  }

  /* Action Buttons */
  .action-buttons-novedad {
    display: flex;
    gap: 8px;
    margin-top: auto;
  }

  .btn-detail-novedad,
  .btn-doc-novedad,
  .btn-add-novedad {
    flex: 1;
    height: 42px;
    border: none;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .btn-detail-novedad::before,
  .btn-doc-novedad::before,
  .btn-add-novedad::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .btn-detail-novedad:hover::before,
  .btn-doc-novedad:hover::before,
  .btn-add-novedad:hover::before {
    left: 100%;
  }

  .btn-detail-novedad {
    background: linear-gradient(135deg, white 0%, #f8fafc 100%);
    color: #594b42;
    border: 2px solid #594b42;
    box-shadow: 0 2px 8px rgba(89, 75, 66, 0.1);
  }

  .btn-detail-novedad:hover {
    background: linear-gradient(135deg, #594b42 0%, #473b32 100%);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(89, 75, 66, 0.3);
  }

  .btn-doc-novedad {
    background: linear-gradient(135deg, white 0%, #f8fafc 100%);
    color: #1e293b;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(30, 41, 59, 0.1);
  }

  .btn-doc-novedad:hover {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(30, 41, 59, 0.3);
    border-color: #1e293b;
  }

  .btn-add-novedad {
    background: linear-gradient(135deg, #594b42 0%, #473b32 100%);
    color: white;
    border: 2px solid #594b42;
    box-shadow: 0 4px 16px rgba(89, 75, 66, 0.2);
    width: 100%;
  }

  .btn-add-novedad:hover:not(:disabled) {
    background: linear-gradient(135deg, #473b32 0%, #3a2f28 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(89, 75, 66, 0.4);
  }

  .btn-add-novedad:disabled {
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    color: #94a3b8;
    border-color: #e2e8f0;
    cursor: not-allowed;
    box-shadow: none;
  }

  .add-form-novedad {
    flex: 1;
    margin: 0;
  }

  /* Responsive Design */
  @media (min-width: 1400px) {
    .novedades-grid {
      max-width: 1800px;
    }

    .container-fluid {
      padding-left: 2rem !important;
      padding-right: 2rem !important;
    }
  }

  @media (max-width: 1199px) {
    .novedades-grid .col-lg-2 {
      flex: 0 0 25%;
      max-width: 25%;
    }
  }

  @media (max-width: 991px) {
    .novedades-section {
      padding: 3rem 0;
    }

    .novedades-title {
      font-size: 2rem;
    }

    .novedad-image-container {
      height: 200px;
    }

    .novedad-content {
      padding: 1.25rem 1rem 1rem;
    }

    .novedad-card {
      border-radius: 16px;
    }
  }

  @media (max-width: 767px) {
    .novedades-section {
      padding: 2rem 0;
    }

    .novedades-title {
      font-size: 1.6rem;
      margin-bottom: 1.5rem;
    }

    .novedades-subtitle {
      font-size: 0.95rem;
      margin-bottom: 2rem;
    }

    /* Mejoras para grid móvil de novedades */
    .novedades-grid .col-6 {
      flex: 0 0 50%;
      max-width: 50%;
    }

    .novedad-card {
      border-radius: 12px;
      margin-bottom: 1rem;
    }

    .novedad-image-container {
      height: 160px;
    }

    .novedad-content {
      padding: 1rem 0.75rem 0.75rem;
    }

    .novedad-name {
      font-size: 0.85rem;
      line-height: 1.3;
      margin-bottom: 0.75rem;
    }

    .action-buttons-novedad {
      gap: 4px;
      margin-top: 0.75rem;
    }

    .btn-detail-novedad,
    .btn-doc-novedad,
    .btn-add-novedad {
      height: 32px;
      width: 32px;
      font-size: 11px;
      border-radius: 8px;
    }

    .price-offer-novedad,
    .price-normal-novedad {
      font-size: 1rem;
    }

    .price-original-novedad {
      font-size: 0.8rem;
    }
  }

  @media (max-width: 575px) {
    .container-fluid {
      padding-left: 0.75rem !important;
      padding-right: 0.75rem !important;
    }

    .novedades-section {
      padding: 1.5rem 0;
    }

    .novedades-title {
      font-size: 1.4rem;
      margin-bottom: 1rem;
    }

    .novedades-subtitle {
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }

    /* Grid para móviles pequeños - 2 columnas más compactas */
    .novedades-grid .col-6 {
      flex: 0 0 50%;
      max-width: 50%;
      padding: 0 0.25rem;
    }

    .novedad-card {
      border-radius: 10px;
      margin-bottom: 0.75rem;
    }

    .novedad-content {
      padding: 0.75rem 0.5rem 0.5rem;
    }

    .novedad-name {
      font-size: 0.75rem;
      line-height: 1.2;
      margin-bottom: 0.5rem;
      height: 2rem;
    }

    .novedad-description {
      display: none;
      /* Ocultar descripción en móviles pequeños */
    }

    .novedad-image-container {
      height: 140px;
    }

    .action-buttons-novedad {
      gap: 2px;
      margin-top: 0.5rem;
    }

    .btn-detail-novedad,
    .btn-doc-novedad,
    .btn-add-novedad {
      height: 28px;
      width: 28px;
      font-size: 12px;
      border-radius: 8px;
      width: 100%;
    }

    .price-offer-novedad,
    .price-normal-novedad {
      font-size: 1rem;
    }
  }

  @media (max-width: 374px) {

    /* Estilos para móviles extra pequeños - Novedades */
    .novedades-title {
      font-size: 1.2rem;
    }

    .novedades-grid .col-6 {
      padding: 0 0.125rem;
    }

    .novedad-card {
      margin-bottom: 0.5rem;
    }

    .novedad-image-container {
      height: 120px;
    }

    .novedad-content {
      padding: 0.5rem 0.25rem 0.25rem;
    }

    .novedad-name {
      font-size: 0.7rem;
      height: 1.8rem;
      margin-bottom: 0.25rem;
    }

    .btn-detail-novedad,
    .btn-doc-novedad,
    .btn-add-novedad {
      height: 26px;
      width: 26px;
      font-size: 10px;
    }

    .price-offer-novedad,
    .price-normal-novedad {
      font-size: 0.9rem;
    }

    .price-original-novedad {
      font-size: 0.7rem;
    }

    /* Estilos para móviles extra pequeños - Categorías */
    .categorias-title {
      font-size: 1.3rem;
    }

    .categoria-item {
      height: 220px;
    }

    .categoria-content {
      padding: 0.75rem;
    }

    .categoria-icon {
      font-size: 35px;
      margin-bottom: 0.5rem;
    }

    .categoria-name {
      font-size: 0.85rem;
      margin-bottom: 0.5rem;
    }

    .categoria-btn {
      padding: 5px 10px;
      font-size: 0.65rem;
    }
  }

  /* ===== CATEGORÍAS SECTION STYLES ===== */
  .categorias-section {
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
    padding: 5rem 0;
    margin-top: 1rem;
    position: relative;
    min-height: 80vh;
  }

  .categorias-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(circle at 20% 80%, rgba(89, 75, 66, 0.05) 0%, transparent 60%),
      radial-gradient(circle at 80% 20%, rgba(89, 75, 66, 0.05) 0%, transparent 60%),
      radial-gradient(circle at 50% 50%, rgba(89, 75, 66, 0.02) 0%, transparent 80%);
    pointer-events: none;
  }

  /* Header Styles */
  .categorias-header {
    margin-bottom: 3rem;
    position: relative;
    z-index: 2;
  }

  .categorias-title {
    font-size: 2.5rem;
    font-weight: 300;
    color: #1e293b;
    margin-bottom: 0.75rem;
    letter-spacing: -0.5px;
    position: relative;
  }

  .categorias-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 300;
    margin: 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
  }

  .title-divider-cat {
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #594b42, #473b32);
    margin: 1.5rem auto 0;
    border-radius: 2px;
  }

  /* Grid Container */
  .categorias-grid {
    max-width: 1800px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }

  /* Categoria Item - Image Style */
  .categoria-item {
    position: relative;
    display: block;
    border-radius: 20px;
    overflow: hidden;
    height: 380px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    box-shadow: 0 8px 32px rgba(89, 75, 66, 0.15);
  }

  .categoria-item:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 60px rgba(89, 75, 66, 0.25);
    text-decoration: none;
  }

  .categoria-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: transform 0.4s ease;
  }

  .categoria-item:hover .categoria-background {
    transform: scale(1.1);
  }

  .categoria-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(89, 75, 66, 0.45) 0%, rgba(71, 59, 50, 0.55) 100%);
    transition: all 0.4s ease;
  }

  .categoria-item:hover .categoria-overlay {
    background: linear-gradient(135deg, rgba(89, 75, 66, 0.65) 0%, rgba(71, 59, 50, 0.75) 100%);
  }

  .categoria-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem;
    z-index: 2;
  }

  .categoria-icon {
    color: white;
    margin-bottom: 1.5rem;
    transition: all 0.4s ease;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.5));
    font-size: 80px;
  }

  .categoria-item:hover .categoria-icon {
    transform: rotate(360deg) scale(1.15);
  }

  .categoria-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    line-height: 1.2;
  }

  .categoria-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.4s ease;
    backdrop-filter: blur(10px);
    display: inline-flex;
    align-items: center;
  }

  .categoria-item:hover .categoria-btn {
    background: white;
    color: #594b42;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
  }

  /* Call to Action Section */
  .categorias-cta {
    position: relative;
    z-index: 2;
  }

  .cta-content {
    background: linear-gradient(135deg, white 0%, #fafafa 100%);
    padding: 4rem 3rem;
    border-radius: 32px;
    box-shadow: 0 20px 60px rgba(89, 75, 66, 0.15), 0 8px 24px rgba(0, 0, 0, 0.08);
    border: 3px solid rgba(89, 75, 66, 0.15);
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
    transform: perspective(1000px) rotateX(2deg);
    transition: all 0.4s ease;
  }

  .cta-content:hover {
    transform: perspective(1000px) rotateX(0deg) translateY(-8px);
    box-shadow: 0 32px 80px rgba(89, 75, 66, 0.20), 0 12px 40px rgba(0, 0, 0, 0.12);
    border-color: rgba(89, 75, 66, 0.25);
  }

  .cta-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(89, 75, 66, 0.02) 0%, rgba(71, 59, 50, 0.02) 100%);
    z-index: -1;
  }

  .cta-title {
    font-size: 2.25rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #1e293b 0%, #594b42 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    line-height: 1.2;
  }

  .cta-description {
    font-size: 1.25rem;
    color: #64748b;
    margin-bottom: 2.5rem;
    line-height: 1.6;
    font-weight: 400;
  }

  .cta-button {
    display: inline-flex;
    align-items: center;
    gap: 16px;
    padding: 20px 40px;
    background: linear-gradient(135deg, #594b42 0%, #473b32 100%);
    color: white;
    text-decoration: none;
    border-radius: 60px;
    font-weight: 800;
    font-size: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 12px 48px rgba(89, 75, 66, 0.3);
    position: relative;
    overflow: hidden;
    border: 3px solid rgba(255, 255, 255, 0.2);
  }

  .cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
  }

  .cta-button:hover::before {
    left: 100%;
  }

  .cta-button:hover {
    background: linear-gradient(135deg, #473b32 0%, #3a2f28 100%);
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 24px 72px rgba(89, 75, 66, 0.5);
    color: white;
    border-color: rgba(255, 255, 255, 0.4);
  }

  .cta-button i {
    font-size: 1.3rem;
    transition: all 0.3s ease;
  }

  .cta-button:hover i {
    transform: scale(1.3) rotate(15deg);
  }

  /* Responsive Design */
  @media (min-width: 1400px) {
    .categorias-grid {
      max-width: 1800px;
    }
  }

  @media (max-width: 1199px) {
    .categorias-grid .col-lg-3 {
      flex: 0 0 25%;
      max-width: 25%;
    }
  }

  @media (max-width: 991px) {
    .categorias-section {
      padding: 4rem 0;
    }

    .categorias-title {
      font-size: 2.2rem;
    }

    .categoria-item {
      height: 320px;
    }

    .categoria-icon {
      font-size: 70px;
    }

    .categoria-name {
      font-size: 1.3rem;
    }

    .categoria-btn {
      padding: 10px 18px;
      font-size: 0.85rem;
    }

    .cta-content {
      padding: 3rem 2rem;
    }

    .cta-title {
      font-size: 2rem;
    }

    .cta-description {
      font-size: 1.15rem;
    }

    .cta-button {
      padding: 18px 36px;
      font-size: 1.1rem;
    }
  }

  @media (max-width: 767px) {
    .categorias-section {
      padding: 2.5rem 0;
    }

    .categorias-title {
      font-size: 1.8rem;
      margin-bottom: 2rem;
    }

    .categorias-subtitle {
      font-size: 1rem;
      margin-bottom: 2.5rem;
    }

    /* Mejorar grid mobile - 2 columnas en móviles */
    .categorias-grid .col-6 {
      flex: 0 0 50%;
      max-width: 50%;
    }

    .categoria-item {
      height: 280px;
    }

    .categoria-icon {
      font-size: 50px;
      margin-bottom: 1rem;
    }

    .categoria-content {
      padding: 1.25rem;
    }

    .categoria-name {
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    .categoria-btn {
      padding: 8px 16px;
      font-size: 0.75rem;
    }

    .cta-content {
      padding: 2.5rem 1.5rem;
    }

    .cta-title {
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }

    .cta-description {
      font-size: 1rem;
      margin-bottom: 1.5rem;
    }

    .cta-button {
      padding: 14px 28px;
      font-size: 1rem;
    }
  }

  @media (max-width: 575px) {
    .container-fluid {
      padding-left: 0.75rem !important;
      padding-right: 0.75rem !important;
    }

    .categorias-section {
      padding: 2rem 0;
    }

    .categorias-title {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .categorias-subtitle {
      font-size: 0.9rem;
      margin-bottom: 2rem;
    }

    /* Una sola columna en móviles muy pequeños */
    .categorias-grid .col-6 {
      flex: 0 0 100%;
      max-width: 100%;
    }

    .categoria-item {
      height: 250px;
      margin-bottom: 1rem;
    }

    .categoria-content {
      padding: 1rem;
    }

    .categoria-icon {
      font-size: 40px;
      margin-bottom: 0.75rem;
    }

    .categoria-name {
      font-size: 0.95rem;
      margin-bottom: 0.75rem;
    }

    .categoria-btn {
      padding: 6px 12px;
      font-size: 0.7rem;
    }

    .cta-content {
      padding: 2rem 1rem;
      border-radius: 16px;
    }

    .cta-title {
      font-size: 1.5rem;
    }

    .cta-description {
      font-size: 0.95rem;
    }

    .cta-button {
      padding: 12px 20px;
      font-size: 0.95rem;
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

<!-- Sección de Categorías Mejorada -->
<div class="categorias-section py-1">
  <div class="container-fluid px-4">
    <!-- Título y Llamada a la Acción -->
    <div class="categorias-header text-center mb-5 mt-2">
      <h2 class="categorias-title">Nuestras Categorías</h2>
      <p class="categorias-subtitle">Explora toda nuestra variedad de productos artesanales</p>
      <div class="title-divider-cat"></div>
    </div>

    <!-- Grid de Categorías -->
    <div class="categorias-grid">
      <div class="row g-3 justify-content-center">
        @foreach($categorias as $category)
        <div class="col-6 col-md-4 col-lg-3">
          <a href="{{ route('categories', ['catcod' => $category->catcod]) }}" onclick="irAProductos()" class="categoria-item">
            <!-- Imagen de fondo -->
            <div class="categoria-background" style="background-image: url('{{ asset('images/categorias/' . $category->catima) }}');"></div>

            <!-- Overlay con gradiente -->
            <div class="categoria-overlay"></div>

            <!-- Contenido superpuesto -->
            <div class="categoria-content">
              <div class="categoria-icon">
                <i class="bi bi-basket2-fill"></i>
              </div>

              <h3 class="categoria-name">{{ $category->catnom }}</h3>

              <div class="categoria-btn">
                <span>Ver Productos</span>
                <i class="bi bi-arrow-right ms-2"></i>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</div>

<!-- Sección de Novedades Mejorada -->
<div class="novedades-section py-1">
  <div class="container-fluid px-4">
    <!-- Título Elegante -->
    <div class="novedades-header text-center mb-5">
      <h2 class="novedades-title">Novedades</h2>
      <p class="novedades-subtitle">Descubre nuestros productos más recientes</p>
      <div class="title-divider"></div>
    </div>

    <!-- Grid de Novedades -->
    <div class="novedades-grid">
      <div class="row g-3 justify-content-center">
        @foreach($novedades as $articulo)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
          <div class="novedad-card">
            <!-- Imagen del Producto -->
            <div class="novedad-image-container">
              <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}">
                @if($articulo->imagenes->isNotEmpty())
                <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                  alt="{{ $articulo->artnom }}"
                  class="novedad-image"
                  onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.png') }}';">
                @else
                <img src="{{ asset('images/articulos/noimage.png') }}"
                  alt="Sin imagen"
                  class="novedad-image">
                @endif
              </a>

              <!-- Badge de Temporada -->
              @if(isset($articulo->arttemporada) && $articulo->arttemporada === 1)
              <div class="season-badge">
                <i class="bi bi-clock"></i>
                <span>Temporada</span>
              </div>
              @endif

              <!-- Badge de Oferta -->
              @if ($articulo->precioOferta)
              <div class="offer-badge-novedad">
                @if ($articulo->precioDescuento)
                -{{ $articulo->precioDescuento }}%
                @else
                OFERTA
                @endif
              </div>
              @endif
            </div>

            <!-- Contenido de la Card -->
            <div class="novedad-content">
              <h6 class="novedad-title">
                <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}">
                  {{ $articulo->artnom }}
                </a>
              </h6>

              <p class="novedad-description">{{ Str::limit($articulo->artobs, 60) }}</p>

              <!-- Información de Stock -->
              <div class="stock-info-novedad">
                @if($articulo->artstocon == 1 || $articulo->artstock > 1)
                <span class="stock-available-novedad">
                  <i class="bi bi-check-circle-fill"></i> Disponible
                </span>
                @else
                <span class="stock-unavailable-novedad">
                  <i class="bi bi-x-circle-fill"></i> Sin stock
                </span>
                @endif
              </div>

              <!-- Precios -->
              <div class="price-section-novedad">
                @if ($articulo->precioOferta)
                <div class="price-offer-novedad">{{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioOferta) }} €</div>
                <div class="price-original-novedad">{{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }} €</div>
                @elseif(isset($articulo->precioTarifa))
                <div class="price-normal-novedad">{{ \App\Services\FormatoNumeroService::convertirADecimal($articulo->precioTarifa) }} €</div>
                @endif
              </div>

              <!-- Botones de Acción -->
              <div class="action-buttons-novedad">
                <a href="{{ route('info', ['artcod' => $articulo->artcod]) }}" class="btn-detail-novedad">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ asset('images/' . $articulo->artdocaso) }}" class="btn-doc-novedad" title="Ficha técnica">
                  <i class="bi bi-file-earmark-text"></i>
                </a>
                <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}" class="add-form-novedad">
                  @csrf
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" class="btn-add-novedad"
                    onclick="$('#alertaStock').toast('show')"
                    @if(isset($articulo->arttemporada) && $articulo->arttemporada === 1) disabled @endif>
                    <i class="bi bi-cart-plus"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>



<div class="pt-4 row">
  <div class="col-lg-12">
    <div class="nav nav-tabs text-dark ">
      <h3>Histórico de compras</h3>
    </div>
  </div>
</div>
<div class="pt-3 table-responsive">
  <table class="table table-centered w-100 dt-responsive nowrap" id="history-datatable">
    <thead class="table-light">
      <tr>
        <th>Código</th>
        <th>Producto</th>
        <th>Fecha Compra</th>
        <th>Precio</th>
        <th>Cantidad</th>
      </tr>
    </thead>
  </table>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/scrollbar.js') }}"></script>
<script src="{{ asset('js/Ajax/history.js') }}"></script>
<script>
  cargarRejilla();
</script>
@endpush