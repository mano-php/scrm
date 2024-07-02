<?php

namespace Mano\Scrm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户系统分群
 */
class ScrmUserGroup extends Model
{
	use SoftDeletes;

	protected $table = 'scrm_user_group';
}
