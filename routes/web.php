<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index1');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// route::get('/pertanyaan', 'PertanyaanController@index');
// route::get('/pertanyaan/create', 'PertanyaanController@create');
// route::post('/pertanyaan', 'PertanyaanController@store');
// route::delete('/pertanyaan/{id}', 'PertanyaanController@destroy');
// route::get('/pertanyaan/{id}', 'PertanyaanController@show');
// route::get('/pertanyaan/{id}/edit', 'PertanyaanController@edit');
// route::put('/pertanyaan/{id}', 'PertanyaanController@update');

Route::resource('pertanyaan', 'PertanyaanController');

route::post('/pertanyaan/{pertanyaan_id}', 'JawabanController@store');

Route::get('/pertanyaan/upvote/{id}', 'PertanyaanController@upvote');
Route::get('/pertanyaan/unupvote/{id}', 'PertanyaanController@unupvote');

Route::get('/pertanyaan/downvote/{id}', 'PertanyaanController@downvote');
Route::get('/pertanyaan/undownvote/{id}', 'PertanyaanController@undownvote');

Route::get('/jawaban/selected/{answer_id}/{user_question}/{user_answer}', 'JawabanController@selected');
Route::get('/jawaban/unselected/{answer_id}/{user_question}/{user_answer}', 'JawabanController@unselected');

Route::get('/jawaban/upvote/{id}', 'JawabanController@upvote');
Route::get('/jawaban/unupvote/{id}', 'JawabanController@unupvote');

Route::get('/jawaban/downvote/{id}', 'JawabanController@downvote');
Route::get('/jawaban/undownvote/{id}', 'JawabanController@undownvote');

route::post('/komentarpertanyaan/{pertanyaan_id}', 'KomentarController@storeQuestion');
route::post('/komentarjawaban/{jawaban_id}/{pertanyaan_id}', 'KomentarController@storeAnswer');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});