<?php
// routes/api.php
// API REST — publique + protégée par Sanctum

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\FormationApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\InscriptionApiController;
use App\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| API PUBLIQUE — pas d'authentification requise
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    // Liste des formations publiées
    Route::get('/formations',        [FormationApiController::class, 'index']);
    // Détail d'une formation par slug
    Route::get('/formations/{slug}', [FormationApiController::class, 'showBySlug']);
    // Liste des catégories
    Route::get('/categories',        [CategoryApiController::class, 'index']);

    // Connexion → retourne un token Sanctum
    Route::post('/auth/login',       [AuthApiController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| API PROTÉGÉE — authentification Sanctum obligatoire
|--------------------------------------------------------------------------
*/
Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {

    // Déconnexion (révoque le token)
    Route::post('/auth/logout',          [AuthApiController::class, 'logout']);

    // Profil de l'utilisateur connecté
    Route::get('/profile',               [UserApiController::class, 'profile']);

    // Inscriptions du participant connecté
    Route::get('/my-inscriptions',       [InscriptionApiController::class, 'myInscriptions']);
    // Créer une inscription
    Route::post('/inscriptions',         [InscriptionApiController::class, 'store']);
});