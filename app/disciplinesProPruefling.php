<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class disciplinesProPruefling extends Model
{
    /**
     * Get the discipline the entry belongs to.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Discipline');
    }
    //
}
