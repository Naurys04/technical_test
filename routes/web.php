<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

/*   For Excel  */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/*   For Email */
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;

/*   For  FPDF  */
use Codedge\Fpdf\Fpdf\Fpdf;



/*   For LDAP */
use Adldap\Laravel\Facades\Adldap;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Route::get('error-conexion-db', function() {
    return view('errors.databaseConnectionError');
})->name('error.conexion.db');

Route::get('language/{lang?}', function($lang = 'en') {
    session()->put('language', $lang);
    //return redirect()->back();
    return redirect('/');
})->name('language');

Route::match(['get', 'post'], 'login', [UserController::class, 'login'])->name('login');
Route::group(array('middleware' => array('auth')), function() {
	Route::get('/', [MainController::class, 'index'])->name('index');
	Route::get('logout', [UserController::class, 'logOut'])->name('logout');
	
	Route::get('usuarios', [MainController::class, 'usuarios'])->name('usuarios');
	Route::post('registro_usuarios', [MainController::class, 'registro_usuarios'])->name('registro_usuarios');
	Route::post('buscar_usuario', [MainController::class, 'buscar_usuario'])->name('buscar_usuario');
	Route::post('buscar_correo', [MainController::class, 'buscar_correo'])->name('buscar_correo');
	Route::post('buscar_edicion_user', [MainController::class, 'buscar_edicion_user'])->name('buscar_edicion_user');

	Route::get('productos', [MainController::class, 'productos'])->name('productos');
	Route::post('registro_productos', [MainController::class, 'registro_productos'])->name('registro_productos');
	Route::post('products_comment', [MainController::class, 'products_comment'])->name('products_comment');
	Route::post('buscar_codigo_producto', [MainController::class, 'buscar_codigo_producto'])->name('buscar_codigo_producto');
	Route::post('buscar_descripcion_producto', [MainController::class, 'buscar_descripcion_producto'])->name('buscar_descripcion_producto');
	Route::post('buscar_edicion_producto', [MainController::class, 'buscar_edicion_producto'])->name('buscar_edicion_producto');
	Route::post('eliminar_registro_productos', [MainController::class, 'eliminar_registro_productos'])->name('eliminar_registro_productos');
	
	Route::get('inventario', [MainController::class, 'inventario'])->name('inventario');
	Route::post('registro_inventario', [MainController::class, 'registro_inventario'])->name('registro_inventario');
	
	Route::get('caja', [MainController::class, 'caja'])->name('caja');
	Route::post('registro_caja', [MainController::class, 'registro_caja'])->name('registro_caja');

	Route::get('cajaespecial', [MainController::class, 'cajaespecial'])->name('cajaespecial');
	Route::post('registro_cajaespecial', [MainController::class, 'registro_cajaespecial'])->name('registro_cajaespecial');

	Route::get('retiromercancia', [MainController::class, 'retiromercancia'])->name('retiromercancia');
	Route::post('registro_retiromercancia', [MainController::class, 'registro_retiromercancia'])->name('registro_retiromercancia');

	Route::get('tasa', [MainController::class, 'tasa'])->name('tasa');
	Route::post('registro_tasa', [MainController::class, 'registro_tasa'])->name('registro_tasa');
	Route::post('buscar_edicion_tasa', [MainController::class, 'buscar_edicion_tasa'])->name('buscar_edicion_tasa');

	Route::get('reportegeneral', [MainController::class, 'reportegeneral'])->name('reportegeneral');
	Route::post('reportes_condiciones', [MainController::class, 'reportes_condiciones'])->name('reportes_condiciones');
	
	Route::get('facturadeuda', [MainController::class, 'facturadeuda'])->name('facturadeuda');
	Route::post('registrodeuda', [MainController::class, 'registrodeuda'])->name('registrodeuda');
	Route::post('buscardetalle', [MainController::class, 'buscardetalle'])->name('buscardetalle');
});






