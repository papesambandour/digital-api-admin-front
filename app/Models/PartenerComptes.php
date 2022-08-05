<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parteners_id
 * @property string $type_partener_compte
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property string $name
 * @property string $app_key
 * @property Parteners $partener
 * @property Transactions[] $transactions
 */
class PartenerComptes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['parteners_id', 'type_partener_compte', 'created_at', 'updated_at', 'state', 'name', 'app_key'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partener()
    {
        return $this->belongsTo('App\Models\Parteners', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions', 'partener_comptes_id');
    }
}
