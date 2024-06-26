<?php

namespace Mano\Crm;

use Illuminate\Support\Facades\DB;
use Slowlyo\OwlAdmin\Renderers\TextControl;
use Slowlyo\OwlAdmin\Extend\ServiceProvider;

class CrmServiceProvider extends ServiceProvider
{
    protected $menu = [
        [
            'parent' => 0,
            'title' => 'crm管理',
            'url' => '/crm',
            'url_type' => '1',
            'keep_alive' => '1',
            'icon' => 'clarity:employee-line',
        ],
        [
            'parent' => 'crm管理', // 此处父级菜单根据 title 查找
            'title' => '客户管理',
            'url' => '/crm_user',
            'url_type' => '1',
            'icon' => 'material-symbols-light:corporate-fare',
        ],
        [
            'parent' => 'crm管理', // 此处父级菜单根据 title 查找
            'title' => '客户标签',
            'url' => '/crm_label_group',
            'url_type' => '1',
            'icon' => 'clarity:employee-group-line',
        ],
        [
            'parent' => 'crm管理', // 此处父级菜单根据 title 查找
            'title' => '人群管理',
            'url' => '/crm_user_group',
            'url_type' => '1',
            'icon' => 'clarity:employee-group-line',
        ],
    ];


    public function install()
    {
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, '新会员', 1, '入会时间小于等于3天', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '老会员', 1, '入会时间大于3天', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, '本月入会周年', 1, '入会时间是本月月份的会员', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, '下月入会周年', 1, '入会时间是下月月份的会员', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, '生日当天客户', 1, '生日是当天的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, '本周生日客户', 1, '生日是本周（自然周）的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, '本月生日客户', 1, '生日是本月（自然月）的客户', NULL, NULL, NULL, NULL);");
        DB::query("INSERT INTO `crm_user_group` (`id`, `name`, `up_type`, `remark`, `ext_params`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, '下月生日客户', 1, '生日是下个月的客户', NULL, NULL, NULL, NULL);");
    }

	public function settingForm()
	{
	    return $this->baseSettingForm()->body([
            TextControl::make()->name('value')->label('Value')->required(true),
	    ]);
	}
}
