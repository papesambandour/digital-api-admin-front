<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sous_services_id
 * @property int $parteners_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property Parteners $partener
 * @property SousServices $sousService
 */
class SousServicesParteners extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sous_services_id', 'parteners_id', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partener()
    {
        return $this->belongsTo('App\Models\Parteners', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousService()
    {
        return $this->belongsTo('App\Models\SousServices', 'sous_services_id');
    }
}
