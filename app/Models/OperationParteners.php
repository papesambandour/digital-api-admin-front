<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parteners_id
 * @property int $transactions_id
 * @property string $commentaire
 * @property float $amount
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $type_operation
 * @property string $statut
 * @property string $date_creation
 * @property string $date_success
 * @property string $date_canceled
 * @property string $date_processing
 * @property string $date_failled
 * @property string $operation
 * @property float $solde_befor
 * @property float $solde_after
 * @property float $fee
 * @property float $commission
 * @property Transactions $transaction
 * @property Parteners $partener
 * @property int $users_id
 * @property Users $user
 * @property string $attachment_path
 * @property string $link
 */
class OperationParteners extends Model
{
    public function link():Attribute{
        return   Attribute::make(fn()=> $this->attachment_path ? env('PROXY_URL') . "/storage/". $this->attachment_path : null) ;
    }
    public function user():Attribute{
        return  Attribute::make(fn()=> Users::find($this->users_id));
    }
    /**
     * @var array
     */
    protected $fillable = ['attachment_path','users_id','parteners_id', 'transactions_id', 'commentaire', 'amount', 'state', 'created_at', 'updated_at', 'type_operation', 'statut', 'date_creation', 'date_success', 'date_canceled', 'date_processing', 'date_failled', 'operation', 'solde_befor', 'solde_after', 'fee', 'commission'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transactions', 'transactions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partener()
    {
        return $this->belongsTo('App\Models\Parteners', 'parteners_id');
    }
}
