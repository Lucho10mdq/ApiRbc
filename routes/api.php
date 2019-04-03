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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('profile', 'AuthController@profile');
    Route::get('logout', 'AuthController@logout');

    //people
    Route::post( 'waiters','WaitersController@store' ) ;
    Route::get(  'waiters', 'WaitersController@index' ) ;
    Route::get(  'waiters/{id}', 'WaitersController@show' ) ;
    Route::delete('waiters/{id}','WaitersController@destroy');
    Route::delete('waiters/{id}/location','WaitersController@destroyLocationWaiter');
    Route::put('waiters/{id}','WaitersController@update');
    
    //locations tables
    Route::post( 'locations_tables', 'LocationsTablesController@store' ) ;
    Route::get( 'locations_tables', 'LocationsTablesController@index' ) ;
    Route::get( 'locations_tables/{id}', 'LocationsTablesController@show' ) ;
    Route::put( 'locations_tables/{id}', 'LocationsTablesController@update' ) ;

    //tables
    Route::post( 'tables', 'TablesController@store' ) ;
    Route::get( 'tables', 'TablesController@index' ) ;
    Route::get( 'tables/{id}', 'TablesController@show' ) ;
    Route::delete( 'tables/{id}', 'TablesController@destroy' ) ;
    Route::put( 'tables/{id}', 'TablesController@update' ) ;

    //Customers

    Route::post( 'customers','CustomersController@store' ) ;
    Route::get( 'customers', 'CustomersController@index' ) ;
    Route::get( 'customers/{id}', 'CustomersController@show' ) ;
    Route::put( 'customers/{id}','CustomersController@update');
    Route::delete('customers/{id}','CustomersController@destroy');

    //Order

    Route::get('orders','OrdersController@index');
    Route::post('orders','OrdersController@store');
    Route::put('orders/{id}', 'OrdersController@update') ;
    Route::get('orders/{id}','OrdersController@show');
    Route::delete('orders/{id}','OrdersController@destroy');

    //OrderState

    Route::get('orderstate','OrderStatesController@index');
    Route::post('orderstate','OrderStatesController@store');
    Route::put('orderstate/{id}','OrderStatesController@update');
    Route::get('orderstate/{id}','OrderStatesController@show');

    //PlateStates
    Route::get('platestates','PlateStatesController@index');
    Route::post('platestates','PlateStatesController@store');
    Route::put('platestates/{id}','PlateStatesController@update');
    Route::get('platestates/{id}','PlateStatesController@show');

    //Menus - Locations - Categories
    Route::get( 'locations', 'LocationsController@index' ) ;
    Route::get( 'locations/{id}', 'LocationsController@show' ) ;
    Route::post( 'locations', 'LocationsController@store' ) ;
    Route::put( 'locations/{id}', 'LocationsController@update' ) ;

    Route::get( 'categories', 'CategoriesController@index' ) ;
    Route::get( 'categories/{id}', 'CategoriesController@show' ) ;
    Route::post( 'categories','CategoriesController@store' ) ;
    Route::put( 'categories/{id}', 'CategoriesController@update' ) ;
    // Route::delete( 'categories/{id}', 'CategoriesController@destroy' ) ;

    Route::get( 'menus/{active?}', 'MenusController@index' )->where(['active' => '[a-zA-Z]+']); ;
    Route::get( 'menus/{id}', 'MenusController@show' )->where(['id' => '[0-9]+']); 
    Route::post( 'menus', 'MenusController@store' ) ;
    Route::put( 'menus/{id}','MenusController@update') ;
    Route::patch( 'menus/{id}/active',  'MenusController@active' ) ;
    Route::patch( 'menus/{id}/inactive',  'MenusController@inactive' ) ;
});