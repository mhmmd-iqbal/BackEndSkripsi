<?php

use App\Http\Controllers\AuditFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\InstrumentSubTopicController;
use App\Http\Controllers\InstrumentTopicController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

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
Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    Route::group(['middleware' => 'jwt.verify'], function(){
        Route::group(['prefix' => 'majors'], function() {
            Route::get('/', [MajorController::class, 'index']);
        });

        Route::group(['prefix' => 'periods'], function(){
            Route::get('/', [PeriodController::class, 'index']);
            Route::post('/', [PeriodController::class, 'store']);
            Route::get('/{id}', [PeriodController::class, 'show']);
            Route::put('/{id}', [PeriodController::class, 'update']);
            Route::delete('/{id}', [PeriodController::class, 'destroy']);
        });
                
        Route::group(['prefix' => 'users'], function(){
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);

        });
        
        Route::group(['prefix' => 'profile'], function(){
            Route::get('/', [UserController::class, 'getProfile']);
            Route::put('/', [UserController::class, 'updateProfile']);
        });

        Route::group(['prefix' => 'topics'], function(){
            Route::get('/', [InstrumentTopicController::class, 'index']);
            Route::post('/', [InstrumentTopicController::class, 'store']);
            Route::put('/{id}', [InstrumentTopicController::class, 'update']);
        });

        Route::group(['prefix' => 'sub-topics'], function(){
            Route::get('/{id}', [InstrumentTopicController::class, 'subTopic']);
        });

        Route::group(['prefix' => 'instruments'], function(){
            Route::get('/', [InstrumentController::class, 'index']);
            Route::post('/', [InstrumentController::class, 'store']);
        });

        Route::group(['prefix' => 'departments'], function(){
            Route::get('/', [DepartmentController::class, 'index']);
            Route::post('/', [DepartmentController::class, 'store']);
            Route::get('/{id}', [DepartmentController::class, 'show']);
            Route::put('/{id}', [DepartmentController::class, 'update']);
            Route::delete('/{id}', [DepartmentController::class, 'destroy']);
        });
        
        Route::group(['prefix' => 'audits'], function(){
            Route::get('/rejected', [AuditFormController::class, 'getRejectedAudit']);
            Route::get('/rejected/{id}', [AuditFormController::class, 'RejectedAuditDetail']);
            Route::put('/rejected/{id}', [AuditFormController::class, 'inputActionPlan']);

            Route::get('/', [AuditFormController::class, 'index']);
            Route::post('/', [AuditFormController::class, 'store']);
            Route::get('/{id}', [AuditFormController::class, 'show']);

            Route::post('/{audit_id}/instrument/{instrument_id}/fulfillment', [AuditFormController::class, 'fulfillment']);
            Route::get('/{audit_id}/result', [AuditFormController::class, 'result']);
            Route::put('/{audit_id}/finish/fulfillment', [AuditFormController::class, 'finishFulfillment']);
            Route::put('/{audit_id}/approve', [AuditFormController::class, 'approve']);
        });

        Route::group(['prefix' => 'report'], function(){
            Route::get('/total-data', [ReportController::class, 'totalData']);
            Route::get('/audit-chart', [ReportController::class, 'auditChart']);
        });
    });
});