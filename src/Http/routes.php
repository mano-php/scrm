<?php

use ManoCode\Scrm\Http\Controllers;
use Illuminate\Support\Facades\Route;
use ManoCode\Scrm\Http\Controllers\ScrmLabelGroupController;
use ManoCode\Scrm\Http\Controllers\ScrmUserController;

Route::get('scrm', [Controllers\ScrmController::class, 'index']);
// 客户管理
Route::resource('scrm_user', ScrmUserController::class);
Route::post('scrm_user_api/add_label', [ScrmUserController::class, 'addLabelApi']);
Route::get('scrm_user_label/get-label-lists-for-user', [ScrmUserController::class, 'getUserLabel']);
Route::get('/scrm_user_group_api/usergroup-lists',[ScrmUserController::class,'getUserGroupLists']);


// 客户标签分组
Route::resource('scrm_label_group', ScrmLabelGroupController::class);
Route::get('/scrm_label_group_api/labelgroup-lists',[ScrmLabelGroupController::class,'getLabelGroupLists']);
Route::get('/scrm_label_group_api/labelgroup_lists_tree',[ScrmLabelGroupController::class,'getLabelGroupListsTree']);

// 客户标签
Route::resource('scrm_label', \ManoCode\Scrm\Http\Controllers\ScrmLabelController::class);

// 客户系统分群
Route::resource('scrm_user_group', \ManoCode\Scrm\Http\Controllers\ScrmUserGroupController::class);
