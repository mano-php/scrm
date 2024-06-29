<?php

use Mano\Crm\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Mano\Crm\Http\Controllers\CrmLabelGroupController;
use Mano\Crm\Http\Controllers\CrmUserController;

Route::get('crm', [Controllers\CrmController::class, 'index']);
// 客户管理
Route::resource('crm_user', CrmUserController::class);
Route::post('crm_user_api/add_label', [CrmUserController::class, 'addLabelApi']);
Route::get('crm_user_label/get-label-lists-for-user', [CrmUserController::class, 'getUserLabel']);
Route::get('/crm_user_group_api/usergroup-lists',[CrmUserController::class,'getUserGroupLists']);


// 客户标签分组
Route::resource('crm_label_group', CrmLabelGroupController::class);
Route::get('/crm_label_group_api/labelgroup-lists',[CrmLabelGroupController::class,'getLabelGroupLists']);
Route::get('/crm_label_group_api/labelgroup_lists_tree',[CrmLabelGroupController::class,'getLabelGroupListsTree']);

// 客户标签
Route::resource('crm_label', \Mano\Crm\Http\Controllers\CrmLabelController::class);

// 客户系统分群
Route::resource('crm_user_group', \Mano\Crm\Http\Controllers\CrmUserGroupController::class);

// 客户收货地址
Route::resource('address_manager', \Mano\Crm\Http\Controllers\MemberAddresController::class);
