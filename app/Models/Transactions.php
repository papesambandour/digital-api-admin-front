<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sous_services_id
 * @property int $phones_id
 * @property int $partener_comptes_id
 * @property int $parteners_id
 * @property string $type_operation
 * @property float $solde
 * @property float $commission_amount
 * @property float $fee_amount
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property string $statut
 * @property string $date_creation
 * @property string $date_success
 * @property string $date_canceled
 * @property string $date_processing
 * @property string $date_failled
 * @property string $service_name
 * @property string $message
 * @property string $transaction_id
 * @property string $external_transaction_id
 * @property string $sous_service_name
 * @property string $operateur_name
 * @property string $telephone_number_service
 * @property string $partner_compte_name
 * @property string $partener_name
 * @property string $commentaire
 * @property string $data
 * @property float $amount
 * @property string $url_ipn
 * @property string $phone
 * @property string $sous_service_transaction_id
 * @property string $data_sended_callback
 * @property string $data_response_callback
 * @property boolean $callback_is_send
 * @property string $code_sous_service
 * @property string $error_message
 * @property PartenerComptes $partenerCompte
 * @property Phones $phones
 * @property Parteners $partener
 * @property SousServices $sousService
 * @property OperationParteners[] $operationParteners
 * @property UssdExecutionMessages[] $ussdExecutionMessages
 * @property string $code_ussd_response;
 * @property string $ussd_response_match;
 * @property string $pre_statut;
 * @property string $statut_ussd_response;
 * @property string $statut_sms_response;
 * @property string $date_pre_success;
 * @property string $callback_sended_at;
 * @property string $need_check_transaction;
 * @property string $callback_ready;
 * @property string $next_send_callback_date;
 * @property string $check_transaction_response;
 * @property int $is_solde_commission;
 * @property float $solde_commission;
 * @property float $commission_amount_psp;
 * @property float $fee_amount_psp;
 * @property float $commission_amount_owner;
 * @property float $fee_amount_owner;
 * @property string $deep_link_url;
 * @property string $success_redirect_url;
 * @property string $error_redirect_url;
 * @property int $transaction_is_finish;
 * @property string $reached_timeout;
 * @property string $timeout_at;
 * @property string $rib;
 * @property string $customer_last_name;
 * @property string $customer_first_name;
 * @property string $customer_email;
 * @property int $import_bank;
 * @property string $import_bank_at;
 */
class Transactions extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['import_bank_at','import_bank','sous_services_id', 'phones_id', 'partener_comptes_id', 'parteners_id', 'type_operation', 'solde', 'commission_amount', 'fee_amount', 'created_at', 'updated_at', 'state', 'statut', 'date_creation', 'date_success', 'date_canceled', 'date_processing', 'date_failled', 'service_name', 'message', 'transaction_id', 'external_transaction_id', 'sous_service_name', 'operateur_name', 'telephone_number_service', 'partner_compte_name', 'partener_name', 'commentaire', 'data', 'amount', 'url_ipn', 'phone', 'sous_service_transaction_id', 'data_sended_callback', 'data_response_callback', 'callback_is_send', 'code_sous_service', 'error_message'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partenerCompte()
    {
        return $this->belongsTo('App\Models\PartenerComptes', 'partener_comptes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phones()
    {
        return $this->belongsTo('App\Models\Phones', 'phones_id');
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operationParteners()
    {
        return $this->hasMany('App\Models\OperationParteners', 'transactions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ussdExecutionMessages()
    {
        return $this->hasMany('App\Models\UssdExecutionMessages', 'transactions_id');
    }
}
