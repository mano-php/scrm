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
        Schema::create('crm_label_group', function (Blueprint $table) {
            $table->comment('crm客户标签分组');
            $table->increments('id');
            $table->string('group_name')->default('')->comment('标签分组名称');
            $table->unsignedInteger('type')->index()->default(new \Illuminate\Database\Query\Expression('1'))->comment('类型1单选2多选');
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
        Schema::dropIfExists('crm_label_group');
    }
};
