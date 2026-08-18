<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Impersonate;
use App\Http\Controllers\OpenAiController;
use App\Http\Controllers\SiteController;
use App\Livewire\Frontend\BlogDetails;
use App\Livewire\Frontend\Blogs;
use App\Livewire\Frontend\Checkout;
use App\Livewire\Frontend\PaymentCancelled;
use App\Livewire\Frontend\PaymentFailed;
use App\Livewire\Frontend\ThankYou;
use App\Livewire\Pages\Common\ProfileSettings\AccountSettings;
use App\Livewire\Pages\Common\ProfileSettings\PersonalDetails;
use App\Livewire\Pages\Common\ProfileSettings\Resume;
use App\Livewire\Pages\Student\BillingDetail\BillingDetail;
use App\Livewire\Pages\Student\CertificateList;
use App\Livewire\Pages\Student\Favourite\Favourites;
use App\Livewire\Pages\Student\Invoices;
use App\Livewire\Pages\Tutor\ManageAccount\ManageAccount;
use App\Livewire\Payouts;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


Route::get('auth/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
Route::view('language-translator', 'language-translator');
Route::get('/contact-us', [InquiryController::class, 'index'])->name('contact.index');
Route::post('/contact-us/inquiry', [InquiryController::class, 'store'])->name('contact.inquiry');

Route::get('/run-command/{key}/{command}', function (string $key, string $command) {
    if (empty(env('DEPLOY_KEY')) || !hash_equals((string) env('DEPLOY_KEY'), $key)) {
        abort(403);
    }

    $allowedCommands = [
        'storage:link',
        'cache:clear',
        'config:clear',
        'route:clear',
        'view:clear',
        'optimize:clear',
        'migrate',
    ];

    if (!in_array($command, $allowedCommands, true)) {
        abort(403, 'Command not allowed.');
    }

    if ($command === 'storage:link') {
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (file_exists($link) || is_link($link)) {
            return 'Storage link already exists at ' . $link . ' — nothing to do.';
        }

        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
        } catch (\Throwable $e) {
            // ignore, we verify below and fall back if needed
        }

        if (file_exists($link)) {
            return 'Storage linked successfully (symlink) at ' . $link;
        }

        // Some shared hosts disable symlink(); fall back to a recursive copy.
        try {
            File::ensureDirectoryExists($link);
            File::copyDirectory($target, $link);
            return 'Storage linked successfully (copied files, symlink was unavailable on this host) at ' . $link;
        } catch (\Throwable $e) {
            return 'Failed to set up storage link: ' . $e->getMessage();
        }
    }

    try {
        $exitCode = \Illuminate\Support\Facades\Artisan::call($command);
        return "[{$command}] exit code: {$exitCode}\n\n" . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Throwable $e) {
        return "Failed to run [{$command}]: " . $e->getMessage();
    }
});

Route::middleware(['locale', 'maintenance'])->group(function () {
    Route::get('find-tutors', [SearchController::class, 'findTutors'])->name('find-tutors');
    Route::get('/blogs', Blogs::class)->name('blogs');
    Route::get('/blog/{slug}', BlogDetails::class)->name('blog-details');

    Route::middleware(['auth', 'verified', 'onlineUser'])->group(function () {
        Route::post('/openai/submit', [OpenAiController::class, 'submit'])->name('openai.submit');
        Route::post('favourite-tutor', [SearchController::class, 'favouriteTutor'])->name('favourite-tutor');
        Route::get('logout', [SiteController::class, 'logout'])->name('logout');
        Route::post('switch-role', [SiteController::class, 'switchRole'])->name('switch-role');
        Route::get('google/callback', [SiteController::class, 'getGoogleToken']);
        Route::middleware('role:tutor|student')->get('checkout', Checkout::class)->name('checkout');
        Route::middleware('role:tutor|student')->get('thank-you/{id}', ThankYou::class)->name('thank-you');
        Route::middleware('role:tutor|student')->get('payment/failed', PaymentFailed::class)->name('payment.failed');
        Route::middleware('role:tutor|student')->get('payment/cancelled', PaymentCancelled::class)->name('payment.cancelled');

        Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
            Route::get('dashboard', ManageAccount::class)->name('dashboard');
            Route::get('payouts', Payouts::class)->name('payouts');
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings',  AccountSettings::class)->name('account-settings');
                Route::prefix('resume')->name('resume.')->group(function () {
                    Route::get('education', Resume::class)->name('education');
                    Route::get('experience', Resume::class)->name('experience');
                    Route::get('certificate', Resume::class)->name('certificate');
                });
            });
            Route::get('invoices', Invoices::class)->name('invoices');
        });

        Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings',  AccountSettings::class)->name('account-settings');
            });
            Route::get('invoices', Invoices::class)->name('invoices');
            Route::get('billing-detail', BillingDetail::class)->name('billing-detail');
            Route::get('favourites', Favourites::class)->name('favourites');
            Route::get('certificates', CertificateList::class)->name('certificate-list');
        });
    });
    
       Route::get('/run-command/{command}', function ($command) {
    Artisan::call($command);
    return Artisan::output();
})->name('run-command.dynamic');
    
    Route::post('/remove-cart', [SiteController::class, 'removeCart']);

    Route::get('tutor/{slug}', [SearchController::class, 'tutorDetail'])->name('tutor-detail');
    Route::get('{gateway}/process/payment', [SiteController::class, 'processPayment'])->name('payment.process');
    Route::get('checkout/cancel',            fn() => redirect()->route('invoices')->with('payment_cancel', __('general.payment_cancelled_desc')))->name('checkout.cancel');
    Route::post('payfast/webhook',          [SiteController::class, 'payfastWebhook'])->name('payfast.webhook');
    Route::post('sslcommerz/ipn',           [SiteController::class, 'sslcommerzIpn'])->name('sslcommerz.ipn');
    Route::match(['get', 'post'], 'sslcommerz/fail', [SiteController::class, 'sslcommerzFail'])->name('sslcommerz.fail');
    Route::match(['get', 'post'], 'sslcommerz/cancel', [SiteController::class, 'sslcommerzCancel'])->name('sslcommerz.cancel');
    Route::post('payment/success',          [SiteController::class, 'paymentSuccess'])->name('post.success');
    Route::get('payment/success',           [SiteController::class, 'paymentSuccess'])->name('get.success');
    Route::post('switch-lang',              [SiteController::class, 'switchLang'])->name('switch-lang');
    Route::post('switch-currency',          [SiteController::class, 'switchCurrency'])->name('switch-currency');
    Route::get('exit-impersonate',          [Impersonate::class, 'exitImpersonate'])->name('exit-impersonate');
    Route::get('pay/{id}',                  [SiteController::class, 'preparePayment'])->name('pay');

    require __DIR__ . '/auth.php';
    require __DIR__ . '/admin.php';
    require __DIR__ . '/optionbuilder.php';
    if (!request()->is('api/*')) {
        require __DIR__ . '/pagebuilder.php';
    }
});
