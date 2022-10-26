<?php

use App\Http\Controllers\CookerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PayCookerBillController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/', '/dashboard', 301);
Route::get('/status', [StatusController::class, 'index'])->name('status');



Auth::routes();


Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/member', MemberController::class);
    Route::get('/fetch/member',[MemberController::class, 'fetch'])->name('member.fetch');
    Route::get('/member/activate/{id}',[MemberController::class, 'activate']);
    Route::get('/member/deactivate/{id}',[MemberController::class, 'deactivate']);
    Route::get('/member/utility/{id}/{type}',[MemberController::class, 'utilityUpdate']);
    Route::get('/member/adjust/{id}/{type}',[MemberController::class, 'adjustUpdate']);
    Route::resource('utility', UtilityController::class);
    Route::get('/fetch/utility',[UtilityController::class, 'fetch'])->name('utility.fetch');
    Route::resource('/cooker', CookerController::class);
    Route::get('/fetch/cook',[CookerController::class, 'fetch'])->name('cooker.fetch');
    Route::resource('pay/cooker/bill', PayCookerBillController::class);
    Route::get('/fetch/pay/cooker/bill',[PayCookerBillController::class, 'fetch'])->name('cooker.pay.fetch');
    Route::get('/setting',[SettingController::class, 'index'])->name('setting');
    Route::post('/setting/update',[SettingController::class, 'update'])->name('setting.update');
    Route::get('/download',[DownloadController::class, 'index'])->name('download');
    Route::post('/download',[DownloadController::class, 'download'])->name('post.download');
});
