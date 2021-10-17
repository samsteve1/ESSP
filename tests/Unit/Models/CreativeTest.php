<?php

namespace Tests\Unit\Models;

use App\Models\Campaign;
use App\Models\Creative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreativeTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_a_campaign()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create();

        //  Act
        $creative = Creative::factory(1)->create(['campaign_id' => $campaign->first->id])->first();

        //  Assert
        $this->assertInstanceOf(Campaign::class, $creative->campaign->first());
    }
}
