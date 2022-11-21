<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\user\AjaxController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    //Admin
    Route::middleware('admin_auth')->group(function(){

    //Admin Account
    Route::prefix('admin')->group(function(){
        //change passwore
        Route::get('change/password',[AuthController::class,'changePassword'])->name('admin.changePassword');
        Route::post('save/password',[AuthController::class,'savePassword'])->name('admin.savePassword');

        //Account detail
        Route::get('account/detail',[AuthController::class,'accountDetail'])->name('admin.accountDetail');

        //Update Profile
        Route::get('edit/profile',[AuthController::class,'editProfile'])->name('admin.editProfile');
        Route::post('update/profile/{id}',[AuthController::class,'updateProfile'])->name('admin.updateProfile');

        //Account list and delete account
        Route::get('list',[AuthController::class,'adminList'])->name('admin.list');
        Route::get('delete/{id}',[AuthController::class,'delete'])->name('admin.delete');

        //Change Role
        Route::get('change/role',[AuthController::class,'changeRole'])->name('admin.changeRole'); //with ajax
    });

    //Category
         Route::group(['prefix' => 'category'],function(){
            Route::get('list',[CategoryController::class,'list'])->name('category.list');
            Route::get('create',[CategoryController::class,'create'])->name('category.create');
            Route::post('save',[CategoryController::class,'save'])->name('category.save');
            Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
            Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
            Route::post('update/{id}',[CategoryController::class,'update'])->name('category.update');
        });

    //Order
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'list'])->name('order.list');
            Route::get('sort',[OrderController::class,'sort'])->name('order.sort');
            Route::get('change/status',[OrderController::class,'changeStatus'])->name('order.changeStatus'); //work with ajax
            Route::get('detail/{orderCode}',[OrderController::class,'orderDetail'])->name('order.detail');
        });

    //User List
        Route::prefix('user')->group(function(){
            Route::get('list',[AuthController::class,'userList'])->name('user.list');
            Route::get('edit/{id}',[AuthController::class,'editUserProfile'])->name('user.edit');
            Route::post('edit/{id}',[AuthController::class,'save'])->name('user.save');

        });

    //Product
    Route::prefix('product')->group(function(){
        Route::get('list',[ProductController::class,'list'])->name('product.list');
        Route::get('create',[ProductController::class,'create'])->name('product.create');
        Route::post('save',[ProductController::class,'save'])->name('product.save');
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product.delete');
        Route::get('detail/{id}',[ProductController::class,'detail'])->name('product.detail');
        Route::get('edit/{id}',[ProductController::class,'edit'])->name('product.edit');
        Route::post('update/{id}',[ProductController::class,'update'])->name('product.update');
    });

    //Contact
    Route::prefix('contact')->group(function(){
        Route::get('list',[ContactController::class,'list'])->name('user.contactList');
        Route::get('detail/{id}',[ContactController::class,'detail'])->name('user.contactDetail');
    });
});


    //User
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'],function(){
        Route::get('home',[UserController::class,'home'])->name('user.home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user.filter');
        Route::get('history',[UserController::class,'history'])->name('user.history');

        //Account
        Route::get('change/password',[UserController::class,'changePassword'])->name('user.changePassword');
        Route::post('save/password',[UserController::class,'savePassword'])->name('user.savePassword');
        Route::get('edit',[UserController::class,'editProfile'])->name('user.editProfile');
        Route::post('update/profile/{id}',[UserController::class,'update'])->name('user.updateProfile');

        //Ajax
        Route::prefix('ajax')->group(function(){
            Route::get('pizza/list',[AjaxController::class,'list'])->name('ajax.pizzaList');
            Route::get('cart',[AjaxController::class,'addToCart'])->name('ajax.addToCart');
            Route::get('order',[AjaxController::class,'order'])->name('ajax.order');
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax.clearCart');
            Route::get('clear/cart/item',[AjaxController::class,'clearCartItem'])->name('ajax.clearCartItem');
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name('ajax.increaseViewCount');
        });

        //product
        Route::prefix('pizza')->group(function(){
            Route::get('detail/{id}',[UserController::class,'detail'])->name('user.pizzaDetail');
        });

        //Cart
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user.cartList');
        });

        //Contact
        Route::prefix('contact')->group(function(){
            Route::get('/',[UserController::class,'contact'])->name('user.contact');
            Route::post('save',[UserController::class,'saveContact'])->name('user.saveContact');
        });
    });
});

Route::middleware('admin_auth')->group(function(){
    Route::redirect('/','loginPage');
    Route::get('loginPage',[AuthController::class,'login'])->name('auth.login');
    Route::get('registerPage',[AuthController::class,'register'])->name('auth.register');
});


