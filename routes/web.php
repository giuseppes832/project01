<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RowController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\SharedNodeController;
use App\Http\Controllers\SharingController;
use App\Http\Controllers\InviteController;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsOwner;
use App\Http\Middleware\UserIsInvitedUser;

/*
Route::get('/', function () {
    return view('components.dashboard');
});
*/

Route::middleware('auth')->group(function () {
    Route::middleware(UserIsOwner::class)->group(function () {

        // OWNER ROUTES
        Route::get('/apps/owner-app', [AppController::class, 'ownerApp']);

        Route::get('/sharings', [SharingController::class, 'index']);
        Route::post('/sharings', [SharingController::class, 'store']);
        Route::post('/sharings2', [SharingController::class, 'store2']);
        Route::get('/sharings/{sharing}', [SharingController::class, 'edit']);
        Route::put('/sharings/{sharing}', [SharingController::class, 'update']);
        Route::get('/sharings/{sharing}/delete', [SharingController::class, 'delete']);
        Route::put('/sharings2/{sharing}', [SharingController::class, 'update2']);

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'edit']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::get('/users/{user}/delete', [UserController::class, 'delete']);

        Route::get("/owner-account", [UserController::class, "ownerAccount"]);
        Route::put("/owner-account", [UserController::class, "updateOwnerAccount"]);

        Route::get('/apps/owner-app/data', [AppController::class, 'exportData']);
    });
});


Route::middleware('auth')->group(function () {
    Route::middleware(UserIsAdmin::class)->group(function () {

        // ADMIN ROUTES
        Route::get('/apps/app', [AppController::class, 'adminApp']);
        Route::post('/apps/app', [AppController::class, 'storeApp']);

        Route::get('/resources', [ResourceController::class, 'index']);
        Route::post('/resources', [ResourceController::class, 'store']);
        Route::get('/resources/{resource}', [ResourceController::class, 'edit']);
        Route::put('/resources/{resource}', [ResourceController::class, 'update']);
        Route::get('/resources/{resource}/delete', [ResourceController::class, 'delete']);


        Route::post('/resources/{resource}/fields', [FieldController::class, 'store']);
        Route::get('/fields/{field}', [FieldController::class, 'edit']);
        Route::put('/fields/{field}', [FieldController::class, 'update']);
        Route::put('/fields2/{field}', [FieldController::class, 'updateEnumField']);
        Route::put('/fields3/{field}', [FieldController::class, 'updateFkField']);
        Route::get('/fields/{field}/delete', [FieldController::class, 'delete']);

        Route::post('/resources/template1', [ResourceController::class, 'createTemplate1']);
        Route::post('/resources/template2', [ResourceController::class, 'createTemplate2']);
        Route::post('/resources/template3', [ResourceController::class, 'createTemplate3']);
        Route::post('/resources/{resource}/autocreate-nodes', [ResourceController::class, 'autoCreateNodes']);

        Route::get('/nodes', [NodeController::class, 'index']);
        Route::post('/nodes', [NodeController::class, 'store']);
        Route::get('/nodes/{node}', [NodeController::class, 'edit']);
        Route::put('/nodes/{node}', [NodeController::class, 'update']);
        Route::get('/nodes/{node}/delete', [NodeController::class, 'delete']);
        Route::post('/nodes/{node}', [NodeController::class, 'storeChild']);
        Route::put('/nodes-order/{node}', [NodeController::class, 'updateOrder']);
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
        Route::put('/nodes13/{node}', [NodeController::class, 'updateTextarea']);
        Route::put('/nodes14/{node}', [NodeController::class, 'updateHtmlInputFile']);

        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::get('/roles/{role}', [RoleController::class, 'edit']);
        Route::put('/roles/{role}', [RoleController::class, 'update']);
        Route::get('/roles/{role}/delete', [RoleController::class, 'delete']);
        Route::post('/roles/{role}/nodes/{node}/shared-nodes', [SharedNodeController::class, 'store']);
        Route::put('/shared-nodes/{sharedNode}', [SharedNodeController::class, 'update']);
        Route::get('/shared-nodes/{sharedNode}/delete', [SharedNodeController::class, 'delete']);


        Route::post('/apps/owner-invite', [AppController::class, 'sendOwnerInvite']);

    });

});

Route::middleware('auth')->group(function () {
    Route::get('/render/{node}', [NodeController::class, 'render']);

    Route::post('/nodes/{node}/rows', [RowController::class, 'store']);
    Route::get('/rows/{row}', [RowController::class, 'edit']);
    Route::put('/rows/{row}', [RowController::class, 'update']);
    Route::get('/rows/{row}/delete', [RowController::class, 'delete']);

    Route::get('/render/{node}/ajax', [NodeController::class, 'renderHtmlListBody']);

    Route::get('/rows/{row}/nodes/{node}/file/{index}', [NodeController::class, 'download']);

});



Route::middleware('auth')->group(function () {
    Route::middleware(UserIsInvitedUser::class)->group(function () {

        Route::get("/my-invites", [InviteController::class, 'index'])->name("invites");
        Route::get("/select-sharing/{sharing}", [InviteController::class, "select"])->middleware("can:select,sharing");

        Route::get("/invited-user-account", [UserController::class, "invitedUserAccount"]);
        Route::put("/invited-user-account", [UserController::class, "updateInvitedUserAccount"]);

    });

});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout']);
});










