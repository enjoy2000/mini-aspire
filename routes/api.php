<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user()->toJson();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResources([
        'loans' => 'LoanController',
        'repayments' => 'RepaymentController',
    ]);  // TODO add scopes
    Route::post('loans/{id}/pay', 'LoanController@pay');
});
