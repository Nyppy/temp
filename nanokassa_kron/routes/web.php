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

use Illuminate\Http\Response;

$router->get('/', function () use ($router) {
    // return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    return 'test';
});

$router->post('/send', "NanokassaController@send");