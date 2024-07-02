<?php

namespace ManoCode\Scrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmUserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, '新会员', 1, '入会时间小于等于3天', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '老会员', 1, '入会时间大于3天', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, '本月入会周年', 1, '入会时间是本月月份的会员', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, '下月入会周年', 1, '入会时间是下月月份的会员', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, '生日当天客户', 1, '生日是当天的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, '本周生日客户', 1, '生日是本周（自然周）的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, '本月生日客户', 1, '生日是本月（自然月）的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `scrm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, '下月生日客户', 1, '生日是下个月的客户', NULL, NULL, NULL, NULL);");
    }
}
