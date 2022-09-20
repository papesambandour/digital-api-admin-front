<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $phones_id
 * @property int $operation_phones_id
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
 * @property float $solde_before
 * @property float $solde_after
 * @property Phones $phone
 * @property OperationPhones $operationPhone
 * @property Users $user
 * @property string $attachment_path
 * @property string $link
 */
class OperationPhones extends Model
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
    protected $fillable = ['attachment_path','users_id','phones_id', 'operation_phones_id', 'commentaire', 'amount', 'state', 'created_at', 'updated_at', 'type_operation', 'statut', 'date_creation', 'date_success', 'date_canceled', 'date_processing', 'date_failled', 'operation', 'solde_before', 'solde_after'];

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
    public function operationPhone()
    {
        return $this->belongsTo('App\Models\OperationPhones', 'operation_phones_id');
    }
}
