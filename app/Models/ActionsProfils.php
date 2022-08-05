<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $actions_id
 * @property int $profils_id
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property Actions $action
 * @property Profils $profil
 */
class ActionsProfils extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['actions_id', 'profils_id', 'state', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo('App\Models\Actions', 'actions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profil()
    {
        return $this->belongsTo('App\Models\Profils', 'profils_id');
    }
}
