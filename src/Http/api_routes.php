<?php

use Illuminate\Support\Facades\Route;

// 收货地址管理
Route::group(['prefix' => '/api/mini-app/address', 'middleware' => \ManoCode\MiniWechat\Http\Middleware\MemberLoginMiddleware::class], function () {
    // 获取列表
    Route::get('list', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'list']);
    // 城市列表
    Route::get('tree', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'tree']);
    // 设置默认地址
    Route::post('default', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'default']);
    // 获取地址信息
    Route::post('detail', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'detail']);
    // 创建
    Route::post('create', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'create']);
    // 修改
    Route::post('save', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'save']);
    // 删除
    Route::post('delete', [\ManoCode\Scrm\Http\Controllers\AddressController::class, 'delete']);
});
