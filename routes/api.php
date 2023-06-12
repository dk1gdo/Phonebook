<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TypePhonesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResources([
    'typePhones' => TypePhonesController::class,
    'organization' => OrganizationController::class,
    'subscriber' => SubscriberController::class,
    'phone' => PhoneController::class,
]);

Route::get('/search/{str}', SearchController::class);
