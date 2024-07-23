<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\myProfileController;
use App\Http\Controllers\test\FromTest;
use App\Http\Controllers\User\dashboardController;
use App\Http\Controllers\User\roleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\permissionController;
use App\Http\Controllers\User\RolePermissionController;
use App\Http\Controllers\User\userController;

// loginController
route::get('/login', [loginController::class, 'index'])->name('login');
route::post('/login', [loginController::class, 'login'])->name('loginData');
route::get('/logout', [loginController::class, 'logout'])->name('logout');

route::group(['middleware' => 'auth'], function () {
    // dashboardController
    route::get('/', [dashboardController::class, 'index'])->name('dashboard');


    //roleController
    route::get('/role', [roleController::class, 'index'])->name('role.index');
    Route::get('/role/data', [roleController::class, 'data'])->name('role.data');
    Route::get('/role/create', [roleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [roleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [roleController::class, 'edit'])->name('role.edit');
    Route::post('/role/{id}/update', [roleController::class, 'update'])->name('role.update');
    Route::get('/role/{id}/delete', [roleController::class, 'delete'])->name('role.delete');


    //userController
    route::get('/user', [userController::class, 'index'])->name('user.index');
    Route::get('/user/data', [userController::class, 'data'])->name('user.data');
    route::get('/{filename}/showImage', [userController::class, 'showImage'])->name('user.showImage');
    route::get('/{id}/deleteImage', [userController::class, 'deleteImage'])->name('user.deleteImage');
    Route::get('/user/create', [userController::class, 'create'])->name('user.create');
    Route::post('/user/store', [userController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [userController::class, 'edit'])->name('user.edit');
    Route::post('/user/{id}/update', [userController::class, 'update'])->name('user.update');
    Route::get('/user/{id}/delete', [userController::class, 'delete'])->name('user.delete');
    route::get('user/{id}/view', [userController::class, 'view'])->name('user.view');



    //permissionController
    route::get('/permission', [permissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/data', [permissionController::class, 'data'])->name('permission.data');
    Route::get('/permission/create', [permissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [permissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/{id}/edit', [permissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/{id}/update', [permissionController::class, 'update'])->name('permission.update');
    Route::get('/permission/{id}/delete', [permissionController::class, 'delete'])->name('permission.delete');



    // RolePermissionController
    route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::get('/role-permission/data', [RolePermissionController::class, 'data'])->name('role-permission.data');
    Route::get('/role-permission/create', [RolePermissionController::class, 'create'])->name('role-permission.create');
    Route::post('/role-permission/store', [RolePermissionController::class, 'store'])->name('role-permission.store');
    Route::get('/role-permission/{id}/edit', [RolePermissionController::class, 'edit'])->name('role-permission.edit');
    Route::post('/role-permission/{id}/update', [RolePermissionController::class, 'update'])->name('role-permission.update');
    Route::get('/role-permission/{id}/delete', [RolePermissionController::class, 'delete'])->name('role-permission.delete');



    // myProfileController
    route::get('/my-profile', [myProfileController::class, 'index'])->name('myProfile');
    Route::get('/my-profile/edit', [myProfileController::class, 'edit'])->name('myProfile.edit');
    Route::post('/my-profile/update', [myProfileController::class, 'update'])->name('myProfile.update');
    Route::get('/my-profile/change-password', [myProfileController::class, 'changePassword'])->name('myProfile.changePassword');
    Route::post('/my-profile/change-password/update', [myProfileController::class, 'passwordUpdate'])->name('myProfile.passwordUpdate');



});
