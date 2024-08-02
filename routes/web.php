<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfertaCController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\RecomendadosController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PuntosController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// index
Route::get('/', [CategoryController::class, 'index'])->name('welcome');

// método que registra todas las rutas necesarias para las funciones de autenticación
Auth::routes();


// home (pagina de inicio cuando te logeas)
Route::get('/home', [OfertaCController::class, 'index'])->name('home');

// dashboard (AJAX)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


// Mi cuenta
Route::middleware(['auth'])->group(function () {
    Route::view('/myaccount', 'pages.cuenta.myaccount')->name('myaccount')->middleware('auth');
    Route::put('/myaccount', [MyaccountController::class, 'update'])->name('myaccount.update');
});

// cambiar de usuario (modo administrador)
Route::middleware('auth')->group(function () {
    Route::view('/accounts', 'pages.cuenta.accounts')->name('accounts');
    Route::get('/account-change', [AccountsController::class, 'index'])->name('account.change');
    Route::get('/account-login/{id}', [AccountsController::class, 'impersonate'])->name('account.login');
    Route::get('/account-logout', [AccountsController::class, 'stopImpersonate'])->name('account.logout');
    // fichero logs usuario (modo administrador)
    Route::get('/download-file', [UserLogController::class, 'downloadFile'])->name('userlog.downloadFile');
});

// reporte de errores por usuarios
Route::view('/support', 'pages.cuenta.support.form-report')->name('form-report')->middleware('auth');
Route::post('/support/form', [SupportController::class, 'reportarError'])->name('reportar.error')->middleware('auth');


// ==============================================================
//   Todas las rutas relacionadas con: ARTICULOS
// ==============================================================
// productos y categorias
Route::get('/categorias/{catcod}', [ArticuloController::class, 'showByCategory'])->name('categories');

// buscar productos
Route::get('/articles/search/', [ArticuloController::class, 'search'])->name('search');

// buscar categorias
Route::get('/articles/search/category', [CategoryController::class, 'searchCategory'])->name('search.category');

// categorias
Route::get('/categorias', [CategoryController::class, 'show'])->name('show.categorias');

// informacion de cada producto (article-details)
Route::get('/articles/{artcod}', [ArticuloController::class, 'info'])->name('info');

// recomendados (AJAX)
Route::get('/recomendados', [RecomendadosController::class, 'getRecomendados'])->name('recomendados');

// ordenaciones de productos
Route::get('/productos/categoria/{catnom?}', [ArticuloController::class, 'filters'])->name('filtrarArticulos');

// ==============================================================
//   Todas las rutas relacionadas con: ARTICULOS FAVORITOS
// ==============================================================

// favoritos mostrar
Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.show')->middleware('auth');

// favoritos añadir (AJAX)
Route::post('/favoritos/store', [FavoritoController::class, 'store'])->name('favoritos.store')->middleware('auth');

// favoritos borrar (AJAX)
Route::post('/favoritos/delete', [FavoritoController::class, 'delete'])->name('favoritos.delete')->middleware('auth');

// ==============================================================
//   Todas las rutas relacionadas con: CARRITO Y PEDIDOS
// ==============================================================
// History (AJAX)
Route::get('/history', [HistoryController::class, 'getHistory'])->name('history')->middleware('auth');
Route::get('/historyAgrupado', [HistoryController::class, 'getHistoryGroup'])->name('historyAgrupado')->middleware('auth');

Route::post('/articles/{artcod}', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
// ajax (los 4)
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show')->middleware('auth');
Route::post('/cart/{artcod}', [CartController::class, 'removeItem'])->name('cart.removeItem')->middleware('auth');
Route::get('/selectTipo/{artcod}', [CartController::class, 'selectTipo'])->name('cart.selectTipo')->middleware('auth');
Route::post('/update-select/{cartcod}/{cartcant}/{type}', [CartController::class, 'changeSelect'])->middleware('auth');

Route::post('/update-cart/{cartcod}', [CartController::class, 'updateCart'])->name('cart.updateCart')->middleware('auth');
// ModalCart (AJAX)
Route::get('/modalCart', [CartController::class, 'showModalCart'])->name('cart.modalCart')->middleware('auth');

// Generar pedido
Route::post('/order', [PedidoController::class, 'makeOrder'])->name('makeOrder')->middleware('auth');

//redirige al
Route::get('/order/{result}', [PedidoController::class, 'orderResult'])->name('orderResult')->middleware('auth');

// Ver pedidos
Route::get('/pedidos/pedido/{id?}', [PedidoController::class, 'mostrarPedido'])->name('pedido.mostrarPedido')->middleware('auth');
Route::get('/pedidos', [PedidoController::class, 'mostrarTodos'])->name('pedido.mostrarTodos')->middleware('auth');


// guardar comentario
Route::post('/guardar-comentario', [PedidoController::class, 'guardarComentario']);



// ==============================================================
//   Todas las rutas relacionadas con: GESTIÓN DOCUMENTAL
// ==============================================================

// ruta para descargar documentos
Route::get('/documentos/download/{filename}', [DocumentoController::class, 'descargarDocumento'])->name('descargar.documento')->middleware('auth');
// ruta para obtener los documentos (AJAX DATATABLES)
Route::get('/documentos/{doctip?}', [DocumentoController::class, 'getDocumentos'])->name('get.documentos')->middleware('auth');
// ver documento
Route::get('/documentos/ver/{filename}', [DocumentoController::class, 'verDocumento'])
    ->where('filename', '.*')
    ->name('documentos.ver')
    ->middleware('auth');

//descargar archivos temporales
Route::get('local/temp/{path}', [DocumentoController::class, 'verArchivoTemporal'])->name('local.temp');


// ==============================================================
//   Todas las rutas relacionadas con: PUNTOS DE REGALO
// ==============================================================
Route::get('/puntosderegalo', [PuntosController::class, 'allPoints'])->name('all.points')->middleware('auth');

// ajax (datatables)
Route::get('/historicoPuntos', [PuntosController::class, 'getPoints'])->name('get.points')->middleware('auth');
// Route::get('/historicoPuntosAgrupado', [PuntosController::class, 'getPointsGroup'])->name('get.pointsGroup')->middleware('auth');


// ==============================================================
//   Todas las rutas relacionadas con: LEGAL (FOOTER)
// ==============================================================

// contactanos
Route::view('/contacto', 'pages.contacto.formulario')->name('contacto.formulario');
Route::post('/contacto/email', [SupportController::class, 'contactoEmail'])->name('contacto.email');

// politica de privacidad
Route::view('/politica-de-privacidad', 'pages.legal.privacidad')->name('privacidad');

// politica de cookies
Route::view('/politica-de-cookies', 'pages.legal.cookies')->name('cookies');

// politica de privacidad redes sociales
Route::view('/politica-de-redes', 'pages.legal.redes')->name('redes');

// aviso legal
Route::view('/aviso-legal', 'pages.legal.aviso')->name('avisoLegal');





// TEMPORALES
Route::get('/clear-all-caches', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return response()->json(['message' => 'All caches cleared']);
});
