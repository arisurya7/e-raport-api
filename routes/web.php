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

$router->group(['prefix' => 'api/v1'], function ($router) {
    //login and register
    $router->post('/register', "UserController@register");
    $router->post('/login', "UserController@login");
    $router->group(['middleware' => 'auth'], function($router) {
        //user
        $router->get('/user',"UserController@show");
        $router->put('/user',"UserController@update");

        //sekolah
        $router->post('/sekolah', "SekolahController@store");
        $router->get('/sekolah', "SekolahController@show");
        $router->put('/sekolah/{id}', "SekolahController@update");
        $router->delete('/sekolah/{id}', "SekolahController@destroy");

        //mapel
        $router->post('/mapel', "MapelController@store");
        $router->get('/mapel', "MapelController@show");
        $router->put('/mapel/{id}', "MapelController@update");
        $router->delete('/mapel/{id}', "MapelController@destroy");

        //siswa
        $router->post('/siswa', "SiswaController@store");
        $router->get('/siswa', "SiswaController@show");
        $router->put('/siswa/{id}', "SiswaController@update");
        $router->delete('/siswa/{id}', "SiswaController@destroy");
        
    });
});
