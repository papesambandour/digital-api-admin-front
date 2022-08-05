<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $countries_id
 * @property string $name
 * @property string $icon
 * @property string $code
 * @property string $state
 * @property string $updated_at
 * @property string $created_at
 * @property Country $country
 * @property Services[] $services
 */
class Operators extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['countries_id', 'name', 'icon', 'code', 'state', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'countries_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\Models\Services', 'operators_id');
    }
}
