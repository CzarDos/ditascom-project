<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SubAdminMiddleware;
use App\Http\Middleware\ParishionerMiddleware;
use App\Http\Controllers\SubAdmin\EventController;
use App\Http\Controllers\SubAdmin\CertificateController;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdministrator()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSubAdministrator()) {
            return redirect()->route('subadmin.dashboard');
        } else {
            return redirect()->route('parishioner.dashboard');
        }
    }
    return view('index');
});

Route::get('/index', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdministrator()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSubAdministrator()) {
            return redirect()->route('subadmin.dashboard');
        } else {
            return redirect()->route('parishioner.dashboard');
        }
    }
    return view('index');
})->name('index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// PayMongo Webhook (must be outside auth middleware)
Route::post('/paymongo/webhook', [\App\Http\Controllers\PayMongoWebhookController::class, 'handle'])->name('paymongo.webhook');



// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Administrator Routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'dashboard'])->name('admin.dashboard');

        // Sub-admin Management Routes
        Route::resource('admin/subadmins', SubAdminController::class, [
            'names' => [
                'index' => 'admin.subadmins.index',
                'create' => 'admin.subadmins.create',
                'store' => 'admin.subadmins.store',
                'edit' => 'admin.subadmins.edit',
                'update' => 'admin.subadmins.update',
                'destroy' => 'admin.subadmins.destroy',
            ]
        ]);

        // Certificate Requests Page
        Route::get('/admin/certificate-requests', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'index'])->name('admin.certificate-requests.index');
        Route::get('/admin/certificate-requests/{id}', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'show'])->name('admin.certificate-requests.show');
        Route::post('/admin/certificate-requests/{id}/approve', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'approve'])->name('admin.certificate-requests.approve');
        Route::post('/admin/certificate-requests/{id}/decline', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'decline'])->name('admin.certificate-requests.decline');
        Route::post('/admin/certificate-requests/{id}/processing', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'markProcessing'])->name('admin.certificate-requests.processing');
        Route::post('/admin/certificate-requests/{id}/upload', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'uploadCertificate'])->name('admin.certificate-requests.upload');
        Route::post('/admin/certificate-requests/{id}/complete', [\App\Http\Controllers\Admin\CertificateRequestController::class, 'markCompleted'])->name('admin.certificate-requests.complete');
        
        // Certificate Generator
        Route::get('/admin/certificate-generator/{id}/select', [\App\Http\Controllers\Admin\CertificateGeneratorController::class, 'selectCertificate'])->name('admin.certificate-generator.select');
        Route::post('/admin/certificate-generator/{id}/generate', [\App\Http\Controllers\Admin\CertificateGeneratorController::class, 'generateCertificate'])->name('admin.certificate-generator.generate');

        // Minister Management Routes
        Route::resource('admin/ministers', \App\Http\Controllers\Admin\MinisterController::class, [
            'names' => [
                'index' => 'admin.ministers.index',
                'create' => 'admin.ministers.create',
                'store' => 'admin.ministers.store',
                'edit' => 'admin.ministers.edit',
                'update' => 'admin.ministers.update',
                'destroy' => 'admin.ministers.destroy',
            ]
        ]);

        // Certificate Pages for Admin
        Route::get('/admin/certificates/baptism', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'baptism'])->name('admin.certificates.baptism');
        Route::get('/admin/certificates/confirmation', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'confirmation'])->name('admin.certificates.confirmation');
        Route::get('/admin/certificates/death', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'death'])->name('admin.certificates.death');
        Route::get('/admin/certificates/baptism/{id}/download', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'downloadBaptismalCertificate'])->name('admin.certificates.baptism.download');
        Route::get('/admin/certificates/confirmation/{id}/download', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'downloadConfirmationCertificate'])->name('admin.certificates.confirmation.download');
        Route::get('/admin/certificates/death/{id}/download', [\App\Http\Controllers\Admin\AdminCertificateController::class, 'downloadDeathCertificate'])->name('admin.certificates.death.download');

        Route::get('/admin/generate_certificate', function () {
            return view('admin.generate_certificate');
        });
    });

    // Sub-administrator Routes
    Route::middleware([SubAdminMiddleware::class])->group(function () {
        Route::get('/subadmin/dashboard', [CertificateController::class, 'dashboard'])->name('subadmin.dashboard');

        Route::get('/subadmin/events', [EventController::class, 'index'])->name('subadmin.events');
        Route::get('/subadmin/certificates/add/{type}', [CertificateController::class, 'add'])->name('subadmin.certificates.add');
        Route::post('/subadmin/certificates/store/{type}', [CertificateController::class, 'store'])->name('subadmin.certificates.store');
        
        // Baptismal certificate routes
        Route::put('/subadmin/certificates/update/{id}', [CertificateController::class, 'update'])->name('subadmin.certificates.update');
        Route::delete('/subadmin/certificates/delete/{id}', [CertificateController::class, 'delete'])->name('subadmin.certificates.delete');
        
        // Death certificate routes
        Route::put('/subadmin/certificates/update-death/{id}', [CertificateController::class, 'updateDeath'])->name('subadmin.certificates.update-death');
        Route::delete('/subadmin/certificates/delete-death/{id}', [CertificateController::class, 'deleteDeath'])->name('subadmin.certificates.delete-death');
        
        // Confirmation certificate routes
        Route::put('/subadmin/certificates/update-confirmation/{id}', [CertificateController::class, 'updateConfirmation'])->name('subadmin.certificates.update-confirmation');
        Route::delete('/subadmin/certificates/delete-confirmation/{id}', [CertificateController::class, 'deleteConfirmation'])->name('subadmin.certificates.delete-confirmation');
        
        // Certificate download routes for subadmin
        Route::post('/subadmin/certificates/baptism/{id}/download', [CertificateController::class, 'downloadBaptismalCertificate'])->name('subadmin.certificates.baptism.download');
        Route::post('/subadmin/certificates/confirmation/{id}/download', [CertificateController::class, 'downloadConfirmationCertificate'])->name('subadmin.certificates.confirmation.download');
        Route::post('/subadmin/certificates/death/{id}/download', [CertificateController::class, 'downloadDeathCertificate'])->name('subadmin.certificates.death.download');
        
        Route::get('/subadmin/certificates/list', [CertificateController::class, 'list'])->name('subadmin.certificates.list');
    });

    // Parishioner Routes
    Route::middleware([ParishionerMiddleware::class])->group(function () {
        Route::get('/parishioner/dashboard', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'dashboard'])->name('parishioner.dashboard');

        Route::get('/parishioner/request/new', function () {
            return view('parishioner.request-new');
        });
        Route::post('/parishioner/request', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'store'])->name('parishioner.certificate-request.store');
        Route::get('/parishioner/request/payment/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'showPayment'])->name('parishioner.certificate-request.payment');
        Route::get('/parishioner/request/payment-success/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'paymentSuccess'])->name('parishioner.certificate-request.payment-success');
        Route::post('/parishioner/request/pay/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'pay'])->name('parishioner.certificate-request.pay');
        Route::delete('/parishioner/request/cancel/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'cancel'])->name('parishioner.certificate-request.cancel');
        Route::get('/parishioner/request/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'show'])->name('parishioner.certificate-request.show');
        Route::post('/parishioner/request/{id}/update', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'update'])->name('parishioner.certificate-request.update');
        Route::delete('/parishioner/request/{id}', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'destroy'])->name('parishioner.certificate-request.destroy');
        Route::get('/parishioner/request/{id}/download', [App\Http\Controllers\Parishioner\CertificateRequestController::class, 'download'])->name('parishioner.certificate-request.download');
        
        // Certificate Downloads
        Route::get('/parishioner/certificates', [\App\Http\Controllers\Parishioner\CertificateDownloadController::class, 'index'])->name('parishioner.certificates.index');
        Route::get('/parishioner/certificates/{id}', [\App\Http\Controllers\Parishioner\CertificateDownloadController::class, 'show'])->name('parishioner.certificates.show');
        Route::get('/parishioner/certificates/{id}/download', [\App\Http\Controllers\Parishioner\CertificateDownloadController::class, 'download'])->name('parishioner.certificates.download');
    });
});


