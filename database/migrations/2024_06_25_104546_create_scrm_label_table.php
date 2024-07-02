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
        Schema::create('scrm_label', function (Blueprint $table) {
            $table->comment('客户标签');
            $table->increments('id');
            $table->unsignedInteger('group_id')->index()->default(new \Illuminate\Database\Query\Expression('0'))->comment('分组id');
            $table->string('label')->default('')->comment('标签名称');
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
        Schema::dropIfExists('scrm_label');
    }
};
