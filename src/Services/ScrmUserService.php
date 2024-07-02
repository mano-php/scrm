<?php

namespace Mano\Scrm\Services;

use Mano\Scrm\Models\ScrmUser;
use Mano\Scrm\Models\ScrmUserGroup;
use Mano\Scrm\Models\ScrmUserLabel;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户管理
 *
 * @method ScrmUser getModel()
 * @method ScrmUser|\Illuminate\Database\Query\Builder query()
 */
class ScrmUserService extends AdminService
{
    protected string $modelName = ScrmUser::class;

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
            ScrmUserGroupService::buildConditionById($query, $params['user_group_id']);
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
            $group_labels = ScrmUserGroupService::getUserGroupLabel(strtotime($v['luck_date']));
            $group_label_names = [];
            foreach ($group_labels as $group_label){
                $group_label_names[] = ScrmUserGroupService::GROUP_TYPE[$group_label];
            }
            $v->group_labels = implode(',', $group_label_names);
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
            ScrmUserLabel::where('user_id', $userId)->delete();
            $user = ScrmUser::find($userId);
            foreach ($labelIds as $labelId) {
                ScrmUserLabel::updateOrCreate(
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
        $labelIds = ScrmUserLabel::query()->where('user_id', $userId)->pluck('label_id');

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
        $user = ScrmUser::create($params);
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
        $user = ScrmUser::where('id', $params['id'])->first();
        if (empty($user)) {
            return false;
        }

        foreach ($params as $k => $v) {
            $user->$k = $v;
        }
        return $user->save();
    }


    /**
     * saving 钩子 (执行于新增/修改前)
     *
     * 可以通过判断 $primaryKey 是否存在来判断是新增还是修改
     *
     * @param $data
     * @param $primaryKey
     *
     * @return void
     */
    public function saving(&$data, $primaryKey = '')
    {
        if (!empty($data['avatar'])) {
            if (mb_strpos($data['avatar'], 'upload') === false) {
                $data['avatar'] = "uploads/{$data['avatar']}";
            }
        }
    }

}
