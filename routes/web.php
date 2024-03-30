<?php

use App\Http\Controllers\Admin\AdditionController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerDetailController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OffenseController;
use App\Http\Controllers\Admin\PacketTagController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentDetailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Storage;
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

Route::get('/register',function (){
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('/', [SiteController::class, 'home'])->name('home');

//Route::view('/login', 'auth.login')->name('login_form');

Route::get('update-photo',function (){
    return redirect(route('admin.profile.show'));
})->name('profile.show');
//[ 'middleware' => [],'prefix'=>'admin' ]
//Route::name('admin.')->middleware(['auth:sanctum', 'verified'])->prefix('admin/')->group(function() {
Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum','web', 'verified'])->group(function() {
    Route::post('/summernote-upload',[SupportController::class,'upload'])->name('summernote_upload');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/technician/user_uptime', [TechnicianController::class, 'index'])->name('technician');
    Route::get('/technician/user_uptime/{sn}', [TechnicianController::class, 'index_check']);
    Route::get('/technician/olt_user_offline', [TechnicianController::class, 'olt_user_offline'])->name('olt_user_offline');
    Route::get('/invoices/{customerId}', [InvoiceController::class, 'generatePDF'])->name('invoice');
    Route::get('/payment/{customerId}', [InvoiceController::class, 'payment'])->name('payment');
    Route::middleware(['checkRole:1,2'])->group(function () {
        Route::resource('member', MemberController::class);
    });
    Route::resource('customer', CustomerController::class);
    Route::get('/customer/detail/index/{customerId}', [CustomerDetailController::class, 'customer_detail'])->name('customer_detail');
    Route::get('/invoice/index/{customerId}', [InvoiceController::class, 'index_with_id'])->name('index_with_id');
    Route::get('/payment/index/{customerId}', [PaymentController::class, 'payment_index_with_id'])->name('payment_index_with_id');
    Route::get('/invoice/create/{customerId}', [InvoiceController::class, 'create_with_id'])->name('create_with_id');
    Route::get('/payment/create/{customerId}', [PaymentController::class, 'payment_create_with_id'])->name('payment_create_with_id');
    Route::get('/generate-invoice/{invoiceId}', [InvoiceController::class, 'generate_invoice'])->name('generate_invoice');
    Route::get('/generate-payment/{paymentId}', [PaymentController::class, 'generate_payment'])->name('generate_payment');
    Route::resource('invoice', InvoiceController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('packet-tag', PacketTagController::class);
    Route::resource('log', LogController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('technician', TechnicianController::class);
//    Route::resource('exportToTxt', ExportController::class);
    Route::get('/log/export', [ExportController::class, 'exportToTxt'])->name('exportToTxt');
//    Route::middleware(['checkRole:1']){}
    Route::middleware(['checkRole:1'])->group(function () {
        Route::get('/user', [UserController::class, "index"])->name('user');
        Route::view('/user/new', "pages.user.create")->name('user.new');
        Route::view('/user/edit/{userId}', "pages.user.edit")->name('user.edit');
    });


    Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
        Route::group(['middleware' => ['auth', 'verified']], function () {
            // User & Profile...
            Route::get('/user/profile', [UserProfileController::class, 'show'])
                ->name('profile.show');

            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Teams...
            if (Jetstream::hasTeamFeatures()) {
                Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
            }
        });
    });

});
