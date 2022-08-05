<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property ActionsProfils[] $actionsProfils
 * @property Users[] $users
 */
class Profils extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionsProfils()
    {
        return $this->hasMany('App\Models\ActionsProfils', 'profils_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\Users', 'profils_id');
    }
}
