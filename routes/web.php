<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::group([
    'middleware' => 'redirect_role:Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/{component?}', 'HomeController@admin_index');
    // Route::get('/{group}/{component}/{id?}', 'HomeController@admin_show');
});


Route::group([
    'middleware' => 'redirect_role:Employee',
    'prefix' => 'employee'
], function () {
    Route::get('/{component?}', 'HomeController@employee_index');
    // Route::get('/{group}/{component}/{id?}', 'HomeController@employee_show');
});

Route::group([
    'middleware' => 'redirect_role:Finance',
    'prefix' => 'finance'
], function () {
    Route::get('/{component?}', 'HomeController@finance_index');
    // Route::get('/{group}/{component}/{id?}', 'HomeController@employee_show');
});



Route::get('{component?}', 'HomeController@redirect');
// Route::get('{group}/{component}/{id?}', 'HomeController@redirect2');
