<?php

use App\Http\Controllers\CampaignController;
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

Route::group(['prefix' => 'campaigns', 'as' => 'campaigns.'], function () {
    Route::get('', [CampaignController::class, 'index'])->name('all');
    Route::post('', [CampaignController::class, 'store'])->name('store');
    Route::patch('/{campaign}', [CampaignController::class, 'update'])->name('update');
});
