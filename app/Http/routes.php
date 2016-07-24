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

Route::get('/', function () {
    return redirect('http://sonsofdeathswc.wix.com/sons');
});

Route::get('/squadview', 'SquadController@viewSquad');
Route::any('/squadsearch', 'SquadController@squadSearch');

Route::post('/j/batch/json', function () {
//    return '{
//  "protocolVersion": 46,
//  "data": [
//    {
//      "requestId": 2,
//      "messages": {},
//      "status": 0,
//      "result": "B4cN_uoqi3pMbQzh3nB3hN_1y8krzo-9SFPxtjMU3sg.eyJ1c2VySWQiOiI5YjNkMTg4My0yYjE4LTExZTUtOGZmMy0wNjg3ODYwMDRmMTIiLCJleHBpcmVzIjoiMTQ2NjE4NzIyMiJ9"
//    }
//  ],
//  "serverTime": "2016-06-17T18:13:42Z",
//  "serverTimestamp": 1466187222
//}';
    $headers = array();
    foreach ($_SERVER as $name => $value) {
        if (strpos($name, 'HTTP_') === 0) {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;

        }
    }
    $request = '<pre>';
    $request .= $_SERVER['REQUEST_METHOD'];
    $request .= ' https://';
    $request .= $_SERVER['HTTP_HOST'];
    $request .= $_SERVER['REQUEST_URI'];
    $request .= ' ' . $_SERVER['SERVER_PROTOCOL'] . "\r\n";
    foreach ($headers as $key => $value) {
        $request .= $key . ': ' . $value . "\r\n";
    }
    $request .= "\r\n";
    foreach ($_POST as $key => $value) {
        $request .= $key . '=' . $value . "\r\n";
    }
    $request .= '</pre>';
    return $request;
});
