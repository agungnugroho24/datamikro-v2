<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackgroundProccess;
use App\Http\Controllers\Auth\LoginSSOController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\DtController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ChartJsController;

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

// route default
// Route::get('/', function () {
// 	return view('pages.home');
// });

Route::middleware(['auth', 'CheckPermission'])->group(function () {
	Route::get('/', [FrontController::class, 'home'])->name('/');
	Route::get('home', [FrontController::class, 'home'])->name('home');

	Route::get('riwayat', [FrontController::class, 'riwayat']);
	Route::get('laporandata', [FrontController::class, 'laporandata']);
	Route::get('log', [FrontController::class, 'log']);
	Route::get('logdata', [FrontController::class, 'logdata']);
	Route::get('uke', [FrontController::class, 'uke']);
	Route::get('listdatadasar', [FrontController::class, 'listdatadasar']);
	Route::get('custom', [FrontController::class, 'custom']);

	#user	
	Route::get('user', [UserController::class, 'user'])->name('user');
	Route::get('fuser/edit/{user:username}', [UserController::class, 'fuser'])->name('user.edit');
	Route::post('fuser/edit/{user:username}', [UserController::class, 'editUser'])->name('user.edit')->middleware(['logdata']);
	Route::get('user/search', [UserController::class, 'search'])->name('user.search');
	Route::post('user/delete/{users:id}', [UserController::class, 'delete'])->name('user.delete');
	Route::post('user/destroy',[UserController::class, 'destroy'])->name('user.destroy');

	#sumber
	Route::get('source', [SourceController::class, 'index'])->name('source');
    Route::get('source/create', [SourceController::class, 'create']);
    Route::post('source/store', [SourceController::class, 'store'])->name('source.store')->middleware(['logdata']);
    Route::get('source/edit/{source:slug}', [SourceController::class, 'edit'])->name('source.edit');
    Route::post('source/edit/{source:slug}', [SourceController::class, 'update'])->name('source.edit')->middleware(['logdata']);
	Route::get('source/checkSlug',[SourceController::class, 'checkSlug'])->name('checkSlug');
    Route::post('source/destroy',[SourceController::class, 'destroy'])->name('source.destroy')->middleware(['logdata']);
	Route::get('source/search', [SourceController::class, 'search'])->name('source.search');

    #role
	Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::get('role/create', [RoleController::class, 'create']);
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role/edit/{role:name}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('role/edit/{role:name}', [RoleController::class, 'update'])->name('role.edit');
    Route::post('role/destroy',[RoleController::class, 'destroy'])->name('role.destroy');

	#resource
	Route::get('resource', [ResourceController::class, 'index'])->name('resource');
	Route::get('resource/add', [ResourceController::class, 'create']);
	Route::get('resource/edit', [ResourceController::class, 'edit']);
    Route::post('resource/store', [ResourceController::class, 'store'])->name('resource.store');
    Route::get('resource/edit/{permission:name}', [ResourceController::class, 'edit'])->name('resource.edit');
    Route::post('resource/edit/{permission:name}', [ResourceController::class, 'update'])->name('resource.edit');
    Route::post('resource/destroy',[ResourceController::class, 'destroy'])->name('resource.destroy');
	Route::get('resource/search', [ResourceController::class, 'search']);
	Route::post('resource/delete/{permission:id}', [ResourceController::class, 'delete'])->name('resource.delete');

    #rule
	Route::get('rule', [RuleController::class, 'index'])->name('rule');
	Route::get('rule/add', [RuleController::class, 'create']);
	Route::get('rule/edit', [RuleController::class, 'edit']);
    Route::post('rule/store', [RuleController::class, 'store'])->name('rule.store');
    Route::get('rule/edit/{role:name}', [RuleController::class, 'edit'])->name('rule.edit');
    Route::post('rule/edit/{role:name}', [RuleController::class, 'update'])->name('rule.edit');

    #kategori
	// Route::get('category', [CategoryController::class, 'index']);    
	Route::get('category/add', [CategoryController::class, 'create']);
	Route::get('category/edit', [CategoryController::class, 'edit']);
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store')->middleware(['logdata']);
    Route::get('category/edit/{category:slug}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/edit/{category:slug}', [CategoryController::class, 'update'])->name('category.edit')->middleware(['logdata']);
	Route::get('category/checkSlug',[CategoryController::class, 'checkSlug'])->name('checkSlug');
    Route::post('category/destroy',[CategoryController::class, 'destroy'])->name('category.destroy')->middleware(['logdata']);
    Route::post('category/upload',[CategoryController::class, 'uploadFile'])->name('category.upload');
    Route::post('category/deletefile',[CategoryController::class, 'deletefile'])->name('category.deletefile');
	Route::get('category/under',[CategoryController::class, 'undercons'])->name('underconstruction');

    #datadasar
	Route::get('datadasar', [FrontController::class, 'datadasar'])->name('datadasar');
	Route::get('detail/{category:slug}', [FrontController::class, 'detail'])->name('detail');

	#cart
    Route::post('cart',[FrontController::class, 'cart'])->name('cart');	
	Route::get('track', [FrontController::class, 'track']);
	Route::get('track/{uuid}', [FrontController::class, 'tracking'])->name('tracking');
	Route::get('step1', [FrontController::class, 'step1'])->name('step1');
	Route::get('step2', [FrontController::class, 'step2'])->name('step2');
	Route::get('step3', [FrontController::class, 'step3'])->name('step3');
	Route::get('step4', [FrontController::class, 'step4'])->name('step4');
	Route::get('step5', [FrontController::class, 'step5'])->name('step5');
	Route::post('requestData', [FrontController::class, 'requestData'])->name('requestData');
	Route::get('securedownload/{token}', [FrontController::class, 'download'])->name('securedownload');
    Route::post('cart/upload',[FrontController::class, 'uploadFile'])->name('cart.upload');
    Route::post('cart/deletefile',[FrontController::class, 'deletefile'])->name('cart.deletefile');
	Route::get('downloadhasil/{id}', [FrontController::class, 'downloadHasil'])->name('downloadhasil');
	Route::post('expired', [FrontController::class, 'expired'])->name('expired');

	#list data tersedia
	Route::get('listtersedia', [FrontController::class, 'listtersedia'])->name('listtersedia');
	Route::get('accept/{uuid}', [FrontController::class, 'accept']);	
	Route::post('status', [FrontController::class, 'status'])->name('status');	
	Route::get('complete/{uuid}', [FrontController::class, 'complete']);	
	Route::get('listtersedia/dt', [FrontController::class, 'dtlisttersedia'])->name('listtersedia.dt');
	Route::get('laduType', [FrontController::class, 'laduType'])->name('laduType');

	#data belum tersedia
	Route::get('listblmtersedia', [FrontController::class, 'listblmtersedia'])->name('listblmtersedia');
	Route::post('addData', [FrontController::class, 'addData'])->name('addData');	
	Route::post('requestOther', [FrontController::class, 'requestOther'])->name('requestOther');
    Route::post('delOther',[FrontController::class, 'delOther'])->name('delOther');	
    Route::post('statusOther',[FrontController::class, 'statusOther'])->name('statusOther');
    Route::post('suratOther',[FrontController::class, 'suratOther'])->name('suratOther');	
	Route::get('downloadsurat/{id}', [FrontController::class, 'downloadSurat'])->name('downloadsurat');
	Route::get('listblmtersedia/dt', [FrontController::class, 'dtlistblmtersedia'])->name('listblmtersedia.dt');
	Route::post('hapus', [FrontController::class, 'deleteNot'])->name('hapus');	
	Route::get('riwayatother', [FrontController::class, 'riwayatother'])->name('riwayatother');	

	#laporan user
	Route::get('laporanuser', [FrontController::class, 'laporanuser']);

	#export
	Route::get('ladu/{uuid}', [ExportController::class, 'ladu'])->name('ladu');	
	Route::get('laduIgt/{uuid}', [ExportController::class, 'laduIgt'])->name('laduigt');	
	Route::get('memo/{uuid}', [ExportController::class, 'memo'])->name('memo');	
	Route::get('nolrupiah/{id}', [ExportController::class, 'nolrupiah'])->name('nolrupiah');	
	Route::post('lampiran', [ExportController::class, 'lampiran'])->name('lampiran');	

	#search
	Route::get('data/search', [SearchController::class, 'search']);

	#email
	Route::get('email', [EmailController::class, 'index'])->name('email');
	Route::get('email/search', [EmailController::class, 'search'])->name('email.search');
	Route::get('email/selectSearch', [EmailController::class, 'selectSearch'])->name('email.autocomplete');
	Route::post('email/softDel/{id}', [EmailController::class, 'softDel'])->name('email.softDel');
	Route::post('email/updateUser', [EmailController::class, 'updateUser'])->name('email.updateUser');
	Route::get('email/send', [EmailController::class, 'sendmail']);
	Route::get('email/send2', [EmailController::class, 'sendmail2']);
	// Route::get('sendmail', function () {
	// 	$details = [
	// 		'title' => 'Mail from Pusdatin',
	// 		'body' => 'This is for testing email using smtp'
	// 	];
	// 	\Mail::to('agung.nugroho@support.bappenas.go.id')->send(new \App\Mail\SendMail($details));
	// 	dd("Email is Sent.");
	// });

	#link download
	Route::get('link', [LinkController::class, 'index'])->name('link');

	#log
	Route::get('log/dt', [DtController::class, 'search'])->name('log.dt');
	Route::get('home2', [DtController::class, 'home2'])->name('home2');

	#chart
	Route::get('chartjs', [ChartJsController::class, 'index'])->name('chartjs.index');
});

Route::get('unitkerja', [BackgroundProccess::class, 'unitkerja']);
Route::get('jabatan', [BackgroundProccess::class, 'jabatan']);
Route::get('datarenbang', [BackgroundProccess::class, 'datarenbang']);

Route::get('/login', [App\Http\Controllers\Auth\LoginSSOController::class, 'login'])->name('login')->middleware(['logdata']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginSSOController::class, 'logout'])->name('logout');