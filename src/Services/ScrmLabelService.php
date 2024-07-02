<?php

namespace ManoCode\Scrm\Services;

use ManoCode\Scrm\Models\ScrmLabel;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户标签
 *
 * @method ScrmLabel getModel()
 * @method ScrmLabel|\Illuminate\Database\Query\Builder query()
 */
class ScrmLabelService extends AdminService
{
	protected string $modelName = ScrmLabel::class;

	public function searchable($query)
	{
		parent::searchable($query);

		$query->when($this->request->input('group_id'), fn($q) => $q->whereIn('group_id', safe_explode(',', $this->request->input('group_id'))));
		$query->when($this->request->input('label'), fn($q) => $q->where('label', 'like', '%' . $this->request->input('label') . '%'));
	}
}
