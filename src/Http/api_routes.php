<?php

use Illuminate\Support\Facades\Route;

// 收货地址管理
Route::group(['prefix' => '/api/mini-app/address', 'middleware' => \ManoCode\MiniWechat\Http\Middleware\MemberLoginMiddleware::class], function () {
    // 获取列表
    Route::get('list', [\Mano\Crm\Http\Controllers\AddressController::class, 'list']);
    // 城市列表
    Route::get('tree', [\Mano\Crm\Http\Controllers\AddressController::class, 'tree']);
    // 设置默认地址
    Route::post('default', [\Mano\Crm\Http\Controllers\AddressController::class, 'default']);
    // 获取地址信息
    Route::post('detail', [\Mano\Crm\Http\Controllers\AddressController::class, 'detail']);
    // 创建
    Route::post('create', [\Mano\Crm\Http\Controllers\AddressController::class, 'create']);
    // 修改
    Route::post('save', [\Mano\Crm\Http\Controllers\AddressController::class, 'save']);
    // 删除
    Route::post('delete', [\Mano\Crm\Http\Controllers\AddressController::class, 'delete']);
});
