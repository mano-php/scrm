<?php

namespace Mano\Crm\Http\Controllers;

use Mano\Crm\Services\CrmLabelService;
use Slowlyo\OwlAdmin\Controllers\AdminController;

/**
 * 客户标签
 *
 * @property CrmLabelService $service
 */
class CrmLabelController extends AdminController
{
	protected string $serviceName = CrmLabelService::class;

	public function list()
	{
		$crud = $this->baseCRUD()
			->filter($this->baseFilter()->body([
				amis()->SelectControl('group_id', '分组名称'),
				amis()->TextControl('label', '标签名称')->size('md')->clearable(1),
			]))
			->headerToolbar([
				$this->createButton(true),
				...$this->baseHeaderToolBar()
			])
			->columns([
				amis()->TableColumn('id', 'ID')->sortable(),
                amis()->SelectControl('group_id', '分组名称')->source('/crm_label_group_api/labelgroup-lists')->static(),
				amis()->TableColumn('label', '标签名称'),
				amis()->TableColumn('created_at', admin_trans('admin.created_at'))->type('datetime')->sortable(),
				amis()->TableColumn('updated_at', admin_trans('admin.updated_at'))->type('datetime')->sortable(),
				$this->rowActions(true)
			]);

		return $this->baseList($crud);
	}

	public function form($isEdit = false)
	{
		return $this->baseForm()->body([
			amis()->SelectControl('group_id', '分组id')->source('/crm_label_group_api/labelgroup-lists'),
			amis()->TextControl('label', '标签名称'),
		]);
	}

	public function detail()
	{
		return $this->baseDetail()->body([
			amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('group_id', '分组id')->static(),
			amis()->TextControl('label', '标签名称')->static(),
			amis()->TextControl('created_at', admin_trans('admin.created_at'))->static(),
			amis()->TextControl('updated_at', admin_trans('admin.updated_at'))->static(),
		]);
	}
}
