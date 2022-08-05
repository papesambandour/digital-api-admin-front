<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $icon
 * @property string $state
 * @property string $updated_at
 * @property string $created_at
 * @property Services[] $services
 */
class CategoriesServices extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'icon', 'state', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\Models\Services', 'categories_services_id');
    }
}
