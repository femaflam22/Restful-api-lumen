<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// generete key app
// $router->get('/key', function() {
//     return \Illuminate\Support\Str::random(32);
// });

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
// $router->get('/logout', 'AuthController@logout');

$router->group(['prefix' => 'categories'], function () use ($router) {
    $router->get('/', 'CategoryController@index');
    $router->get('id/{id}', 'CategoryController@show');
    $router->get('/{id}/books', 'CategoryController@findBook');
    $router->post('/', 'CategoryController@store');
    $router->patch('/{id}', 'CategoryController@update');
    $router->delete('/{id}', 'CategoryController@destroy');
});

$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'BookController@index');
    $router->get('/id/{id}', 'BookController@show');
    $router->get('/{search}/search', 'BookController@index');
    $router->post('/', 'BookController@store');
    $router->delete('/{id}', 'BookController@destroy');
    $router->patch('/{id}', 'BookController@update');
});