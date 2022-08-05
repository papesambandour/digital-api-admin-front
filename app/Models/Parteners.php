<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property float $solde
 * @property float $amount_reserved
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $adress
 * @property string $password
 * @property boolean $first_connection
 * @property string $password_expired
 * @property int $password_duration_day
 * @property Commission[] $commissions
 * @property OperationParteners[] $operationParteners
 * @property PartenerComptes[] $partenerComptes
 * @property PartenerSettings[] $partenerSettings
 * @property SousServicesParteners[] $sousServicesParteners
 * @property Transactions[] $transactions
 */
class Parteners extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'state', 'solde', 'amount_reserved', 'name', 'phone', 'email', 'adress', 'password', 'first_connection', 'password_expired', 'password_duration_day'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commissions()
    {
        return $this->hasMany('App\Models\Commissions', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operationParteners()
    {
        return $this->hasMany('App\Models\OperationParteners', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partenerComptes()
    {
        return $this->hasMany('App\Models\PartenerComptes', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partenerSettings()
    {
        return $this->hasMany('App\Models\PartenerSettings', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServicesParteners()
    {
        return $this->hasMany('App\Models\SousServicesParteners', 'parteners_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions', 'parteners_id');
    }
}
