<?php

namespace Mano\Scrm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户标签
 */
class ScrmLabel extends Model
{
//	use SoftDeletes;

	protected $table = 'scrm_label';
    protected $fillable = ['id', 'label', 'group_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['group_id' => 'integer'];

}
