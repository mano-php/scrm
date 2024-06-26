<?php

namespace Mano\Crm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 客户管理
 */
class CrmUser extends Model
{
	use SoftDeletes;

	protected $table = 'crm_user';

    protected $hidden = ['deleted_at'];
    protected $fillable = ['id', 'nickname', 'avatar', 'luck_date', 'sex', 'level', 'mobile', 'channel', 'state', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['id' => 'integer', 'sex' => 'integer', 'level' => 'integer', 'mobile' => 'string', 'channel' => 'integer', 'state' => 'integer', 'luck_date' => 'date', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime'];




    public function labels()
    {
        return $this->belongsToMany(CrmLabel::class, CrmUserLabel::class, 'user_id', 'label_id');
    }



}
