<?php
use Illuminate\Http\Request;
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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

//Change Password
Route::get('/change_password', function() {return view('change_password'); });
Route::post('/change_password', 'Auth\UpdatePasswordController@update');

//Add an appliance record to the database
Route::get('/add_appliance', 'AddApplianceController@input');

Route::post('/add_appliance', 'AddApplianceController@output');

//Delete an appliance record
Route::get('/delete_appliance', 'DeleteApplianceController@input');

Route::post('/delete_appliance', 'DeleteApplianceController@output');

//View an appliance using client code
Route::get('/view_appliance/{client_code}', 'ViewApplianceController@index');
Route::post('/view_appliance', 'ViewApplianceController@addRoute');

//Delete a route record
Route::get('/delete_route', 'DeleteRouteController@output');

