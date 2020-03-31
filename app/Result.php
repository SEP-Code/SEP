<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

    /**
     * Get the candidate to which the result belongs.
     */
    public function candidate()
    {
        return $this->belongsTo('App\PersDatenPruefling');
    }
    //

    /**
     * Get the Errorcode to which the result belongs.
     */
    public function errorCode()
    {
        return $this->belongsTo('App\ErrorCode');
    }
    //

    /**
     * Get the discipline to which the result belongs.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Discipline');
    }
    //
}
