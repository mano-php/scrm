<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_user', function (Blueprint $table) {
            $table->comment('客户管理');
            $table->increments('id');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('avatar')->default('')->comment('头像');
            $table->date('luck_date')->nullable()->comment('生日');
            $table->timestamp('reg_time')->nullable()->comment('成为客户时间');
            $table->unsignedTinyInteger('sex')->default(0)->comment('性别，0其他1男2女');
            $table->unsignedInteger('level')->default(new \Illuminate\Database\Query\Expression('0'))->comment('客户等级');
            $table->string('mobile')->default('')->comment('手机号');
            $table->unsignedTinyInteger('channel')->default(new \Illuminate\Database\Query\Expression('1'))->comment('1微信2支付宝3其他');
            $table->unsignedTinyInteger('state')->default(new \Illuminate\Database\Query\Expression('0'))->comment('状态：0-正常，1-拉黑， 2-冻结');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_user');
    }
};
