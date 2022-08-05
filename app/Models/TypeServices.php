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
 * @property string $type_operation
 * @property SousServices[] $sousServices
 */
class TypeServices extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'state', 'created_at', 'updated_at', 'type_operation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServices()
    {
        return $this->hasMany('App\Models\SousServices', 'type_services_id');
    }
}
