<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $phones_id
 * @property string $message
 * @property string $state
 * @property string $activity
 * @property string $created_at
 * @property string $updated_at
 * @property Phones $phone
 */
class ActivitiesPhones extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['phones_id', 'message', 'state', 'activity', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function phone(): BelongsTo
    {
        return $this->belongsTo('App\Models\Phones', 'phones_id');
    }
}
