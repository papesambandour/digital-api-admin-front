<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sous_services_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property boolean $is_matched
 * @property int $phones_id
 * @property SousServices $sousService
 */
class MessageUssds extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sous_services_id', 'content', 'created_at', 'updated_at', 'state', 'is_matched', 'phones_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousService()
    {
        return $this->belongsTo('App\Models\SousServices', 'sous_services_id');
    }
}
