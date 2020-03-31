<?php

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
    return view('welcome');
});

// Prüfling Routesphp

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/Pruefling/persD', 'HomeController@persD');

Route::get('/Pruefling/select_disciplines', 'disciplineController@show');
Route::post('/Pruefling/select_disciplines', 'disciplineSelectController@select_discipline');

Route::get('/Pruefling/select_disciplines_edit/{id}', 'disciplineSelectController@index');
Route::post('/Pruefling/select_disciplines_edit', 'disciplineSelectController@update_select_discipline');
Route::get('/Pruefling/select_disciplines', 'disciplineSelectController@index2');



Route::post('/anmeldungAbschluss', function () {
    return view('Pruefling/anmeldungAbschluss');
});


Route::resource('PersDatenPruefling', 'persDatenPrueflingController');

Route::get('/aboutUs', function (){
    return view('aboutUs');
});

Route::get('/PersDatenPruefling_edit/{id}', 'persDatenPrueflingController@edit');

Route::post('/PersDatenPruefling/{id}/{idu}', 'persDatenPrueflingController@update');

Route::post('/PersDatenPruefling/{id}', 'persDatenPrueflingController@abschluss');

Route::get('/Pruefling/ende', function () {
    return view('Pruefling/ende');
});


// Admin Routes
Route::resource('/Admin/createNewSport','sportController');
Route::post('/Admin/createNewSport', 'sportController@store');

Route::resource('/Admin/createNewDiscipline','disciplineController');
Route::get('Admin/disciplineOverview', 'disciplineController@show_index');

Route::resource('/Admin/setErrorCodes/','ErrorCodesController');
Route::post('/Admin/setErrorCodes/{id}/{backPoint}','ErrorCodesController@store');
Route::delete('/Admin/setErrorCodes/{id}/{backPoint}','ErrorCodesController@destroy');

Route::resource('/Admin/createNewTest','testController');
Route::get('/Admin/finishTest','testController@finishTestWarning');
Route::post('/Admin/finishTest', 'testController@destroy');




Route::get('/Admin/Kontrolleure_Uebersicht', 'UserController@show_Kontrolleure');
Route::get('/Admin/neuer_Anwesenheitskontrolleur_anlegen', 'UserController@show_create_Kontrolleure');
Route::get('/Admin/neuer_Pruefer_anlegen', 'UserController@show_create_Pruefer');

Route::get('/Admin/Pruefer_Uebersicht', 'UserController@show_Pruefer');
Route::get('/Admin/Pruefling_Uebersicht', 'UserController@show_Prueflinge');

Route::post('/Admin/Anwesenheitskontrolleur_anlegen', 'UserController@new_Anwesenheitskontrolleur');
Route::post('/Admin/Admin/Kontrolleure_Uebersicht{id}', 'UserController@destroy_Anwesenheitskontrolleur');

Route::post('/Admin/Pruefer_anlegen', 'UserController@new_Pruefer');
Route::post('/Admin/Admin/Pruefer_Uebersicht{id}', 'UserController@destroy_Pruefer');


Route::post('/Admin/Admin/Pruefling_Uebersicht{id}', 'UserController@destroy_Pruefling');
Route::post('/Admin/Pruefling_edit/{id}', 'UserController@edit_Pruefling');
Route::get('/Admin/Pruefling_edit/{id}', 'UserController@edit_Pruefling');

Route::get('/Admin/alle_Prueflinge_loeschen', function () {
    return view('/Admin/alle_Prueflinge_loeschen');
});
Route::post('/Admin/alle_Prueflinge_loeschen', 'UserController@delete_all_prueflinge');

Route::get('/Admin/createNewPruefling', function () {
    return view('/Admin/createNewPruefling');
});
Route::post('/Admin/createNewPruefling', 'UserController@storeNewPruefling');

Route::post('/Admin/NewPruefling_selectDiscipline/{cid}', 'UserController@enterDiscipline');

Route::get('/Admin/Export', function () {
    return view('/Admin/Export');
});
Route::get('duduu/export/', 'ExportController@exportallResults');
Route::get('dudu/export/', 'ExportController@exportTest');


//Route::post('/Pruefer/{d_id}/1', 'ErrorCodesController@edit');
Route::get('/Pruefer/{d_id}/er', 'ErrorCodesController@showForPruefer');
//Route::post('/Pruefer/{d_id}/{backPoint}', 'ResultController@store');
//Route::post('/Pruefer/{d_id}/{backPoint}', 'ResultController@delete');

Route::post('/Pruefer/{id}', 'ResultController@index');
Route::get('/Pruefer/{id}', 'ResultController@index');
Route::post('Admin/Result_edit/{id}', 'ResultController@update');
Route::post('Admin/Result_edit/recognize/{id}/{did}', 'ResultController@recognize');
Route::post('Admin/Result_edit/revoke/{id}/{did}', 'ResultController@revoke');

Route::post('/Pruefer/{id}/{idu}/{backPoint}', 'ResultController@store');
Route::get('/Pruefer/{id}/{idu}/{backPoint}', 'ResultController@store');

Route::get('/Pruefer/group_prueflinge/{id}', 'ResultController@selectGroup');
Route::post('/Pruefer/group_prueflinge/{id}', 'ResultController@show_group');

Route::resource('disciplinesProPruefling' , 'disciplineSelectController');

Route::get('/Kontrolleur/anwesenheit_eintragen', 'persDatenPrueflingController@show_prueflinge_for_kontrolleur');
Route::post('/Kontrolleur/anwesenheit_eintragen{id}', 'persDatenPrueflingController@set_anwesenheit');


//zum Excel-Export
Route::get('lalala/export/{id}', 'UserController@export_pruefer');



