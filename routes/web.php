<?php

use Dingo\Api\Routing\Router;

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

$api = app(Router::class);

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'oauth'], function ($api) {
        $api->post('token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
    });

    $api->group(['namespace' => 'App\Http\Controllers'], function ($api) {
        $api->post('user', 'UserController@store');
    });

    $api->group(
        [
            'namespace' => 'App\Http\Controllers',
            'middleware' => ['auth:api', 'cors'],
        ],
        function ($api) {
            $api->put('user', 'UserController@update');
            $api->delete('user', 'UserController@destroy');
        }
    );
});
