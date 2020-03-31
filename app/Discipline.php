<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{

    /**
     * Get the sport to wich the discipline belongs.
     */
    public function sport()
    {
        return $this->belongsTo('App\Sport');
    }
    //
    /**
 * Get the error codes belonging to this discipline.
 */
    public function errorCodes()
    {
        return $this->hasMany('App\ErrorCode');
    }

    /**
     * Get the participants wich joined this discipline.
     */
    public function participants()
    {
        return $this->hasMany('App\disciplinesProPruefling');
    }

    /**
     * Get the results for the discipline.
     */
    public function results()
    {
        return $this->hasMany('App\Result');
    }


}
