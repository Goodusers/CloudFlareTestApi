<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;    
use App\Http\Controllers\DomainController;
use App\Http\Controllers\PageRuleController;
use App\Http\Controllers\CloudflareAccountController;
use App\Models\CloudflareAccount;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/domains', [DomainController::class, 'page'])->name('page');
    // Route::post('/domains', [DomainController::class, 'store'])->name('store');
    // Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('destroy');
    // Route::post('/ssl/{domain}', [DomainController::class, 'updateSSL'])->name('updateSSL');
    // Route::get('/page-rules', [PageRuleController::class, 'index'])->name('page-rules.index');
    // Route::post('/page-rules', [PageRuleController::class, 'store'])->name('page-rules.store');
    // Route::delete('/page-rules/{rule}', [PageRuleController::class, 'destroy'])->name('page-rules.destroy');

    Route::get('/accounts', [CloudflareAccountController::class, 'accounts'])->name('accounts'); // Страница с параметрами аккаунта
    Route::post('/add_account', [CloudflareAccountController::class, 'store_account'])->name('store_account'); // Добавление аккаунта
    Route::post('/add_domains', [CloudflareAccountController::class, 'add_domains'])->name('add_domains'); // добавление зоны - домена

    Route::post('/add_member', [DomainController::class, 'add_member'])->name('add_member'); // Добавление участника
    Route::post('/delete_member', [DomainController::class, 'delete_member'])->name('delete_member'); // Удалить участника
});
Route::get('/logout', function() {
    Auth::logout();
    return redirect(route('index'));
})->name('logout');
Route::get('/', [DomainController::class, 'index'])->name('index');
Route::post('/', [DomainController::class, 'signin_form'])->name('signin_form'); // Обработка формы 