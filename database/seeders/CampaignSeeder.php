<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Creative;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaign::factory(5)->has(Creative::factory(3))->create();
    }
}
