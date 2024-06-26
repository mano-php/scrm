<?php

namespace Mano\Crm\Services;

use Mano\Crm\Models\CrmLabel;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 客户标签
 *
 * @method CrmLabel getModel()
 * @method CrmLabel|\Illuminate\Database\Query\Builder query()
 */
class CrmLabelService extends AdminService
{
	protected string $modelName = CrmLabel::class;

	public function searchable($query)
	{
		parent::searchable($query);

		$query->when($this->request->input('group_id'), fn($q) => $q->whereIn('group_id', safe_explode(',', $this->request->input('group_id'))));
		$query->when($this->request->input('label'), fn($q) => $q->where('label', 'like', '%' . $this->request->input('label') . '%'));
	}
}