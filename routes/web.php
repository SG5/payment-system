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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'account'], function () use ($app) {
    $app->post('', 'AccountController@create');
    $app->get('{id:[1-9]\d*}', 'AccountController@info');
    $app->put('{id:[1-9]\d*}/refill', 'AccountController@refill');
    $app->put('{id:[1-9]\d*}/transaction', 'AccountController@transaction');
});
