<?php

namespace Mano\Crm\Http\Controllers;

use Mano\Crm\Services\CrmUserGroupService;
use Slowlyo\OwlAdmin\Controllers\AdminController;

/**
 * 客户系统分群
 *
 * @property CrmUserGroupService $service
 */
class CrmUserGroupController extends AdminController
{
	protected string $serviceName = CrmUserGroupService::class;

	public function list()
	{
		$crud = $this->baseCRUD()
			->filterTogglable(false)
			->headerToolbar([
//				$this->createButton(true),
//				...$this->baseHeaderToolBar()
			])
			->columns([
				amis()->TableColumn('id', 'ID')->sortable(),
				amis()->TableColumn('name', '人群名称'),
                amis()->TableColumn('remark', '描述'),
                amis()->SelectControl('up_type', '更新频率')->options(CrmUserGroupService::UP_TYPE)->static(),
                amis()->TableColumn('created_at', admin_trans('admin.created_at'))->type('datetime')->sortable(),
                amis()->TableColumn('updated_at', admin_trans('admin.updated_at'))->type('datetime')->sortable(),
//				$this->rowActions(false)
                amis()->TableColumn('people_num', '人数'),
			]);

		return $this->baseList($crud);
	}

    protected function rowActions(bool|array|string $dialog = false, string $dialogSize = 'md')
    {
        if (is_array($dialog)) {
            return amis()->Operation()->label(admin_trans('admin.actions'))->buttons($dialog);
        }

        return amis()->Operation()->label(admin_trans('admin.actions'))->buttons([
            $this->rowShowButton($dialog, $dialogSize),
            $this->rowEditButton($dialog, $dialogSize),
        ]);
    }

	public function form($isEdit = false)
	{
		return $this->baseForm()->body([
			amis()->TextControl('name', '人群名称'),
			amis()->TextControl('up_type', '更新频率1每天更新'),
			amis()->TextControl('remark', '描述'),
			amis()->TextControl('ext_params', 'ExtParams'),
		]);
	}

	public function detail()
	{
//		return $this->baseDetail()->body([
//			amis()->TextControl('id', 'ID')->static(),
//			amis()->TextControl('name', '人群名称')->static(),
//			amis()->TextControl('up_type', '更新频率1每天更新')->static(),
//			amis()->TextControl('remark', '描述')->static(),
//			amis()->TextControl('ext_params', 'ExtParams')->static(),
//			amis()->TextControl('created_at', admin_trans('admin.created_at'))->static(),
//			amis()->TextControl('updated_at', admin_trans('admin.updated_at'))->static(),
//
//		]);

        return amis()->Service()->body([
            amis()->CRUDTable()->source('$rows')->columns([
                amis()->TableColumn('id', 'ID')->sortable(),
                amis()->TableColumn('name', '人群名称'),
                amis()->TableColumn('up_type', '更新频率')->options(CrmUserGroupService::UP_TYPE)->static(),
            ])
        ])->api(admin_url('/crm_user').'?_action=getData');


	}
}
