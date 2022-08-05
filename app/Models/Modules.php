<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $modules_id
 * @property string $name
 * @property string $code
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property Modules $module
 * @property Actions[] $actions
 */
class Modules extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['modules_id', 'name', 'code', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo('App\Models\Modules', 'modules_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany('App\Models\Actions', 'modules_id');
    }
}
