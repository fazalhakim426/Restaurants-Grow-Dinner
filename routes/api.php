<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('/customer/register', [App\Http\Controllers\CustomerController::class, 'store']);

Route::get('country', [App\Http\Controllers\CountryController::class, 'index']);
Route::get('/country/{country}/city', [App\Http\Controllers\CityController::class, 'index']);
Route::get('/city/{city}/departments', [App\Http\Controllers\DepartmentController::class, 'index']);


Route::post('/login', [AuthenticationController::class, 'login']);

Route::apiResource('/setting', SettingController::class)->only([
    'index'
]); 

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::post('logout', [AuthenticationController::class, 'logout']);

    //admin routes
    Route::group([
        'middleware' => 'role:Admin',
        'prefix' => 'admin'
    ], function () {

    Route::resource('setting', SettingController::class)->only([
        'store','update','destroy'
    ]);

    Route::apiResource('/category', CategoryController::class);


    Route::resource('country', CountryController::class)->only([
        'update', 'destroy','store'
    ]);
    Route::get('/country/{country}/city', [App\Http\Controllers\CityController::class, 'index']);

    Route::resource('city', CityController::class)->only([
        'store', 'update', 'destroy'
    ]);
  
    Route::get('/city/{city}/departments', [App\Http\Controllers\DepartmentController::class, 'index']);
    
    Route::resource('department', DepartmentController::class)->only([
        'store', 'destroy'
    ]);




        Route::apiResource('employee', EmployeeController::class)->only([
            'show', 'index', 'destroy', 'update', 'store'
        ]);



        Route::resource('customer', CustomerController::class)->only([
            'index', 'show', 'update'
        ]);

        Route::resource('finance', FinanceController::class)->only([
            'show', 'index', 'destroy', 'update', 'store'
        ]);

        Route::resource('restaurant', Restaurant\AdminRestaurantController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        //table 
        Route::get('/restaurant/{id}/table', [App\Http\Controllers\TableController::class, 'index']);
        Route::resource('table', TableController::class)->only([
            'store', 'update', 'destroy','index'
        ]);
    });


    //employee routes
    Route::group([
        'middleware' => 'role:Employee'

    ], function () {
        Route::post(
            '/update/employee',
            [
                App\Http\Controllers\EmployeeController::class,
                'update_employee'
            ]
        );

        Route::apiResource('employee', EmployeeController::class)->only([
            'update'
        ]);
        Route::apiResource('employee-restaurant', Restaurant\EmployeeRestaurantController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
    });
    //finance routes 
    Route::group(['middleware' => 'role:Finance'], function () {
        Route::post(
            '/update/finance',
            [
                App\Http\Controllers\FinanceController::class,
                'update_finance'
            ]
        );

        Route::resource('finance', FinanceController::class)
            ->only(['update']);
    });
    //customer routes
    Route::group([
        'middleware' => 'role:Customer',
        'prefix' => 'customer',
         ], function () {

        Route::resource('customer', CustomerController::class)->only([
            'update'
        ]);

        Route::post(
            '/update',
            [
                App\Http\Controllers\CustomerController::class,
                'update_customer'
            ]
        );

        Route::resource('address', AddressController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('review', ReviewController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::apiResource('restaurant', Restaurant\CustomerRestaurantController::class)
            ->only(['index']);

        //booked table
        Route::get('/booked-table/free-slots', [App\Http\Controllers\BookedTableController::class, 'get_free_slots']);
        Route::resource('book-table', BookedTableController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
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
