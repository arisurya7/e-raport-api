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
        
        //kompetensi dasar
        $router->post('/kompetensidasar', "KompetensiDasarController@store");
        $router->get('/kompetensidasar', "KompetensiDasarController@show");
        $router->put('/kompetensidasar/{id}', "KompetensiDasarController@update");
        $router->delete('/kompetensidasar/{id}', "KompetensiDasarController@destroy");

        //tema
        $router->post('/tema', "TemaController@store");
        $router->get('/tema', "TemaController@show");
        $router->put('/tema/{id}', "TemaController@update");
        $router->delete('/tema/{id}', "TemaController@destroy");

        //tema kd
        $router->post('/temakd', "TemaKdController@store");
        $router->get('/temakd', "TemaKdController@show");
        $router->put('/temakd/{id}', "TemaKdController@update");
        $router->delete('/temakd/{id}', "TemaKdController@destroy");

        //tema kd
        $router->post('/temajenis', "TemaJenisController@store");
        $router->get('/temajenis', "TemaJenisController@show");
        $router->put('/temajenis/{id}', "TemaJenisController@update");
        $router->delete('/temajenis/{id}', "TemaJenisController@destroy");

        //nilai_sosial
        $router->post('/nilaisosial', "NilaiSosialController@store");
        $router->get('/nilaisosial', "NilaiSosialController@show");
        $router->get('/nilaisosial/{id}', "NilaiSosialController@detail");
        $router->put('/nilaisosial/{id}', "NilaiSosialController@update");

        //nilai_spiritual
        $router->post('/nilaispiritual', "NilaiSpiritualController@store");
        $router->get('/nilaispiritual', "NilaiSpiritualController@show");
        $router->get('/nilaispiritual/{id}', "NilaiSpiritualController@detail");
        $router->put('/nilaispiritual/{id}', "NilaiSpiritualController@update");

        //jenis nilai
        $router->get('/jenisnilai', "JenisNilaiController@show");

        //list penilaian
        $router->get('/penilaian-pengetahuan', "KompetensiDasarController@pengetahuan");
        $router->get('/penilaian-keterampilan', "KompetensiDasarController@keterampilan");

        //nilai pengetahuan
        $router->post('/nilai-pengetahuan', "NilaiPengetahuanController@store");
        $router->put('/nilai-pengetahuan/{id}', "NilaiPengetahuanController@update");
        $router->delete('/nilai-pengetahuan/{id}', "NilaiPengetahuanController@destroy");
        
        //nilai keterampilan
        $router->post('/nilai-keterampilan', "NilaiKeterampilanController@store");
        $router->put('/nilai-keterampilan/{id}', "NilaiKeterampilanController@update");
        $router->delete('/nilai-keterampilan/{id}', "NilaiKeterampilanController@destroy");

        //raport
        $router->get('/raport', "RaportController@show");
        
    });
});
