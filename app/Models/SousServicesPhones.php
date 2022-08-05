<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sous_services_id
 * @property int $phones_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property Phones $phone
 * @property SousServices $sousService
 */
class SousServicesPhones extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sous_services_id', 'phones_id', 'created_at', 'updated_at', 'state'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phone()
    {
        return $this->belongsTo('App\Models\Phones', 'phones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousService()
    {
        return $this->belongsTo('App\Models\SousServices', 'sous_services_id');
    }
}
