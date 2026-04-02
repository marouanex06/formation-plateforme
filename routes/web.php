<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\FormationController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\ContactController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FormationAdminController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Participant\ParticipantController;
use App\Models\Formation;

Route::bind('formation', function (string $value) {
    return Formation::where('slug_fr', $value)
        ->orWhere('slug_en', $value)
        ->orWhere('id', $value)
        ->firstOrFail();
});

Route::get('/lang/{lang}', function (string $lang) {
    if ($lang === 'eng') {
        $lang = 'en';
    }

    if (!in_array($lang, ['fr', 'en'])) {
        abort(404);
    }

    app()->setLocale($lang);
    session(['locale' => $lang]);

    $previous = url()->previous();
    $path = parse_url($previous, PHP_URL_PATH) ?? '/';
    $query = parse_url($previous, PHP_URL_QUERY);
    $segments = array_values(array_filter(explode('/', trim($path, '/'))));

    if (isset($segments[0]) && in_array($segments[0], ['fr', 'en'])) {
        $segments[0] = $lang;
        $newPath = '/' . implode('/', $segments);
        $newUrl = $query ? $newPath . '?' . $query : $newPath;
        return redirect($newUrl);
    }

    return redirect('/' . $lang);
})->name('lang.switch');

Route::prefix('{lang}')
    ->where(['lang' => 'fr|en'])
    ->middleware(['set.language'])
    ->group(function () {

    Route::get('/',                  [HomeController::class, 'index'])->name('home');
    Route::get('/formations',        [FormationController::class, 'index'])->name('formations.index');
    Route::get('/formations/{slug}', [FormationController::class, 'show'])->name('formations.show');
    Route::get('/blog',              [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}',       [BlogController::class, 'show'])->name('blog.show');
    Route::get('/contact',           [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact',          [ContactController::class, 'store'])->name('contact.store');

    Route::middleware('guest')->group(function () {
        Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);

        Route::get('/password/forgot',       [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/password/email',        [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/password/reset/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/password/reset',        [NewPasswordController::class, 'store'])->name('password.update');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

Route::prefix('admin')
    ->middleware(['auth', 'check.active', 'set.language', 'track.activity', 'role:super-admin|admin'])
    ->name('admin.')
    ->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::patch('users/{user}/assign-role',   [UserController::class, 'assignRole'])->name('users.assign-role');

    Route::resource('categories', CategoryController::class);

    Route::resource('formations', FormationAdminController::class);
    Route::patch('formations/{formation}/publish', [FormationAdminController::class, 'publish'])->name('formations.publish');

    Route::resource('sessions', TrainingSessionController::class);

    Route::resource('inscriptions', InscriptionController::class)->only(['index', 'show', 'destroy']);
    Route::patch('inscriptions/{inscription}/confirm', [InscriptionController::class, 'confirm'])->name('inscriptions.confirm');
    Route::patch('inscriptions/{inscription}/cancel',  [InscriptionController::class, 'cancel'])->name('inscriptions.cancel');

    Route::resource('blogs', BlogAdminController::class);

    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::patch('messages/{message}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('messages.mark-read');

});

Route::prefix('participant')
    ->middleware(['auth', 'check.active', 'set.language'])
    ->name('participant.')
    ->group(function () {

    Route::get('/dashboard',                    [ParticipantController::class, 'dashboard'])->name('dashboard');
    Route::get('/formations',                   [ParticipantController::class, 'formations'])->name('formations');
    Route::get('/formations/{formation}',       [ParticipantController::class, 'showFormation'])->name('formations.show');
    Route::post('/sessions/{session}/inscrire', [ParticipantController::class, 'inscrire'])->name('inscrire');
    Route::patch('/inscriptions/{inscription}/annuler', [ParticipantController::class, 'annuler'])->name('annuler');
});
