<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parteners_id
 * @property string $name
 * @property string $value
 * @property string $type
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property Parteners $partener
 */
class PartenerSettings extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['parteners_id', 'name', 'value', 'type', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partener()
    {
        return $this->belongsTo('App\Models\Parteners', 'parteners_id');
    }
}
