<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $services_id
 * @property int $type_services_id
 * @property string $name
 * @property string $ussd_code
 * @property string $regex_message_validation
 * @property string $position_validation_index
 * @property int $valid_ength
 * @property string $icon
 * @property string $code
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property float $max_limit_transaction
 * @property float $max_limit_day
 * @property float $max_limit_week
 * @property float $max_limit_month
 * @property float $max_limit_trimest
 * @property string $type_operation
 * @property string $regex_phone
 * @property string $message_retour_ussd
 * @property TypeServices $typeService
 * @property Services $service
 * @property Commission[] $commissions
 * @property MessageUssds[] $messageUssds
 * @property SousServicesParteners[] $sousServicesParteners
 * @property SousServicesPhones[] $sousServicesPhones
 * @property Transactions[] $transactions
 * @property int $need_phone;
 * @property int $has_solde_api;
 * @property string $api_manager_class_name;
 * @property string api_manager_namespace$;
 * @property float $amount_commssion;
 * @property float $taux_commission
 * @property float $taux_fee;
 * @property float $amount_fee
 * @property int $pending_timeout;
 * @property string $pre_status_error_type;
 * @property string $status_error_type;
 * @property string $pre_status_success_type;
 * @property string $status_success_type;
 * @property string $pre_status_timeout_type;
 * @property string $status_timeout_type;
 * @property string $when_pre_status_for_callback;
 * @property string $when_status_for_callback;
 */
class SousServices extends Model
{
    public static $snakeAttributes= false;
    /**
     * @var array
     */
    protected $fillable = ['services_id', 'type_services_id', 'name', 'ussd_code', 'regex_message_validation', 'position_validation_index', 'valid_ength', 'icon', 'code', 'state', 'created_at', 'updated_at', 'max_limit_transaction', 'max_limit_day', 'max_limit_week', 'max_limit_month', 'max_limit_trimest', 'type_operation', 'regex_phone', 'message_retour_ussd'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeService()
    {
        return $this->belongsTo('App\Models\TypeServices', 'type_services_id');
    }

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
    public function commissions()
    {
        return $this->hasMany('App\Models\Commissions', 'sous_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messageUssds()
    {
        return $this->hasMany('App\Models\MessageUssds', 'sous_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServicesParteners()
    {
        return $this->hasMany('App\Models\SousServicesParteners', 'sous_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServicesPhones()
    {
        return $this->hasMany('App\Models\SousServicesPhones', 'sous_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions', 'sous_services_id');
    }
}
