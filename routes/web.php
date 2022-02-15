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


$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('register', ['uses' => 'AuthController@register']);

    $router->post('login', ['uses' => 'AuthController@login']);

    $router->group(['prefix' => 'users', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', ['uses' => 'UserController@getAllUsers']);
        $router->get('/{id}', ['uses' => 'UserController@getById']);
        $router->put('/{id}', ['uses' => 'UserController@update']);
        $router->put('/{id}/email', ['uses' => 'UserController@changeEmail']);
        $router->put('/{id}/password', ['uses' => 'AuthController@resetPassword']);
    });
});
