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

$router->get('/card/all', 'CardController@all');
$router->get('/card/{id}/available-balance', 'CardController@availableBalance');
$router->get('/card/{id}/activity', 'CardController@getActivity');

$router->post('/card/add', 'CardController@add');
$router->post('/card/{id}/top-up', 'CardController@topUp');
$router->post('/card/{id}/authorize', 'CardController@requestPayment');

$router->get('/merchant/{id}/transactions', 'MerchantController@getTransactions');
$router->post('/merchant/add', 'MerchantController@add');
$router->post('/merchant/{id}/refund', 'MerchantController@refund');
$router->put('/merchant/{id}/capture-transaction', 'MerchantController@capture');

