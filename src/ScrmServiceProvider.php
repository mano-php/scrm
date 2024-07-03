<?php

namespace ManoCode\Scrm;

use Illuminate\Support\Facades\DB;
use Slowlyo\OwlAdmin\Renderers\TextControl;
use Slowlyo\OwlAdmin\Extend\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Slowlyo\OwlAdmin\Events\ExtensionChanged;

class ScrmServiceProvider extends ServiceProvider
{
    protected $menu = [
        [
            'parent' => 0,
            'title' => 'scrm管理',
            'url' => '/scrm',
            'url_type' => '1',
            'keep_alive' => '1',
            'icon' => 'clarity:employee-line',
        ],
        [
            'parent' => 'scrm管理', // 此处父级菜单根据 title 查找
            'title' => '客户管理',
            'url' => '/scrm_user',
            'url_type' => '1',
            'icon' => 'material-symbols-light:corporate-fare',
        ],
        [
            'parent' => 'scrm管理', // 此处父级菜单根据 title 查找
            'title' => '客户标签',
            'url' => '/scrm_label_group',
            'url_type' => '1',
            'icon' => 'clarity:employee-group-line',
        ],
        [
            'parent' => 'scrm管理', // 此处父级菜单根据 title 查找
            'title' => '人群管理',
            'url' => '/scrm_user_group',
            'url_type' => '1',
            'icon' => 'clarity:employee-group-line',
        ],
    ];


    public function install()
    {
    }

    /**
     * 监听扩展注册事件
     * @return void
     */
    public function register()
    {
        /**
         * 监听启用禁用 事件
         */
        Event::listen(ExtensionChanged::class, function (ExtensionChanged $event) {
            if ($event->name === $this->getName() && $event->type == 'enable') {
                $this->runMigrations();
            }
        });
    }

	public function settingForm()
	{
	    return $this->baseSettingForm()->body([
            TextControl::make()->name('value')->label('Value')->required(true),
	    ]);
	}
}
