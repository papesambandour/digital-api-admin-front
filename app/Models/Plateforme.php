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
 * @property Users[] $users
 */
class Plateforme extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plateforme';

    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\Users');
    }
}
