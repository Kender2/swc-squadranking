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

Route::get('/test', 'TestController@test');

Route::get('squad/{id}', 'SquadController@squadHistory')->name('squadhistory');

Route::get('squadview', 'SquadController@viewSquad')->name('squadview');
Route::get('squadranking', 'RankingController@ranking')->name('squadranking');
Route::any('ssquadsearch', 'SquadController@ssquadSearch')->name('ssquadsearch');
Route::any('squadsearch', 'SquadController@squadSearch')->name('squadsearch');

Route::any('faq', 'FAQController@form')->name('faq');
