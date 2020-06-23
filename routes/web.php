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
	//pajak
	Route::resource('tax', 'TaxController', ['except' => ['show']]);
	//pendapatan kontrak
	Route::resource('contractRevenue', 'ContractRevenueController', ['except' => ['show']]);
	//piutang kontrak
	Route::resource('contractAR', 'ContractARController', ['except' => ['show']]);
	//Pendapatan proyek
	Route::resource('projectRevenue', 'ProjectRevenueController', ['except' => ['show']]);
	//Backup and Recovery
	Route::get('backupRecovery/index', 'backupRecoveryController@index')->name('indexBackupRecovery');
	Route::get('backupRecovery/recover', 'backupRecoveryController@recover')->name('recoverBackupRecovery');
	Route::get('backupRecovery/download', 'backupRecoveryController@download')->name('downloadBackupRecovery');
	//Generate laporan keuangan
	Route::get('financialStatement/index', 'FinancialStatementController@index')->name('financialStatement');
	Route::get('financialStatement/create', 'FinancialStatementController@create')->name('generateStatement');
	//laporan laba rugi
	Route::resource('profitLoss', 'ProfitLossController', ['except' => ['show']]);
	Route::get('profitLoss/print', 'ProfitLossController@print');
	//Generate laporan perubahan ekuitas
	Route::resource('changeEquity', 'ChangeEquityController', ['except' => ['show']]);
	//Generate laporan neraca
	Route::resource('balanceSheet', 'BalanceSheetController', ['except' => ['show']]);
	//Generate laporan arus kas
	Route::resource('cashFlow', 'CashFlowController', ['except' => ['show']]);

});

