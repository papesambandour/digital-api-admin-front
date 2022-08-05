<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parteners_id
 * @property int $sous_services_id
 * @property float $amount_start
 * @property float $amount_end
 * @property float $amount_commssion
 * @property float $taux_commission
 * @property float $taux_fee
 * @property float $amount_fee
 * @property boolean $commission_is_fixe
 * @property boolean $fee_is_fixe
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property SousServices $sousService
 * @property Parteners $partener
 */
class Commission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commission';

    /**
     * @var array
     */
    protected $fillable = ['parteners_id', 'sous_services_id', 'amount_start', 'amount_end', 'amount_commssion', 'taux_commission', 'taux_fee', 'amount_fee', 'commission_is_fixe', 'fee_is_fixe', 'created_at', 'updated_at', 'state'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousService()
    {
        return $this->belongsTo('App\Models\SousServices', 'sous_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partener()
    {
        return $this->belongsTo('App\Models\Parteners', 'parteners_id');
    }
}
