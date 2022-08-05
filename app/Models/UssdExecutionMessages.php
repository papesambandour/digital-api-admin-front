<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $phones_id
 * @property int $transactions_id
 * @property string $message
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property Phones $phone
 * @property Transactions $transaction
 */
class UssdExecutionMessages extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['phones_id', 'transactions_id', 'message', 'state', 'created_at', 'updated_at'];

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
    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Transactions', 'transactions_id');
    }
}
