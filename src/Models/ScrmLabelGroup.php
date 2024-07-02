<?php

namespace Mano\Scrm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户标签分组
 */
class ScrmLabelGroup extends Model
{
	use SoftDeletes;

	protected $table = 'scrm_label_group';
    protected $fillable = ['id', 'group_name', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = [
        'labels',
    ];

    public function getLabelsAttribute()
    {
        return $this->hasMany(ScrmLabel::class, 'group_id', 'id')->pluck('label');
    }
}
