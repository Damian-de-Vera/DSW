<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);
Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store']);

// Crea una ruta que tenga un parámetro que sea opcional y comprueba que funciona.
Route::get('/community/{name?}', function ($param = null) {
    return $param;
});

//Crea una ruta que tenga un parámetro que sea opcional y tenga un valor por defecto en caso de que no se especifique.
Route::get('/ruta2/{name?}', function ($param = 'Soy valor por defecto') {
    return $param;
});

//Crea una ruta que atienda por POST y compruébala con Postman. Si obtienes un error de tipo VerifyCsrfToken comenta la línea correspondiente en el fichero kernel.php (carpeta Http). 
//Esto es un filtro para evitar ataques XSS (Cross-Site Scripting). ¡Vuelve a descomentarla cuando termines con las prácticas!
Route::post('/ruta3', function () {
    $hola = $_POST["hola"];
    return $hola;
});

//Crea una ruta que atienda por GET y por POST (en un único método) y compruébalas.
// Vuelve a habilitar el filtro VerifyCsrfToken en el fichero kernel.php (carpeta Http).
Route::any('/ruta4', function ($hola = "hola") {
    return $hola;
});

//Crea una ruta que compruebe que un parámetro está formado sólo por números.
Route::get('/ruta5/{numero}', function ($numero) {
    $numero = "Soy numérico";
    return $numero;
});

//Crea una ruta con dos parámetros que compruebe que el primero está formado sólo por letras y el segundo sólo por números.
Route::get('/ruta5/{letra?}&{numero?}', function () {
    $numero = "Soy numérico";
    $letra = "soy letras";
    $array = [$letra, $numero];
    return $array;
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
