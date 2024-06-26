<?php

namespace Mano\Crm\Services;

use Mano\Crm\Models\CrmUser;
use Mano\Crm\Models\CrmUserGroup;
use Mano\Crm\Models\CrmUserLabel;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户管理
 *
 * @method CrmUser getModel()
 * @method CrmUser|\Illuminate\Database\Query\Builder query()
 */
class CrmUserService extends AdminService
{
    protected string $modelName = CrmUser::class;

    const CHANNEL_TYPE = [
        ['label' => '微信', 'value' => 1],
        ['label' => '支付宝', 'value' => 2],
        ['label' => '其他', 'value' => 3],
    ];

    // 0-正常，1-拉黑， 2-冻结
    const STATE_TYPE = [
        ['label' => '正常', 'value' => 1],
        ['label' => '拉黑', 'value' => 2],
        ['label' => '冻结', 'value' => 3],
    ];
    const SEX_TYPE = [
        ['label' => '其他', 'value' => 0],
        ['label' => '男', 'value' => 1],
        ['label' => '女', 'value' => 2],
    ];


    /**
     * 列表 获取数据
     *
     * @return array
     */
    public function list()
    {
        $query = $this->listQuery();

        $params = request()->all();
        if (isset($params['user_group_id']) && !empty($params['user_group_id'])) {
            CrmUserGroupService::buildConditionById($query, $params['user_group_id']);
        }

        if (isset($params['mobile']) && !empty($params['mobile'])) {
            $query->where('mobile', 'like', "%{$params['mobile']}%");
        }
        if (isset($params['regtime']) && !empty($params['regtime'])) {
            $params['regtime'] = explode(',', $params['regtime']);
            $params['regtime'][0] = date('Y-m-d 00:00:00', $params['regtime'][0]);
            $params['regtime'][1] = date('Y-m-d 23:59:59', ($params['regtime'][1]));
            $query->whereBetween('created_at', $params['regtime']);
        }


        if (!empty($params['labels'])) {
            $labelIds = explode(',', $params['labels']);
            $query->whereHas('labels', function ($query) use ($labelIds) {
                $query->whereIn('label_id', $labelIds);
            });
        }

        $list  = $query->paginate(request()->input('perPage', 20));
        $items = $list->items();
        $total = $list->total();

        foreach ($items as $k=>$v) {
            $labels = array_column($v['labels']->toArray(), 'label');
            $v->labels_name = implode(',', $labels);
        }

        return compact('items', 'total');
    }


    /**
     * 打标签
     * @return void
     */
    public function addLabel($params)
    {
        $userIds = explode(',', $params['ids']);
        $labelIds = explode(',', $params['labels']);

        foreach ($userIds as $userId){
            CrmUserLabel::where('user_id', $userId)->delete();
            $user = CrmUser::find($userId);
            foreach ($labelIds as $labelId) {
                CrmUserLabel::updateOrCreate(
                    [
                        'label_id' => $labelId,
                        'user_id' => $userId,
                    ],
                    [

                    ]
                );
            }
        }

        return true;
    }

    public function getUserLabel($params)
    {
        $userId = $params['id'];
        $labelIds = CrmUserLabel::query()->where('user_id', $userId)->pluck('label_id');

        return ['labels' => $labelIds];
    }


    /**
     * 创建用户
     * @param $params
     * @return false
     */
    public static function createUser($params)
    {
        if (empty($params)) {
            return false;
        }
        $user = CrmUser::create($params);
        return $user['id'];
    }


    /**
     * 创建用户
     * @param $params
     * @return false
     */
    public static function updateUser($params)
    {
        if (empty($params)) {
            return false;
        }
        $user = CrmUser::where('id', $params['id'])->first();
        if (empty($user)) {
            return false;
        }

        foreach ($params as $k => $v) {
            $user->$k = $v;
        }
        return $user->save();
    }

}
