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
        Schema::create('crm_user_label', function (Blueprint $table) {
            $table->comment('客户标签关联表');
            $table->increments('id');
            $table->unsignedInteger('label_id')->default(0)->comment('标签id');
            $table->unsignedInteger('user_id')->default(0)->comment('客户id');
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
        Schema::dropIfExists('crm_user_label');
    }
};
