<?php

namespace Mano\Crm\Http\Controllers;

use Illuminate\Support\Arr;
use Mano\Crm\Models\CrmLabel;
use Mano\Crm\Models\CrmLabelGroup;
use Mano\Crm\Services\CrmLabelGroupService;
use Slowlyo\OwlAdmin\Controllers\AdminController;

/**
 * 客户标签分组
 *
 * @property CrmLabelGroupService $service
 */
class CrmLabelGroupController extends AdminController
{
	protected string $serviceName = CrmLabelGroupService::class;

	public function list()
	{
		$crud = $this->baseCRUD()
			->filterTogglable(false)
			->headerToolbar([
				$this->createButton(true),
				...$this->baseHeaderToolBar()
			])
			->columns([
				amis()->TableColumn('id', 'ID')->sortable(),
				amis()->TableColumn('group_name', '分组名称'),
                amis()->SelectControl('type', '类型')->options(CrmLabelGroupService::LABEL_TYPE)->static(),
                amis()->TextControl('labels_name', '标签')->static(),
				amis()->TableColumn('created_at', admin_trans('admin.created_at'))->type('datetime')->sortable(),
				amis()->TableColumn('updated_at', admin_trans('admin.updated_at'))->type('datetime')->sortable(),
				$this->rowActions(true)
			]);

		return $this->baseList($crud);
	}

	public function form($isEdit = false)
	{
		return $this->baseForm()->body([
			amis()->TextControl('group_name', '标签'),
            amis()->SelectControl('type', '类型')->options(CrmLabelGroupService::LABEL_TYPE),
            amis()->ArrayControl('labels', '标签')->items(['type' => 'input-text']),
		]);
	}

	public function detail()
	{
		return $this->baseDetail()->body([
			amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('group_name', '标签')->static(),
			amis()->SelectControl('type', '类型')->options(CrmLabelGroupService::LABEL_TYPE)->static(),
			amis()->TextControl('created_at', admin_trans('admin.created_at'))->static(),
			amis()->TextControl('updated_at', admin_trans('admin.updated_at'))->static(),
		]);
	}

    public function getLabelGroupLists(): \Illuminate\Http\JsonResponse|array
    {
        $res = CrmLabelGroup::query()->get();
        $label = 'group_name';
        $value = 'id';
        $options = $res->map(function ($item) use ($label, $value) {
            return [
                'label' => $item[$label],
                'value' => $item[$value]
            ];
        });
        return response()->json([
            'options'=>$options
        ]);
    }

    public function getLabelGroupListsTree(): \Illuminate\Http\JsonResponse|array
    {
        $res = CrmLabelGroup::query()->get();
        $options = [];
        foreach ($res as $v) {
            $options[] = [
                'label' => $v['group_name'],
                'value' => -1,
                'children' => CrmLabel::query()->where('group_id', $v['id'])->pluck('label', 'id as value')->toArray()
            ];
        }

        return response()->json([
            'options'=>$options
        ]);
    }
}
