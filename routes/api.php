<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StudyProgramController;
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
        Route::group(['prefix' => 'periods'], function(){
            Route::get('/', [PeriodController::class, 'index']);
            Route::post('/', [PeriodController::class, 'store']);
            Route::get('/{id}', [PeriodController::class, 'show']);
            Route::put('/{id}', [PeriodController::class, 'update']);
            Route::delete('/{id}', [PeriodController::class, 'destroy']);
        });
        Route::group(['prefix' => 'study-programs'], function(){
            Route::get('/', [StudyProgramController::class, 'index']);
            Route::post('/', [StudyProgramController::class, 'store']);
            Route::get('/{id}', [StudyProgramController::class, 'show']);
            Route::put('/{id}', [StudyProgramController::class, 'update']);
            Route::delete('/{id}', [StudyProgramController::class, 'destroy']);
        });
        Route::group(['prefix' => 'users'], function(){
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });


    });
});