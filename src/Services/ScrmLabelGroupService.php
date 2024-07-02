<?php

namespace Mano\Scrm\Services;

use Mano\Scrm\Models\ScrmLabel;
use Mano\Scrm\Models\ScrmLabelGroup;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户标签分组
 *
 * @method ScrmLabelGroup getModel()
 * @method ScrmLabelGroup|\Illuminate\Database\Query\Builder query()
 */
class ScrmLabelGroupService extends AdminService
{
	protected string $modelName = ScrmLabelGroup::class;

    const LABEL_TYPE = [
        ['label' => '单选', 'value' => 1],
        ['label' => '多选', 'value' => 2],
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

        foreach ($items as $k=>$v) {
            $v->labels_name = implode(',', $v['labels']->toArray());
        }

        return compact('items', 'total');
    }


    /**
     * 修改
     *
     * @param $primaryKey
     * @param $data
     *
     * @return bool
     */
    public function update($primaryKey, $data)
    {
        $this->saving($data, $primaryKey);
        $labels = $data['labels'] ?? [];
        $model = $this->query()->whereKey($primaryKey)->first();

        foreach ($data as $k => $v) {
            if (!$this->hasColumn($k)) {
                continue;
            }

            $model->setAttribute($k, $v);
        }

        $result = $model->save();

        $this->bindLabels($labels, $primaryKey, true);
        if ($result) {
            $this->saved($model, true);
        }

        return $result;
    }

    /**
     * 新增
     *
     * @param $data
     *
     * @return bool
     */
    public function store($data)
    {
        $this->saving($data);

        $labels = $data['labels'] ?? [];
        $model = $this->getModel();

        foreach ($data as $k => $v) {
            if (!$this->hasColumn($k)) {
                continue;
            }

            $model->setAttribute($k, $v);
        }

        $result = $model->save();
        $this->bindLabels($labels, $model['id'], false);
        if ($result) {
            $this->saved($model);
        }

        return $result;
    }

    public function bindLabels($labels, $groupId, $isEdit = false)
    {
        if (!empty($labels)) {

            if (!$isEdit) {
                foreach ($labels as $label) {
                    ScrmLabel::create([
                        'group_id' => $groupId,
                        'label'    => $label,
                    ]);
                }
            }else{
                $oldLabels = ScrmLabel::query()->where('group_id', $groupId)->pluck('id', 'label');

                foreach ($labels as $label) {
                    if (!isset($oldLabels[$label])) {
                        ScrmLabel::create([
                            'group_id' => $groupId,
                            'label'    => $label,
                        ]);
                    }
                }

                foreach ($oldLabels as $label => $labelId) {
                    if (!in_array($label, $labels)) {
                        ScrmLabel::where('id', $labelId)->delete();
                    }
                }
            }

        }
    }

}
