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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
});

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

Route::group(['prefix' => 'admin'], function(){
    Route::get('products/',[
        'as' => 'admin.products', 'uses' => 'ProductController@index'
    ]);
});

// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[
            'as' => 'admin.categories', 'uses' => 'CategoryController@index'
        ]);
        Route::put('/update/{id}',[
            'as' => 'admin.categories.update', 'uses' => 'CategoryController@update'
        ]);
        Route::post('/{parent}',[
            'as' => 'admin.categories.create', 'uses' => 'CategoryController@create'
        ]);
        Route::get('/root',[
            'as' => 'admin.categories.create.root', 'uses' => 'CategoryController@createRoot'
        ]);
        Route::delete('/{id}',[
            'as' => 'admin.categories.delete', 'uses' => 'CategoryController@delete'
        ]);

        Route::get('/leafs',[
            'as' => 'admin.categories.leafs', 'uses' => 'CategoryController@leafs'
        ]);
    });

    Route::group(['prefix' => 'products'], function () {
        Route::put('/{id}',[
            'as' => 'admin.products.update', 'uses' => 'ProductController@update'
        ]);
        Route::post('/',[
            'as' => 'admin.products.create', 'uses' => 'ProductController@create'
        ]);
        Route::get('/{id}',[
            'as' => 'admin.products.get', 'uses' => 'ProductController@get'
        ]);
        Route::delete('/{id}',[
            'as' => 'admin.products.delete', 'uses' => 'ProductController@delete'
        ]);
    });

    Route::group(['prefix' => 'settings'], function () {

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'Demo\SettingsController@postSocial'
        ]);
    });

    Route::group(['prefix' => 'users'], function (){

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@allUsers'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'Demo\PagesController@destroy'
        ]);

    });

});

Route::post('imageUpload','ImageController@imageUpload');

