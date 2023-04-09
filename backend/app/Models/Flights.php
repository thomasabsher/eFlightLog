<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flights extends Model {
    protected static $unguarded = true;

    public function aircraft(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Aircrafts::class, 'aircraft');
    }

}

