<?php

namespace Mano\Crm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户系统分群
 */
class CrmUserGroup extends Model
{
	use SoftDeletes;

	protected $table = 'crm_user_group';
}