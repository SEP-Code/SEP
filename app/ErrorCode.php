<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorCode extends Model
{
    /**
     * Get the discipline to wich the error code belongs.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Discipline');
    }
    //

    /**
     * Get the discipline to wich the error code belongs.
     */
    public function results()
    {
        return $this->hasMany('App\Result');
    }
    //
}
