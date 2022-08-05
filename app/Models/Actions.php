<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $modules_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $code
 * @property string $method
 * @property string $url
 * @property string $icon
 * @property Modules $module
 * @property ActionsProfils[] $actionsProfils
 */
class Actions extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['modules_id', 'state', 'created_at', 'updated_at', 'name', 'code', 'method', 'url', 'icon'];

    /**
     * @return BelongsTo
     */
    public function module()
    {
        return $this->belongsTo('App\Models\Modules', 'modules_id');
    }

    /**
     * @return HasMany
     */
    public function actionsProfils(): HasMany
    {
        return $this->hasMany('App\Models\ActionsProfils', 'actions_id');
    }
}
