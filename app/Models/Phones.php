<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $services_id
 * @property float $solde
 * @property string $number
 * @property string $codeSecret
 * @property string $pin
 * @property string $ltd
 * @property string $lgd
 * @property string $imei
 * @property string $uid
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $socket
 * @property float $amount_reserved
 * @property float $max_solde
 * @property float $alert_level_1_solde
 * @property float $alert_level_2_solde
 * @property float $alert_level_3_solde
 * @property float $alert_level_4_solde
 * @property float $alert_level_5_solde
 * @property string $phone_state
 * @property string $last_used
 * @property string $last_unused
 * @property Services $service
 * @property ActivitiesPhones[] $activitiesPhones
 * @property OperationPhones[] $operationPhones
 * @property SousServicesPhones[] $sousServicesPhones
 * @property Transactions[] $transactions
 * @property UssdExecutionMessages[] $ussdExecutionMessages
 * @property string $sim_provider
 */
class Phones extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sim_provider','services_id', 'solde', 'number', 'codeSecret', 'pin', 'ltd', 'lgd', 'imei', 'uid', 'state', 'created_at', 'updated_at', 'socket', 'amount_reserved', 'max_solde', 'alert_level_1_solde', 'alert_level_2_solde', 'alert_level_3_solde', 'alert_level_4_solde', 'alert_level_5_solde', 'phone_state', 'last_used', 'last_unused'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Services', 'services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activitiesPhones()
    {
        return $this->hasMany('App\Models\ActivitiesPhones', 'phones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operationPhones()
    {
        return $this->hasMany('App\Models\OperationPhones', 'phones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServicesPhones()
    {
        return $this->hasMany('App\Models\SousServicesPhones', 'phones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions', 'phones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ussdExecutionMessages()
    {
        return $this->hasMany('App\Models\UssdExecutionMessages', 'phones_id');
    }
}
