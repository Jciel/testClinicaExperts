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

$router->get('/{identifier}', '\App\Http\Controllers\ShortLinkController@access');

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('/list', '\App\Http\Controllers\ShortLinkController@index');

    $router->get('/get-stats', '\App\Http\Controllers\ShortLinkController@getStats');

    $router->post('/search', '\App\Http\Controllers\ShortLinkController@search');

    $router->post('/create', [
        'middleware' => 'createShortLink',
        'uses' => '\App\Http\Controllers\ShortLinkController@create'
    ]);

    $router->patch('/update/{id}', [
        'middleware' => 'createShortLink',
        'uses' => '\App\Http\Controllers\ShortLinkController@update'
    ]);

    $router->delete('/delete/{id}', '\App\Http\Controllers\ShortLinkController@delete');
});
