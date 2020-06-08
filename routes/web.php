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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	//management user
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::resource('userDir', 'userDirController', ['except' => ['show']]);
	Route::resource('pilihUser', 'pilihUserController', ['except' => ['show']]);
	//management profile
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	//log aktivitas
	Route::get('logActivity', ['as' => 'logActivity.index', 'uses' => 'logActivityController@index']);
	//management customer
	Route::resource('cust', 'CustomerController', ['except' => ['show']]);
	//management kreditur
	Route::resource('cred', 'CreditorController', ['except' => ['show']]);
	//management layanan
	Route::resource('services', 'ServiceController', ['except' => ['show']]);
	//management code of account
	Route::resource('coa', 'CoaController', ['except' => ['show']]);
	//management account group (COA)
	Route::resource('accGroup', 'AccGroupController', ['except' => ['show']]);
	//management proyek
	Route::resource('project', 'ProjectController', ['except' => ['show']]);
	//management transaksi proyek
	Route::resource('projectTransaction', 'projectTransactionController', ['except' => ['show']]);
	//management transaksi lain
	Route::resource('otherTransaction', 'otherTransactionController', ['except' => ['show']]);
	//jurnal umum
	Route::resource('generalLedger', 'generalLedgerController', ['except' => ['show']]);
	//buku besar
	Route::resource('Ledger', 'LedgerController', ['except' => ['show']]);
	//neraca saldo
	Route::resource('trialBalance', 'trialBalanceController', ['except' => ['show']]);
	//utang
	Route::resource('accPayable', 'AccPayableController', ['except' => ['show']]);
	//piutang
	Route::resource('accReceivable', 'AccReceivableController', ['except' => ['show']]);



});

