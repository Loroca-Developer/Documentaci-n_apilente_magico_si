<?php


use Illuminate\Support\Facades\Route;
// Administrador y Optometra
use App\Http\Controllers\autorizacionControlador;
use App\Http\Controllers\autorizacionUsuarioControlador;
use App\Http\Controllers\usuarioControlador;
use App\Http\Controllers\datosPersonalesControlador;
use App\Http\Controllers\tipoDocumentoControlador;
use App\Http\Controllers\logErroresControlador;
use App\Http\Controllers\consultaControlador;
use App\Http\Controllers\antecedentesControlador;
use App\Http\Controllers\historiaClinicaControlador;
use App\Http\Controllers\formulaOpticaControlador;
/// modulo de Compra y Bodega
use App\Http\Controllers\CategoriasControlador;
use App\Http\Controllers\ComprasControlador;
use App\Http\Controllers\ProductosControlador;
use App\Http\Controllers\ProveedoresControlador;
use App\Http\Controllers\DetalleCompraControlador;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\asignarAutorizacionControlador;

//Route::middleware('auth:sanctum') ->get('/user', function (Request $request) {
 //   return $request->user();
//)
//};

Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth:sanctum');




Route::post('/login', [AuthController::class, 'login']); // Ruta publica para el inicio de sesión(no requiere autenticación)


//Rutas protegidas (Requieren token JWT)
Route::middleware(['jwt.auth'])->group(function () {
// Route::middleware([ 'jwt.auth', 'auth:api'])->group(function () { 
//Rutas de autenticación
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);
Route::post('/refresh', [AuthController::class, 'refresh']);


//Rutas Existentes en el proyecto(ahora son rutas protegidads)

//Autorizacion (Roles de sistema)

Route::get('/asignar_autorizacion', [asignarAutorizacionControlador::class, 'index']);
Route::post('/asignar_autorizacion', [asignarAutorizacionControlador::class, 'store']);
Route::get('/asignar_autorizacion/{id}', [asignarAutorizacionControlador::class, 'show']);
Route::put('/asignar_autorizacion/{id}', [asignarAutorizacionControlador::class, 'update']);
Route::delete('/asignar_autorizacion/{id}', [asignarAutorizacionControlador::class, 'destroy']);


Route::get('/autorizacion', [autorizacionControlador::class, 'index']);
Route::post('/autorizacion', [autorizacionControlador::class, 'store']);
Route::get('/autorizacion/{id}', [autorizacionControlador::class, 'show']);
Route::put('/autorizacion/{id}', [autorizacionControlador::class,   'update']); 
Route::delete('/autorizacion/{id}', [autorizacionControlador::class, 'destroy']);

Route::get('/autorizacion_usuario', [autorizacionUsuarioControlador::class, 'index']);
Route::post('/autorizacion_usuario', [autorizacionUsuarioControlador::class, 'store']);
Route::get('/autorizacion_usuario/{id_autorizacion}/{id_sistema_usuario}', [autorizacionUsuarioControlador::class, 'show']);
Route::put('/autorizacion_usuario/{id_autorizacion}/{id_sistema_usuario}', [autorizacionUsuarioControlador::class, 'update']);
Route::delete('/autorizacion_usuario/{id_autorizacion}/{id_sistema_usuario}', [autorizacionUsuarioControlador::class, 'destroy']);

Route::get('/usuario', [UsuarioControlador::class, 'index']);
Route::post('/usuario', [UsuarioControlador::class, 'store']);
Route::get('/usuario/{id}', [UsuarioControlador::class, 'show']);
Route::put('/usuario/{id}', [UsuarioControlador::class, 'update']);
Route::delete('/usuario/{id}', [UsuarioControlador::class, 'destroy']);

Route::get('/datos_personales', [datosPersonalesControlador::class, 'index']);
Route::post('/datos_personales', [datosPersonalesControlador::class, 'store']);
Route::get('/datos_personales/{id}', [datosPersonalesControlador::class, 'show']);
Route::put('/datos_personales/{id}', [datosPersonalesControlador::class, 'update']);
Route::delete('/datos_personales/{id}', [datosPersonalesControlador::class, 'destroy']);




Route::get('/tipo_documento', [tipoDocumentoControlador::class, 'index']);
Route::post('/tipo_documento', [tipoDocumentoControlador::class, 'store']);
Route::get('/tipo_documento/{id}', [tipoDocumentoControlador::class, 'show']);
Route::put('/tipo_documento/{id}', [tipoDocumentoControlador::class, 'update']);
Route::delete('/tipo_documento/{id}', [tipoDocumentoControlador::class, 'destroy']);



Route::get('/log_errores', [logErroresControlador::class, 'index']);
Route::post('/log_errores', [logErroresControlador::class, 'store']);
Route::get('/log_errores/{id}', [logErroresControlador::class, 'show']);
Route::put('/log_errores/{id}', [logErroresControlador::class, 'update']);
Route::delete('/log_errores/{id}', [logErroresControlador::class, 'destroy']);

Route::get('/consulta', [consultaControlador::class, 'index']);
Route::post('/consulta', [consultaControlador::class, 'store']);
Route::get('/consulta/{id_consulta}', [consultaControlador::class, 'show']);
Route::put('/consulta/{id_consulta}', [consultaControlador::class, 'update']);
Route::delete('/consulta/{id_consulta}', [consultaControlador::class, 'destroy']);



Route::get('/antecedentes', [antecedentesControlador::class, 'index']);
Route::post('/antecedentes', [antecedentesControlador::class, 'store']);
Route::get('/antecedentes/{id}', [antecedentesControlador::class, 'show']);
Route::put('/antecedentes/{id}', [antecedentesControlador::class, 'update']);
Route::delete('/antecedentes/{id}', [antecedentesControlador::class, 'destroy']);


Route::get('/formula_optica', [formulaOpticaControlador::class, 'index']);
Route::post('/formula_optica', [formulaOpticaControlador::class, 'store']);
Route::get('/formula_optica/{id}', [formulaOpticaControlador::class, 'show']);
Route::put('/formula_optica/{id}', [formulaOpticaControlador::class, 'update']);
Route::delete('/formula_optica/{id}', [formulaOpticaControlador::class, 'destroy']);



Route::get('/historia_clinica', [historiaClinicaControlador::class, 'index']);
Route::post('/historia_clinica', [historiaClinicaControlador::class, 'store']);
Route::get('/historia_clinica/{id}', [historiaClinicaControlador::class, 'show']);
Route::put('/historia_clinica/{id}', [historiaClinicaControlador::class, 'update']);
Route::delete('/historia_clinica/{id}', [historiaClinicaControlador::class, 'destroy']);

//Modulo de Compra y Bodega

Route::get('/cat_producto', [CategoriasControlador::class, 'index']);
Route::post('/cat_producto', [CategoriasControlador::class, 'store']);
Route::get('/cat_producto/{id_categoria}', [CategoriasControlador::class, 'show']);
Route::put('/cat_producto/{id_categoria}', [CategoriasControlador::class, 'update']);
Route::delete('/cat_producto/{id_categoria}', [CategoriasControlador::class, 'destroy']);

// Rutas para Compras
Route::get('/compra', [ComprasControlador::class, 'index']);
Route::post('/compra', [ComprasControlador::class, 'store']);
Route::get('/compra/{id_compra}', [ComprasControlador::class, 'show']);
Route::put('/compra/{id_compra}', [ComprasControlador::class, 'update']);
Route::delete('/compra/{id_compra}', [ComprasControlador::class, 'destroy']);

// Rutas para Productos 
Route::get('/producto', [ProductosControlador::class, 'index']);
Route::post('/producto', [ProductosControlador::class, 'store']);
Route::get('/producto/{id_producto}', [ProductosControlador::class, 'show']);
Route::put('/producto/{id_producto}', [ProductosControlador::class, 'update']);
Route::delete('/producto/{id_producto}', [ProductosControlador::class, 'destroy']);

// Rutas para Proveedores 
Route::get('/proveedor', [ProveedoresControlador::class, 'index']);
Route::post('/proveedor', [ProveedoresControlador::class, 'store']);
Route::get('/proveedor/{id_proveedor}', [ProveedoresControlador::class, 'show']);
Route::put('/proveedor/{id_proveedor}', [ProveedoresControlador::class, 'update']);
Route::delete('/proveedor/{id_proveedor}', [ProveedoresControlador::class, 'destroy']);

// Rutas para Detalle Compra
Route::get('/detalle_compra', [DetalleCompraControlador::class, 'index']);
Route::post('/detalle_compra', [DetalleCompraControlador::class, 'store']);
Route::get('/detalle_compra/{id_detalle_compra}', [DetalleCompraControlador::class, 'show']);
Route::put('/detalle_compra/{id_detalle_compra}', [DetalleCompraControlador::class, 'update']);
Route::delete('/detalle_compra/{id_detalle_compra}', [DetalleCompraControlador::class, 'destroy']);







});