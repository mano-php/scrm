<?php

namespace Mano\Crm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户标签
 */
class CrmLabel extends Model
{
//	use SoftDeletes;

	protected $table = 'crm_label';
    protected $fillable = ['id', 'label', 'group_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['group_id' => 'integer'];

}
