<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
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



Route::get('/api/mail', function(){
    $email = 'junrey.gonzales.07@gmail.com';
    Mail::to($email)->send(new \App\Mail\ForgetPassMail('body', 'subject'));
    return 'awsss';
});


Route::get('/qr', 'AuthUserController@addUser');




Route::get('/test', function(){
    return 'truesss';
});
// Route::group(['middleware' => 'prevent-back-history'], function(){


Route::post('/authlogin', 'AuthUserController@login');

Route::get('/login', function(){
    return view('login');
})->name('login');


Route::group(['middleware' => 'authuser'], function () {

    Route::get('/', function(){
        return view('home');
    })->name('home');
    
    
    Route::get('/users', function(){
        return view('users');
    })->name('users');
    
    
    
    Route::get('/scan', function(){
        return view('scanner');
    })->name('scan');
    

    Route::get('/settings', function(){
        return view('underconstruction');
    })->name('settings');
    
    Route::get('/report', function(){
        return view('report');
    })->name('report');

    Route::get('/authlogout', 'AuthUserController@logout');
    // Route::post('logout', 'AuthUserController@logout');

    // // User Profile
    // Route::get('userprofile', 'UserProfileController@getProfile')->name('userprofile');
    // Route::post('save-userprofile', 'UserProfileController@saveUserProfile');

    // // dashboard
    // Route::get('/', 'HomeController@home')->name('home');

    // // Inventory
    // Route::get('/product', 'InventoryController@getProducts')->name('product');
    // Route::post('/product', 'InventoryController@addProductInventory');
    // Route::patch('/product', 'InventoryController@updateProductInventory');
    // Route::post('/delete-product', 'InventoryController@deleteProductInventory');

    //     // Category
    // Route::get('/product/category', 'InventoryController@productCategoryView')->name('productcategory');
    // // udpate or insert
    // Route::post('/product/category', 'InventoryController@insertOrUpdateCategory');
    // Route::post('/product/delete-category', 'InventoryController@deleteCategory');
    

});