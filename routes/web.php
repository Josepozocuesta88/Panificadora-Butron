<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DbController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\OfertaCController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PuntosController;
use App\Http\Controllers\RecomendadosController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserLogController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/welcome', [CategoryController::class, 'index'])->name('welcome');
Route::view('/', 'commingSon')->name('commingSon');

// método que registra todas las rutas necesarias para las funciones de autenticación
Auth::routes();

Route::middleware(['auth'])->group(function () {
  // home 
  Route::get('/home', [OfertaCController::class, 'index'])->name('home');

  // dashboard (AJAX)
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Mi cuenta
  Route::view('/myaccount', 'pages.cuenta.myaccount')->name('myaccount');
  Route::put('/myaccount', [MyaccountController::class, 'update'])->name('myaccount.update');

  // cambiar de usuario (modo administrador)
  Route::view('/accounts', 'pages.cuenta.accounts')->name('accounts');
  Route::get('/account-change', [AccountsController::class, 'index'])->name('account.change');
  Route::get('/account-login/{id}', [AccountsController::class, 'impersonate'])->name('account.login');
  Route::get('/account-logout', [AccountsController::class, 'stopImpersonate'])->name('account.logout');

  // fichero logs usuario (modo administrador)
  Route::get('/download-file', [UserLogController::class, 'downloadFile'])->name('userlog.downloadFile');

  // reporte de errores por usuarios
  Route::view('/support', 'pages.cuenta.support.form-report')->name('form-report');
  Route::post('/support/form', [SupportController::class, 'reportarError'])->name('reportar.error');

  // productos y categorías
  Route::get('/categorias/{catcod}', [ArticuloController::class, 'showByCategory'])->name('categories');

  // buscar productos
  Route::get('/articles/search/', [ArticuloController::class, 'search'])->name('search');

  // buscar categorías
  Route::get('/articles/search/category', [CategoryController::class, 'searchCategory'])->name('search.category');

  // categorías
  Route::get('/categorias', [CategoryController::class, 'show'])->name('show.categorias');

  // información de cada producto (article-details)
  Route::get('/articles/{artcod}', [ArticuloController::class, 'info'])->name('info');

  // recomendados (AJAX)
  Route::get('/recomendados', [RecomendadosController::class, 'getRecomendados'])->name('recomendados');

  // ordenaciones de productos
  Route::get('/productos/categoria/{catnom?}', [ArticuloController::class, 'filters'])->name('filtrarArticulos');

  // favoritos mostrar
  Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.show');

  // favoritos añadir (AJAX)
  Route::post('/favoritos/store', [FavoritoController::class, 'store'])->name('favoritos.store');

  // favoritos borrar (AJAX)
  Route::post('/favoritos/delete', [FavoritoController::class, 'delete'])->name('favoritos.delete');

  // History (AJAX)
  Route::get('/history', [HistoryController::class, 'getHistory'])->name('history');
  Route::get('/historyAgrupado', [HistoryController::class, 'getHistoryGroup'])->name('historyAgrupado');

  Route::post('/articles/{artcod}', [CartController::class, 'addToCart'])->name('cart.add');

  // ajax (los 4)
  Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
  Route::post('/cart/{artcod}', [CartController::class, 'removeItem'])->name('cart.removeItem');
  Route::get('/selectTipo/{artcod}', [CartController::class, 'selectTipo'])->name('cart.selectTipo');
  Route::post('/update-select/{cartcod}/{cartcant}/{type}', [CartController::class, 'changeSelect']);

  Route::post('/update-cart/{cartcod}', [CartController::class, 'updateCart'])->name('cart.updateCart');

  // ModalCart (AJAX)
  Route::get('/modalCart', [CartController::class, 'showModalCart'])->name('cart.modalCart');

  // Generar pedido
  Route::post('/order', [PedidoController::class, 'makeOrder'])->name('makeOrder');

  //redirige al
  Route::get('/order/{result}', [PedidoController::class, 'orderResult'])->name('orderResult');

  // Ver pedidos
  Route::get('/pedidos/pedido/{id?}', [PedidoController::class, 'mostrarPedido'])->name('pedido.mostrarPedido');
  Route::get('/pedidos', [PedidoController::class, 'mostrarTodos'])->name('pedido.mostrarTodos');

  // guardar comentario
  Route::post('/guardar-comentario', [PedidoController::class, 'guardarComentario']);

  // ruta para descargar documentos
  Route::get('/documentos/download/{filename}', [DocumentoController::class, 'descargarDocumento'])->name('descargar.documento');

  // ruta para obtener los documentos (AJAX DATATABLES)
  Route::get('/documentos/{doctip?}', [DocumentoController::class, 'getDocumentos'])->name('get.documentos');

  // resumen 347
  Route::get('/documentos/resumen/347', [DocumentoController::class, 'getDocumentos347'])->name('documentos.347');

  // ver documento
  Route::get('/documentos/ver/{filename}', [DocumentoController::class, 'verDocumento'])
    ->where('filename', '.*')
    ->name('documentos.ver');

  //descargar archivos temporales
  Route::get('local/temp/{path}', [DocumentoController::class, 'verArchivoTemporal'])->name('local.temp');

  // pagar factura
  Route::post('/documentos/payment/', [DocumentoController::class, 'payment'])->name('pasarela-pago');
  Route::get('/documentos/payment/success', [DocumentoController::class, 'paymentSuccess'])->name('pagoSuccess');
  Route::get('/documentos/payment/error', [DocumentoController::class, 'paymentError'])->name('pagoError');
  Route::post('/documentos/payment/update', [DocumentoController::class, 'documentUpdate'])->name('documentUpdate');

  Route::get('/puntosderegalo', [PuntosController::class, 'allPoints'])->name('all.points');

  // ajax (DataTables)
  Route::get('/historicoPuntos', [PuntosController::class, 'getPoints'])->name('get.points');
  // Route::get('/historicoPuntosAgrupado', [PuntosController::class, 'getPointsGroup'])->name('get.pointsGroup');

  // contacto
  Route::view('/contacto', 'pages.contacto.formulario')->name('contacto.formulario');
  Route::post('/contacto/email', [SupportController::class, 'contactoEmail'])->name('contacto.email');

  // política de privacidad
  Route::view('/politica-de-privacidad', 'pages.legal.privacidad')->name('privacidad');

  // política de cookies
  Route::view('/politica-de-cookies', 'pages.legal.cookies')->name('cookies');

  // política de privacidad redes sociales
  Route::view('/politica-de-redes', 'pages.legal.redes')->name('redes');

  // política de privacidad
  Route::view('/politica-de-privacidad', 'pages.legal.privacidad')->name('privacidad');

  // aviso legal
  Route::view('/aviso-legal', 'pages.legal.aviso')->name('avisoLegal');

  Route::get('/corporate-form', function () {
    return view('pages.corporate_images.corporateForm');
  })->name('corporate-form');

  Route::post('/updateLogo', [LogoController::class, 'updateLogo'])->name('updateLogo');

  Route::get('/clear-database', [DbController::class, 'truncateAllTables'])->name('clear.database');
});

Route::get('/categorias/preview/{catcod}', [ArticuloController::class, 'showByCategoryLogout'])->name('categoriesNoLogin');
Route::get('/articles/search/preview', [ArticuloController::class, 'searchNoLogin'])->name('searchNoLogin');
Route::get('/productsnologin', [ArticuloController::class, 'productsnoLogin'])->name('productsnologin');

// TEMPORALES
Route::get('/clear-all-caches', function () {
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('route:clear');
  Artisan::call('view:clear');
  Artisan::call('optimize');
  return response()->json(['message' => 'All caches cleared']);
});
