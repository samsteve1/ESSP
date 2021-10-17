<?php

namespace Tests\Feature\Campaign;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignIndexTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_returns_a_collection_of_campaigns()
    {
        //  Arrange
        $campaigns = Campaign::factory(2)->create()->first();

        //  Act
        //  Assert
        $this->json('GET', 'api/campaigns')
            ->assertJsonFragment([
                'id' => $campaigns->id
            ]);
    }

    function test_it_orders_campaigns_by_the_latest_first()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create()->first();
        $campaign2 = Campaign::factory(1)->create(['created_at' => now()->subDay()])->first();

        //  Act
        //  Assert
        $this->json('GET', 'api/campaigns')
            ->assertSeeInOrder([
                $campaign->id,
                $campaign2->id
            ]);
    }
}
