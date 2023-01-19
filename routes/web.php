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
// Utiliza el helper env para que cuando se acceda a la ruta /host nos devuleva la dirección IP donde se encuentra la base de datos de nuestro proyecto.

Route::get('/host', function () {
    $env = env('REDIS_HOST');

    return $env;
});

// Utiliza el helper config para que cuando se acceda a la ruta /timezone se muestre la zona horaria.

Route::get('/timezone', function () {
    $value = config('app.timezone');
    return $value;
});

//Define una vista llamada home.blade.php que muestre "Esta es mi primera vista en Laravel"
//al acceder a la ruta /inicio de tu proyecto. Utiliza Route::view.
Route::view('/inicio', 'home');

//Crea otra vista que se llame fecha.blade.php y crea una ruta en /fecha 
// La ruta le pasará a la vista un array asociativo para que se muestre la fecha sacando por pantalla las variables de dicho array.
// El día estará en una variable, el mes en otra y el año en otra (puedes usar la función date() de PHP).Utiliza el helper view.
Route::view('/fecha', 'fecha', ['dia' => date("d"), 'mes' => date("F"), 'anio' => date("Y")]);


//Haz lo mismo pero con el helper with.
/*
Route::get('/fecha', function () {
    return view('fecha')
        ->with('dia', date("d"))
        ->with('mes', date("F"))
        ->with('anio', date("Y"));
});
*/
//Cargar imágenes desde blade. Crea una carpeta images en el directorio public y dentro sube una imagen 404.jpg personalizada. Crea una vista de prueba que acceda a la imagen utilizando 
//el helper asset(images/404.jpg) y comprueba que funciona (<img src="{{asset('images/404.jpg')}}" alt="Error 404">).
Route::view('/prueba', 'prueba');

//Personalizar páginas de error. Crea una carpeta errors dentro de views. Crea una vista 404.blade.php que
// incluya la imagen 404.jpg personalizada y comprueba que puedes ver tu imagen si accedes a una ruta que no existe.

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