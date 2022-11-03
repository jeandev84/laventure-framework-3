####

```php 

<?php

use Laventure\Foundation\Facade\Routing\Route;


/*
|----------------------------------------------------------------------
|     Registration all web routes
|----------------------------------------------------------------------
*/


/*
Route::get('/', function (\Laventure\Component\Http\Request\Request $request) {
     return view('welcome.php');
});
*/

Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])
    ->name('home');

Route::get('/show/{id}', [\App\Http\Controllers\PageController::class, 'show'])
    ->name('show');

Route::get('/contact', [\App\Http\Controllers\PageController::class, 'contact'])
    ->name('show.contact');

Route::post('/contact', [\App\Http\Controllers\PageController::class, 'send'])
    ->name('send.contact');


```