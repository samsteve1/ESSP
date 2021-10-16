<?php

namespace App\Traits;

use App\Models\Creative;

trait HasCreative
{
    public function creatives()
    {
        return $this->hasMany(Creative::class);
    }
}
