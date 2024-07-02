<?php

namespace Mano\Scrm\Services;

use DateTime;
use Mano\Scrm\Models\ScrmUser;
use Mano\Scrm\Models\ScrmUserGroup;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户系统分群
 *
 * @method ScrmUserGroup getModel()
 * @method ScrmUserGroup|\Illuminate\Database\Query\Builder query()
 */
class ScrmUserGroupService extends AdminService
{
    protected string $modelName = ScrmUserGroup::class;
    const UP_TYPE = [
        ['label' => '每天更新', 'value' => 1],
        ['label' => '每周更新', 'value' => 2],
        ['label' => '每月更新', 'value' => 3],
    ];

    const GROUP_TYPE = [
        1 => '新会员',
        2 => '老会员',
        3 => '本月入会周年',
        4 => '下月入会周年',
        5 => '生日当天客户',
        6 => '本周生日客户',
        7 => '本月生日客户',
        8 => '下月生日客户',
    ];

    /**
     * 列表 获取数据
     *
     * @return array
     */
    public function list()
    {
        $query = $this->listQuery();

        $list  = $query->paginate(request()->input('perPage', 20));
        $items = $list->items();
        $total = $list->total();

        foreach ($items as $v) {
            $query = ScrmUser::query();
            self::buildConditionById($query, $v->id);
            $v->people_num = $query->count();
        }

        return compact('items', 'total');
    }


    public static function buildConditionById(&$query, $id)
    {
        // 1	新会员
        //2	老会员
        //3	本月入会周年
        //4	下月入会周年
        //5	生日当天客户
        //6	本周生日客户
        //7	本月生日客户
        //8	下月生日客户
        switch ($id) {
            case 1:
                $query->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', strtotime('-3 day')),
                    date('Y-m-d 23:59:59', time())
                ]);
                break;
            case 2:
                $query->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', strtotime('-9999 day')),
                    date('Y-m-d 23:59:59', strtotime('-4 day'))
                ]);
                break;
            case 3:
                //入会时间是本月月份的会员
                // 获取本月的开始和结束时间
                $monthstart = date('Y-m-01 00:00:00');
                $monthend = date('Y-m-t 23:59:59');

                $query->whereBetween('created_at', [
                    $monthstart,
                    $monthend
                ]);
                break;
            case 4:
                $condition = [
                    'created_at' => [
                        '=',
                        -1
                    ]
                ];
                break;
            case 5:
                $query->whereBetween('luck_date', [
                    date('Y-m-d', time()),
                    date('Y-m-d', time())
                ]);
                break;
            case 6:
                // 获取本周的开始和结束时间
                $date = new DateTime();
                $weekstart = $date->setISODate($date->format('Y'), $date->format('W'), 1)->format('Y-m-d');
                $weekend = $date->setISODate($date->format('Y'), $date->format('W'), 7)->format('Y-m-d');

                $query->whereBetween('luck_date', [
                    $weekstart,
                    $weekend
                ]);
                break;
            case 7:
                // 获取本月的开始和结束时间
                $monthstart = date('Y-m-01');
                $monthend = date('Y-m-t');

                $query->whereBetween('luck_date', [
                    $monthstart,
                    $monthend
                ]);
                break;
            case 8:
                // 获取本月的开始和结束时间
                $nextmonthstart = date('Y-m-d', strtotime('first day of next month'));
                $nextmonthend = date('Y-m-d', strtotime('last day of next month'));

                $query->whereBetween('luck_date', [
                    $nextmonthstart,
                    $nextmonthend
                ]);
                break;
        }

    }


    public static function getUserGroupLabel($joinAt)
    {
        $labels = [];
        foreach ([1,2,3,4,5,6,7,8] as $id) {
            switch ($id) {
                case 1:
                    if ($joinAt > strtotime('-3 day') && $joinAt < time()) {
                        $labels[] = 1;
                    }
                    break;
                case 2:
                    if ($joinAt > strtotime('-9999 day') && $joinAt < strtotime('-4 day')) {
                        $labels[] = 2;
                    }
                    break;
                case 3:
                    $monthstart = strtotime(date('Y-m-01 00:00:00'));
                    $monthend = strtotime(date('Y-m-t 23:59:59'));
                    if ($joinAt > $monthstart && $joinAt < $monthend) {
                        $labels[] = 3;
                    }
                    break;
                case 4:
                    $condition = [
                        'created_at' => [
                            '=',
                            -1
                        ]
                    ];
                    break;
                case 5:
                    if (date('Y-m-d', $joinAt) == date('Y-m-d', time())) {
                        $labels[] = 5;
                    }
                    break;
                case 6:
                    // 获取本周的开始和结束时间
                    $date = new DateTime();
                    $weekstart = $date->setISODate($date->format('Y'), $date->format('W'), 1)->format('Y-m-d');
                    $weekend = $date->setISODate($date->format('Y'), $date->format('W'), 7)->format('Y-m-d');

                    if ($joinAt > strtotime($weekstart) && $joinAt < strtotime($weekend)) {
                        $labels[] = 6;
                    }
                    break;
                case 7:
                    // 获取本月的开始和结束时间
                    $monthstart = strtotime(date('Y-m-01'));
                    $monthend = strtotime(date('Y-m-t'));
                    if ($joinAt > $monthstart && $joinAt < $monthend) {
                        $labels[] = 7;
                    }
                    break;
                case 8:
                    // 获取本月的开始和结束时间
                    $nextmonthstart = strtotime('first day of next month');
                    $nextmonthend = strtotime('last day of next month');

                    if ($joinAt > $nextmonthstart && $joinAt < $nextmonthend) {
                        $labels[] = 8;
                    }
                    break;
            }
        }

        return $labels;
    }

    public function getUserGroupUsers($id)
    {
        dd($id);

    }
}
