<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    /**
     * Get the disciplines beloging to this sport
     */
    public function disciplines()
    {
        return $this->hasMany('App\Discipline');
    }
    //
}
