<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrm_user_group', function (Blueprint $table) {
            $table->comment('客户分群');
            $table->increments('id');
            $table->string('name')->default('')->comment('人群名称');
            $table->unsignedInteger('up_type')->default(new \Illuminate\Database\Query\Expression('1'))->comment('更新频率1每天更新');
            $table->string('remark')->default('')->comment('描述');
            $table->json('ext_params')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \Mano\Scrm\Models\ScrmUserGroup::insert([
            [
                'name' => '新会员',
                'remark' => '入会时间小于等于3天',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '老会员',
                'remark' => '入会时间大于3天',
                'ext_params' => json_encode([]),
            ],

            [
                'name' => '本月入会周年',
                'remark' => '入会时间是本月月份的会员',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '下月入会周年',
                'remark' => '入会时间是下月月份的会员',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '生日当天客户   ',
                'remark' => '生日是当天的客户',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '本周生日客户',
                'remark' => '生日是本周（自然周）的客户',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '本月生日客户',
                'remark' => '生日是本月（自然月）的客户',
                'ext_params' => json_encode([]),
            ],
            [
                'name' => '下月生日客户',
                'remark' => '生日是下个月的客户',
                'ext_params' => json_encode([]),
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrm_user_group');
    }
};
