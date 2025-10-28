<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\OwnerAppController;
use App\Http\Controllers\RegisteredUserAppController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RowController;
use App\Http\Controllers\ColController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\SharedNodeController;
use App\Http\Controllers\SharingController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\OwnerController;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsOwner;
use App\Http\Middleware\UserIsInvitedUser;
use App\Models\Owner;

Route::get('/', function () {
    return view('components.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::middleware(UserIsOwner::class)->group(function () {

        // CUSTOMER ROUTES
        Route::get('/invites', [AppController::class, 'invites']);

        Route::get('/apps/{app}/sharings', [SharingController::class, 'index']);
        Route::post('/apps/{app}/sharings', [SharingController::class, 'store']);
        Route::get('/sharings/{sharing}', [SharingController::class, 'edit']);
        Route::put('/sharings/{sharing}', [SharingController::class, 'update']);
        Route::get('/sharings/{sharing}/delete', [SharingController::class, 'delete']);
        Route::put('/sharings2/{sharing}', [SharingController::class, 'update2']);
    });
});


Route::middleware('auth')->group(function () {
    Route::middleware(UserIsAdmin::class)->group(function () {

        // ADMIN ROUTES
        Route::get('/apps', [AppController::class, 'index']);
        Route::post('/apps', [AppController::class, 'store']);
        Route::get('/apps/{app}', [AppController::class, 'edit']);
        Route::put('/apps/{app}', [AppController::class, 'update']);
        Route::get('/apps/{app}/delete', [AppController::class, 'delete']);

        Route::get('/apps/{app}/resources', [ResourceController::class, 'index']);
        Route::post('/apps/{app}/resources', [ResourceController::class, 'store']);
        Route::get('/resources/{resource}', [ResourceController::class, 'edit']);
        Route::put('/resources/{resource}', [ResourceController::class, 'update']);
        Route::get('/resources/{resource}/delete', [ResourceController::class, 'delete']);

        Route::post('/resources/{resource}/fields', [FieldController::class, 'store']);
        Route::get('/fields/{field}', [FieldController::class, 'edit']);
        Route::put('/fields/{field}', [FieldController::class, 'update']);
        Route::put('/fields2/{field}', [FieldController::class, 'updateEnumField']);
        Route::get('/fields/{field}/delete', [FieldController::class, 'delete']);

        Route::get('/apps/{app}/nodes', [NodeController::class, 'index']);
        Route::post('/apps/{app}/nodes', [NodeController::class, 'store']);
        Route::get('/nodes/{node}', [NodeController::class, 'edit']);
        Route::put('/nodes/{node}', [NodeController::class, 'update']);
        Route::get('/nodes/{node}/delete', [NodeController::class, 'delete']);
        Route::post('/nodes/{node}', [NodeController::class, 'storeChild']);
        Route::put('/nodes2/{node}', [NodeController::class, 'updateInputText']);
        Route::put('/nodes3/{node}', [NodeController::class, 'updateNavLink']);
        Route::put('/nodes4/{node}', [NodeController::class, 'updateHtmlList']);
        Route::put('/nodes5/{node}', [NodeController::class, 'updateSharingSelect']);
        Route::put('/nodes6/{node}', [NodeController::class, 'updateHtmlSelect']);
        Route::put('/nodes7/{node}', [NodeController::class, 'updateHtmlStaticSelect']);
        Route::put('/nodes8/{node}', [NodeController::class, 'updateSublistButton']);
        Route::put('/nodes9/{node}', [NodeController::class, 'updateHtmlCheckbox']);
        Route::put('/nodes10/{node}', [NodeController::class, 'updateHtmlDate']);
        Route::put('/nodes11/{node}', [NodeController::class, 'updateHtmlTime']);
        Route::put('/nodes12/{node}', [NodeController::class, 'updateHtmlDateTime']);

        Route::get('/apps/{app}/roles', [RoleController::class, 'index']);
        Route::post('/apps/{app}/roles', [RoleController::class, 'store']);
        Route::get('/roles/{role}', [RoleController::class, 'edit']);
        Route::put('/roles/{role}', [RoleController::class, 'update']);
        Route::get('/roles/{role}/delete', [RoleController::class, 'delete']);
        Route::post('/roles/{role}/nodes/{node}/shared-nodes', [SharedNodeController::class, 'store']);
        Route::put('/shared-nodes/{sharedNode}', [SharedNodeController::class, 'update']);




    });

});

// Controllare policy
Route::middleware('auth')->group(function () {
    Route::get('/render/{node}', [NodeController::class, 'render']);

    Route::post('/nodes/{node}/rows', [RowController::class, 'store']);
    Route::get('/rows/{row}', [RowController::class, 'edit']);
    Route::put('/rows/{row}', [RowController::class, 'update']);
    Route::get('/rows/{row}/delete', [RowController::class, 'delete']);

    Route::get('/render/{node}/subrows', [NodeController::class, 'subrows']);

});



Route::middleware('auth')->group(function () {
    Route::middleware(UserIsInvitedUser::class)->group(function () {

        Route::get("/my-invites", [InviteController::class, 'index'])->name("invites");
        Route::get("/select-sharing/{sharing}", [InviteController::class, 'select']);

    });

});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('authenticate', [LoginController::class, 'authenticate']);










