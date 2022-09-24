<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $regex
 * @property string $code
 * @property string $message
 * @property string $index
 * @property int $is_critic
 * @property int $is_json
 * @property int $sous_services_id
 * @property string $created_at
 * @property string $updated_at
 * @property SousServices $sousService
 */
class ErrorType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['regex', 'code','message','index','is_critic','is_json','sous_services_id', 'state', 'created_at', 'updated_at'];



    /**
     * @return BelongsTo
     */
    public function sousService(): BelongsTo
    {
        return $this->belongsTo(SousServices::class, 'sous_services_id');
    }
}
