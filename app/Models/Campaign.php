<?php

namespace App\Models;

use Carbon\Carbon;
use App\Essp\Money;
use App\Traits\HasCreative;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, HasCreative;
    protected $fillable = ['name', 'to', 'from', 'total_budget', 'daily_budget'];


    public function getTotalBudgetAttribute($value)
    {
        return new Money($value);
    }

    /**
     * Return the total budget formatted in USD.
     */
    public function getTotalBudgetFormattedAttribute()
    {
        return $this->total_budget->formatted();
    }

    /**
     * Return the total budget amount in float format
     */
    public function getTotalBudgetAmountAttribute()
    {
        return $this->total_budget->amount() / 100;
    }

    public function getDailyBudgetAttribute($value)
    {
        return new Money($value);
    }

    /**
     * Return the daily budget formatted in USD.
     */
    public function getDailyBudgetFormattedAttribute()
    {
        return $this->daily_budget->formatted();
    }

    /**
     * Return the daily budget in float format.
     */
    public function getDailyBudgetAmountAttribute()
    {
        return $this->daily_budget->amount() / 100;
    }
}
