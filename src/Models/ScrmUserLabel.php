<?php

namespace Mano\Scrm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户标签
 */
class ScrmUserLabel extends Model
{
//	use SoftDeletes;

	protected $table = 'scrm_user_label';
    protected $fillable = ['id', 'user_id', 'label_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['user_id' => 'integer', 'label_id' => 'integer'];


}
