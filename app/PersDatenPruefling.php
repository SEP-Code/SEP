<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersDatenPruefling extends Model
{
    protected $fillable = [
        'attest',  'kontoauszug', 'passbild', 'einvErkl', 'wDok'
    ];

    /**
     * Get the results revered to the candidate
     */
    public function results()
    {
        return $this->hasMany('App\Result');
    }

    /**
     * Get the user revered to the candidate
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }




}
