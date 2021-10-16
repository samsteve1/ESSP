<?php

namespace App\Models;

use App\Traits\HasCreative;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory, HasCreative;
    protected $fillable = ['name', 'to', 'from', 'total_budget', 'daily_budget'];
}
