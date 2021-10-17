<?php

namespace Database\Factories;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(5, true),
            'daily_budget' => rand(299, 1050),
            'total_budget' => rand(6523, 205645),
            'from' => now(),
            'to' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '10 days', $timezone = null)
        ];
    }
}
