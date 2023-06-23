<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorUsuario;
use Illuminate\Support\Facades\Session;

// Route::get('/', function () {
//     // valido si la session existe
//     //$request->session()->exists('users')
//     if (Session::has('iduser')) {
//         return view('login/login');
//     } else {
//         return redirect()->to('Admin'); 
//         //redirect()->route('Admin');
//     }
//     //elimina datos de session
//     //$request->session()->flush();
// });

// Route::get('Admin', function () {

//     if (Session::has('iduser')) {
//         return view('Admin/index');
//     } else {
//         return redirect()->to('/');
//     }

// })->name("Admin");

Route::get('/', [ControladorUsuario::class, 'Index'])->name("/");
//AJAX
Route::post('cursos', [ControladorUsuario::class, 'Credenciales'])->name("cursos.Credenciales");
//END AJAX
Route::post('tokensession', [ControladorUsuario::class, 'Token'])->name("tokensession.Token");
Route::get('/Cerrar', [ControladorUsuario::class, 'Cerrar'])->name("Cerrar");
Route::get('/Admin', [ControladorUsuario::class, 'Admin'])->name("Admin");


///USUARIO------------------
///VITAS DEL USUARIO, CREAR Y LISTA
Route::get('/Admin/Usuario/{valor}', [ControladorUsuario::class, 'Usuario'])->name("Admin.Usuario");
// Controlador de registro, editar, listas
//REGISTRA USUARIO
Route::post('/Admin/Usuario/{valor}', [ControladorUsuario::class, 'RegisterUser'])->name("registeruser.RegisterUser");
//EDITAR USUARIO
Route::get('/Admin/Usuario/Editar/{valor}', [ControladorUsuario::class, 'EditarUsuario'])->name("User.Editar");
//UPDATE USUARIO
Route::post('/Admin/Usuario/Editar/{valor}', [ControladorUsuario::class, 'UpdateUsuario'])->name("User.Update");
//ESTAdo USUARIO
Route::post('/EstadoUsuario', [ControladorUsuario::class, 'EstadoUsuario'])->name("Usuario.EstadoUsuario");
///END USUARIO-------------


///ROL------------------
///VITAS DEL ROL, CREAR Y LISTA
Route::get('/Admin/Rol/{valor}', [ControladorUsuario::class, 'Rol'])->name("Admin.Rol");
// Controlador de registro, editar, listas
//REGISTRA ROL
Route::post('/Admin/Rol/{valor}', [ControladorUsuario::class, 'RegisterRol'])->name("registerrol.RegisterRol");
//EDITAR ROL
Route::get('/Admin/Rol/Editar/{valor}', [ControladorUsuario::class, 'EditarRol'])->name("Rol.Editar");
//UPDATE ROL
Route::post('/Admin/Rol/Editar/{valor}', [ControladorUsuario::class, 'UpdateRol'])->name("Rol.Update");
///END ROL-------------




//Route::match(['get', 'post'], 'input', 'ControladorUsuario@Credenciales')->name("tokensession.Token");


// Route::post('/credenciales', 'ControladorUsuario@Credenciales')->name("credenciales");
//Route::post('/credenciales', [App\Http\Controllers\ControladorUsuario::class, 'ControladorUsuario'])->name('credenciales');