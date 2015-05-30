<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

$router->group(['prefix'=>'companies'], function() use ($router) {
    \App\Http\Controllers\CompaniesController::routes($router);

    $router->group(['prefix'=>'{company_id}/ships'], function() use ($router) {
        \App\Http\Controllers\ShipsController::routes($router);

        $router->group(['prefix'=>'{ship_id}/stops'], function() use ($router) {
            \App\Http\Controllers\StopsController::routes($router);
        });
    });

});

$router->group(['prefix'=>'clients'], function() use ($router) {
    \App\Http\Controllers\ClientsController::routes($router);

    $router->group(['prefix'=>'{client_id}/containers'], function() use ($router) {
        \App\Http\Controllers\ContainersController::routes($router);

        $router->group(['prefix'=>'{container_id}/movements'], function() use ($router) {
            \App\Http\Controllers\MovementsController::routes($router);
        });
    });
});

$router->group(['prefix'=>'stats'], function() use ($router) {
    $router->any('quantity-by-month-companies', ['uses' => 'StatsController@quantityOnMonth',
        'as' => 'stats.quantityOnMonth']);
    $router->any('quantity-by-month-clients', ['uses' => 'StatsController@quantityOnMonth_clients',
        'as' => 'stats.quantityOnMonth_clients']);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
]);
