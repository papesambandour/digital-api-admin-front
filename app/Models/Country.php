<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $flag
 * @property string $calling_codes
 * @property string $capital
 * @property string $code
 * @property string $state
 * @property string $updated_at
 * @property string $created_at
 * @property Operators[] $operators
 */
class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * @var array
     */
    protected $fillable = ['name', 'flag', 'calling_codes', 'capital', 'code', 'state', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operators()
    {
        return $this->hasMany('App\Models\Operators', 'countries_id');
    }
}
