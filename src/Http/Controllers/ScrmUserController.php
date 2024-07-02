<?php

namespace Mano\Scrm\Http\Controllers;

use Mano\Scrm\Models\ScrmLabelGroup;
use Mano\Scrm\Models\ScrmUserGroup;
use Mano\Scrm\Services\ScrmUserService;
use Slowlyo\OwlAdmin\Controllers\AdminController;
use Slowlyo\OwlAdmin\Renderers\SelectControl;
use Slowlyo\OwlAdmin\Renderers\TextControl;

/**
 * 客户管理
 *
 * @property ScrmUserService $service
 */
class ScrmUserController extends AdminController
{
	protected string $serviceName = ScrmUserService::class;

	public function list()
	{
		$crud = $this->baseCRUD()
			->filterTogglable(false)
			->headerToolbar([
				$this->createButton(true),
				...$this->baseHeaderToolBar()
			])
            ->filter($this->baseFilter()->body([
                TextControl::make()->name('mobile')->label('手机号')->placeholder('请输入手机号')->size('sm'),
                amis()->SelectControl('user_group_id', '分群名称')->source('/scrm_user_group_api/usergroup-lists'),
                amis()->SelectControl('state', '状态')->options(ScrmUserService::STATE_TYPE),
                amis()->SelectControl('channel', '渠道')->options(ScrmUserService::CHANNEL_TYPE),
                amis()->TreeControl('labels', '标签')->source('/scrm_label_group_api/labelgroup_lists_tree')
                    ->multiple(true)->cascade(true)->onlyChildren(true)
                    ->type('tree-select')->width(150)->searchable(true),
                amis()->DateRangeControl('regtime', '成为客户时间'),

            ]))
            ->bulkActions([$this->addLabelBuuton('$ids')])
			->columns([
				amis()->TableColumn('id', '客户id')->sortable(),
				amis()->TableColumn('nickname', '昵称'),
				amis()->TableColumn('avatar', '头像')->type('avatar')->src('${avatar}'),
				amis()->TableColumn('luck_date', '生日'),
                amis()->SelectControl('sex', '性别')->options(ScrmUserService::SEX_TYPE)->static(),
				amis()->TableColumn('group_labels', '分群标签'),
				amis()->TableColumn('labels_name', '标签'),
				amis()->TableColumn('level', '客户等级'),
				amis()->TableColumn('mobile', '客户手机号'),
                amis()->SelectControl('channel', '渠道')->options(ScrmUserService::CHANNEL_TYPE)->static(),
				amis()->SelectControl('state', '状态')->options(ScrmUserService::STATE_TYPE)->static(),
				amis()->TableColumn('created_at', admin_trans('admin.created_at'))->type('datetime')->sortable(),
				amis()->TableColumn('updated_at', admin_trans('admin.updated_at'))->type('datetime')->sortable(),
				$this->rowActions(true)
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
            $this->addLabelBuuton('$id'),
        ]);
    }

    public function addLabelBuuton($name){
        $form = $this->addLabelForm($name);

        $button = amis()->DialogAction()->dialog(
            amis()->Dialog()->title(admin_trans('admin.create'))->body($form)
        );

        return $button->label('打标签')->icon('fa fa-add')->level('primary');
    }
    public function addLabelForm($name){
        $baseForm = $this->baseForm(false)->body([
            amis()->TreeControl('labels', '标签')->source('/scrm_label_group_api/labelgroup_lists_tree')->multiple(true)->cascade(true)->onlyChildren(true),
        ])->api(admin_url('scrm_user_api/add_label').'?ids='.$name);
        if($name =='$id'){
            $baseForm->initApi('/scrm_user_label/get-label-lists-for-user?id='.$name);
        }
        return $baseForm;
    }

	public function form($isEdit = false)
	{
		return $this->baseForm()->body([
            amis()->TextControl('nickname', '昵称'),
            ManoImageControl('avatar', '头像')->required(true),
            amis()->DateControl('luck_date', '生日'),
            amis()->SelectControl('sex', '性别')->options(ScrmUserService::SEX_TYPE),
			amis()->TextControl('mobile', '客户手机号'),
			amis()->TextControl('level', '客户等级'),
            amis()->SelectControl('channel', '渠道')->options(ScrmUserService::CHANNEL_TYPE),
            amis()->SelectControl('state', '状态')->options(ScrmUserService::STATE_TYPE),
		]);
	}

	public function detail()
	{
		return $this->baseDetail()->body([
			amis()->TextControl('id', '客户id')->static(),
			amis()->TextControl('reg_time', '成为客户时间')->static(),
			amis()->TextControl('level', '客户等级')->static(),
            amis()->TextControl('mobile', '客户手机号')->static(),
            amis()->SelectControl('channel', '渠道')->options(ScrmUserService::CHANNEL_TYPE)->static(),
            amis()->SelectControl('state', '状态')->options(ScrmUserService::STATE_TYPE)->static(),
			amis()->TextControl('created_at', admin_trans('admin.created_at'))->static(),
			amis()->TextControl('updated_at', admin_trans('admin.updated_at'))->static(),
		]);
	}

    public function addLabelApi()
    {
        $params = request()->all();
        $this->service->addLabel($params);
        return $this->response()->success();
    }

    public function getUserLabel()
    {
        $params = request()->all();
        return $this->response()->success($this->service->getUserLabel($params));
    }

    public function getUserGroupLists(): \Illuminate\Http\JsonResponse|array
    {
        $res = ScrmUserGroup::query()->get();
        $label = 'name';
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
}
