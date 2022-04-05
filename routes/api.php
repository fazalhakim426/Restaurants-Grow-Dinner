<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\EmployeeController; 
use Illuminate\Support\Facades\Route; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider withinpe a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 //signup  customer  
    Route::post('/customer/register', [CustomerController::class,'store']);
    Route::post('/finance', [FinanceController::class,'store']);
    Route::post('/employee', [EmployeeController::class,'store']);

Route::post('/login', [AuthenticationController::class, 'login']);

// Route::post('/products', 'ProductController@store');
// Route::get('/products', 'ProductController@index');
// Route::get('/prices', 'ProductController@prices');

// Route::get('/menus', 'MenusController@index');
 


Route::group(['middleware' => 'auth:api'], function() {

    Route::get('/user', [AuthenticationController::class, 'user']); 
    Route::post('logout', [AuthenticationController::class, 'logout']);
    //customer
    Route::get('/customer/{id}', [CustomerController::class,'show']); 
    Route::get('/customer',[CustomerController::class,'index']);
    Route::delete('/customer/{id}', [CustomerController::class,'destroy']);
    Route::put('/customer/{customer}',[CustomerController::class,'update'])->middleware('role:Customer');;
    //emplooyee
    Route::get('/employee/{id}', [EmployeeController::class,'show']); 
    Route::get('/employee',[EmployeeController::class,'index']);
    Route::delete('/employee/{id}', [EmployeeController::class,'destroy']);
    Route::put('/employee/{employee}',[EmployeeController::class,'update'])->middleware('role:Employee');;
    //finance
    Route::get('/finance/{id}', [FinanceController::class,'show']); 
    Route::get('/finance',[FinanceController::class,'index']);
    Route::delete('/finance/{id}', [FinanceController::class,'destroy']);
    Route::put('/finance/{finance}',[FinanceController::class,'update'])->middleware('role:Finance');
    //country  
    Route::resource('country', CountryController::class)->only([
        'index', 'store','update','destroy'
    ]);
    Route::resource('city', CityController::class)->only([
        'store','update','destroy'
    ]);  
    Route::get('/country/{country}/city',[App\Http\Controllers\CityController::class,'index']); 

    Route::resource('department', DepartmentController::class)->only([
        'store','update','destroy'
    ]);  
    Route::get('/city/{city}/departments',[App\Http\Controllers\DepartmentController::class,'index']); 

//admin routes
Route::group(['middleware' => 'role:Admin'], function() { 
});
//customer routes
Route::group(['middleware' => 'role:Customer'], function() {
});

});

Route::group([
    'namespace' => 'Auth',
    
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
 
    Route::post('create', [ForgotPasswordController::class, 'create']);
    Route::get('find/{token}', [ForgotPasswordController::class, 'find']);
    Route::post('reset', [ForgotPasswordController::class, 'reset']);
});

// Route::get('/redirect', function () {
//     $query = http_build_query([
//         'client_id' => 'client-id',
//         'redirect_uri' => 'http://example.com/callback',
//         'response_type' => 'code',
//         'scope' => 'place-orders check-status',
//     ]);
//     return redirect('http://your-app.com/oauth/authorize?' . $query);
// });
