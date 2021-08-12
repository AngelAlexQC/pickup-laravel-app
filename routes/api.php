<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TeamUsersController;
use App\Http\Controllers\Api\UserTeamsController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\TicketItemsController;
use App\Http\Controllers\Api\TicketRoadsController;
use App\Http\Controllers\Api\UserTicketsController;
use App\Http\Controllers\Api\RoadTicketsController;
use App\Http\Controllers\Api\UserVehiclesController;
use App\Http\Controllers\Api\AddressRoadsController;
use App\Http\Controllers\Api\RoadAddressesController;
use App\Http\Controllers\Api\CategoryCategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('tickets', TicketController::class);

        // Ticket Items
        Route::get('/tickets/{ticket}/items', [
            TicketItemsController::class,
            'index',
        ])->name('tickets.items.index');
        Route::post('/tickets/{ticket}/items', [
            TicketItemsController::class,
            'store',
        ])->name('tickets.items.store');

        // Ticket Roads
        Route::get('/tickets/{ticket}/roads', [
            TicketRoadsController::class,
            'index',
        ])->name('tickets.roads.index');
        Route::post('/tickets/{ticket}/roads/{road}', [
            TicketRoadsController::class,
            'store',
        ])->name('tickets.roads.store');
        Route::delete('/tickets/{ticket}/roads/{road}', [
            TicketRoadsController::class,
            'destroy',
        ])->name('tickets.roads.destroy');

        Route::apiResource('items', ItemController::class);

        Route::apiResource('teams', TeamController::class);

        // Team Member
        Route::get('/teams/{team}/users', [
            TeamUsersController::class,
            'index',
        ])->name('teams.users.index');
        Route::post('/teams/{team}/users/{user}', [
            TeamUsersController::class,
            'store',
        ])->name('teams.users.store');
        Route::delete('/teams/{team}/users/{user}', [
            TeamUsersController::class,
            'destroy',
        ])->name('teams.users.destroy');

        Route::apiResource('categories', CategoryController::class);

        // Category Childrem Categories
        Route::get('/categories/{category}/categories', [
            CategoryCategoriesController::class,
            'index',
        ])->name('categories.categories.index');
        Route::post('/categories/{category}/categories', [
            CategoryCategoriesController::class,
            'store',
        ])->name('categories.categories.store');

        Route::apiResource('users', UserController::class);

        // User My Teams
        Route::get('/users/{user}/teams', [
            UserTeamsController::class,
            'index',
        ])->name('users.teams.index');
        Route::post('/users/{user}/teams', [
            UserTeamsController::class,
            'store',
        ])->name('users.teams.store');

        // User Tickets Recivied
        Route::get('/users/{user}/tickets', [
            UserTicketsController::class,
            'index',
        ])->name('users.tickets.index');
        Route::post('/users/{user}/tickets', [
            UserTicketsController::class,
            'store',
        ])->name('users.tickets.store');

        // User Tickets Sended
        Route::get('/users/{user}/tickets', [
            UserTicketsController::class,
            'index',
        ])->name('users.tickets.index');
        Route::post('/users/{user}/tickets', [
            UserTicketsController::class,
            'store',
        ])->name('users.tickets.store');

        // User Tickets
        Route::get('/users/{user}/tickets', [
            UserTicketsController::class,
            'index',
        ])->name('users.tickets.index');
        Route::post('/users/{user}/tickets', [
            UserTicketsController::class,
            'store',
        ])->name('users.tickets.store');

        // User Vehicles
        Route::get('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'index',
        ])->name('users.vehicles.index');
        Route::post('/users/{user}/vehicles/{vehicle}', [
            UserVehiclesController::class,
            'store',
        ])->name('users.vehicles.store');
        Route::delete('/users/{user}/vehicles/{vehicle}', [
            UserVehiclesController::class,
            'destroy',
        ])->name('users.vehicles.destroy');

        // User Teams
        Route::get('/users/{user}/teams', [
            UserTeamsController::class,
            'index',
        ])->name('users.teams.index');
        Route::post('/users/{user}/teams/{team}', [
            UserTeamsController::class,
            'store',
        ])->name('users.teams.store');
        Route::delete('/users/{user}/teams/{team}', [
            UserTeamsController::class,
            'destroy',
        ])->name('users.teams.destroy');

        Route::apiResource('comments', CommentController::class);

        Route::apiResource('roads', RoadController::class);

        // Road Waypoints
        Route::get('/roads/{road}/addresses', [
            RoadAddressesController::class,
            'index',
        ])->name('roads.addresses.index');
        Route::post('/roads/{road}/addresses', [
            RoadAddressesController::class,
            'store',
        ])->name('roads.addresses.store');

        // Road All Tracks
        Route::get('/roads/{road}/tickets', [
            RoadTicketsController::class,
            'index',
        ])->name('roads.tickets.index');
        Route::post('/roads/{road}/tickets/{ticket}', [
            RoadTicketsController::class,
            'store',
        ])->name('roads.tickets.store');
        Route::delete('/roads/{road}/tickets/{ticket}', [
            RoadTicketsController::class,
            'destroy',
        ])->name('roads.tickets.destroy');

        Route::apiResource('addresses', AddressController::class);

        // Address Start Address Of
        Route::get('/addresses/{address}/roads', [
            AddressRoadsController::class,
            'index',
        ])->name('addresses.roads.index');
        Route::post('/addresses/{address}/roads', [
            AddressRoadsController::class,
            'store',
        ])->name('addresses.roads.store');

        // Address End Address Of
        Route::get('/addresses/{address}/roads', [
            AddressRoadsController::class,
            'index',
        ])->name('addresses.roads.index');
        Route::post('/addresses/{address}/roads', [
            AddressRoadsController::class,
            'store',
        ])->name('addresses.roads.store');
    });
