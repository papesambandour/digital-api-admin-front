<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $operators_id
 * @property int $categories_services_id
 * @property string $name
 * @property string $icon
 * @property string $code
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $accecpte_phone
 * @property float $solde
 * @property float $amount_reserved
 * @property float $alert_level_1_solde
 * @property float $alert_level_2_solde
 * @property float $alert_level_3_solde
 * @property float $alert_level_4_solde
 * @property float $alert_level_5_solde
 * @property Operators $operator
 * @property CategoriesServices $categoriesService
 * @property Phones[] $phones
 * @property SousServices[] $sousServices
 */
class Services extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['operators_id', 'categories_services_id', 'name', 'icon', 'code', 'state', 'created_at', 'updated_at', 'accecpte_phone', 'solde', 'amount_reserved', 'alert_level_1_solde', 'alert_level_2_solde', 'alert_level_3_solde', 'alert_level_4_solde', 'alert_level_5_solde'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator()
    {
        return $this->belongsTo('App\Models\Operators', 'operators_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriesService()
    {
        return $this->belongsTo('App\Models\CategoriesServices', 'categories_services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany('App\Models\Phones', 'services_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousServices()
    {
        return $this->hasMany('App\Models\SousServices', 'services_id');
    }
}
