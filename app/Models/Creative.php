<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;
    protected $fillable = ['path'];
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
