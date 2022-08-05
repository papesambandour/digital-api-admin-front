<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $plateforme_id
 * @property int $profils_id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $f_name
 * @property string $l_name
 * @property string $code
 * @property string $address
 * @property Plateforme $plateforme
 * @property Profils $profil
 */
class Users extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['plateforme_id', 'profils_id', 'email', 'password', 'phone', 'state', 'created_at', 'updated_at', 'f_name', 'l_name', 'code', 'address'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plateforme()
    {
        return $this->belongsTo('App\Models\Plateforme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profil()
    {
        return $this->belongsTo('App\Models\Profils', 'profils_id');
    }
}
