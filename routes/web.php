<?php

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

$router->post('/login', 'AuthController@login');

$router->get('/products', ['middleware' => 'auth', 'uses' => 'ProductController@list']);
$router->post('/product/input', ['middleware' => ['auth', 'cashier'], 'uses' => 'ProductController@input']);
$router->post('/product/{id}/review', ['middleware' => ['auth', 'spv'], 'uses' => 'ProductController@review']);
$router->post('/product/{id}/resubmit', ['middleware' => ['auth', 'cashier'], 'uses' => 'ProductController@resubmit']);