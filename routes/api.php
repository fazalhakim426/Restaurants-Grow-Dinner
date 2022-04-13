<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::post('/customer/register', [CustomerController::class, 'store']);
Route::post('/finance', [FinanceController::class, 'store']);
Route::post('/employee', [EmployeeController::class, 'store']);

Route::get('country', [App\Http\Controllers\CountryController::class, 'index']);

Route::post('/login', [AuthenticationController::class, 'login']);


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::post('logout', [AuthenticationController::class, 'logout']);

    Route::apiResource('/category',CategoryController::class);
    Route::apiResource('/setting',SettingController::class);
    //customer
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
    Route::put('/customer/{customer}', [CustomerController::class, 'update'])->middleware('role:Customer');;
    //emplooyee
    Route::get('/employee/{id}', [EmployeeController::class, 'show']);
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);
    Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->middleware('role:Employee');;
    //finance
    Route::get('/finance/{id}', [FinanceController::class, 'show']);
    Route::get('/finance', [FinanceController::class, 'index']);
    Route::delete('/finance/{id}', [FinanceController::class, 'destroy']);
    Route::put('/finance/{finance}', [FinanceController::class, 'update'])->middleware('role:Finance');
    //restaurant  
    // Route::get('/restaurant/{id}',[App\Http\Controllers\RestaurantController::class,'show']);
    // Route::resource('restaurat', RestaurantController::class)->only([
    //     'index', 'store','update','destroy'
    // ]);
    //country  
  

   
 

   
    //table 
    Route::get('/restaurant/{id}/table', [App\Http\Controllers\TableController::class, 'index']);
    Route::post('/table', [App\Http\Controllers\TableController::class, 'store']);
    Route::put('/table/{id}', [App\Http\Controllers\TableController::class, 'update']);
    Route::delete('table/{id}', [App\Http\Controllers\TableController::class, 'destroy']);

    Route::resource('country', CountryController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('city', CityController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::get('/country/{country}/city', [App\Http\Controllers\CityController::class, 'index']);

    Route::resource('department', DepartmentController::class)->only([
        'store', 'destroy'
    ]);
    Route::get('/city/{city}/departments', [App\Http\Controllers\DepartmentController::class, 'index']);

    //admin routes
    Route::group(['middleware' => 'role:Admin'], function () {
        Route::resource('admin-restaurant', Restaurant\AdminRestaurantController::class)->only([
           'index', 'show', 'store', 'update', 'destroy'
     ]);

    });
    Route::group(['middleware' => 'role:Employee'],function(){
        Route::apiResource('employee-restaurant', Restaurant\EmployeeRestaurantController::class)->only([
            'index','store','update','show','destroy'
        ]);
          
    });
    //customer routes

    Route::group(['middleware' => 'role:Customer'], function () {

        Route::resource('address', AddressController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('review', ReviewController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::apiResource('customer-restaurant', Restaurant\CustomerRestaurantController::class)
        ->only(['index']);

        //booked table
        Route::get('/booked-table/free-slots', [App\Http\Controllers\BookedTableController::class, 'index']);
        Route::post('/booked-table', [App\Http\Controllers\BookedTableController::class, 'store']);
        Route::put('/booked-table/{id}', [App\Http\Controllers\BookedTableController::class, 'update']);
        Route::delete('/booked-table/{id}', [App\Http\Controllers\BookedTableController::class, 'destroy']);
    });
});

// Route::group([
//     'namespace' => 'Auth', 
//     'middleware' => 'api',
//     'prefix' => 'password'
// ], function () {

//     Route::get('find/{token}', [ForgotPasswordTempController::class, 'find']);
//     Route::post('reset', [ForgotPasswordTempController::class, 'reset']);
//     Route::post('create', [ForgotPasswordTempController::class, 'create']);
// });

// Route::get('/redirect', function () {
//     $query = http_build_query([
//         'client_id' => 'client-id',
//         'redirect_uri' => 'http://example.com/callback',
//         'response_type' => 'code',
//         'scope' => 'place-orders check-status',
//     ]);
//     return redirect('http://your-app.com/oauth/authorize?' . $query);
// });


Route::post('password/email',  [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index']);
Route::post('password/code/check', [App\Http\Controllers\Auth\CodeCheckController::class, 'index']);
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'index']);
