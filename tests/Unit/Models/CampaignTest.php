<?php

namespace Tests\Unit\Models;

use App\Essp\Money;
use App\Models\Campaign;
use App\Models\Creative;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_many_creatives()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create()->first();

        //  Act
        $campaign->creatives()->SaveMany(Creative::factory(2)->create(['campaign_id' => $campaign->first()->id]));

        //  Assert
        $this->assertInstanceOf(Creative::class, $campaign->creatives->first());
    }

    public function test_it_returns_a_money_instance_for_the_daily_budget()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create()->first();

        //  Act
        //  Assert
        $this->assertInstanceOf(Money::class, $campaign->daily_budget);
    }

    public function test_it_returns_a_formatted_daily_budget()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create(['daily_budget' => 100])->first();

        //  Act
        //  Assert
        $this->assertEquals('$1.00', $campaign->daily_budget_formatted);
    }

    public function test_it_returns_daily_budget_amount()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create(['daily_budget' => 100])->first();

        //  Act
        //  Assert
        $this->assertEquals(1, $campaign->daily_budget_amount);
    }

    public function test_it_returns_a_money_instance_for_total_budget()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create()->first();

        //  Act
        //  Assert
        $this->assertInstanceOf(Money::class, $campaign->total_budget);
    }

    public function test_it_returns_a_formatted_total_budget()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create(['total_budget' => 200])->first();

        //  Act
        //  Assert
        $this->assertEquals('$2.00', $campaign->total_budget_formatted);
    }

    public function test_it_returns_total_budget_amount()
    {
        //  Arrange
        $campaign = Campaign::factory(1)->create(['total_budget' => 200])->first();

        //  Act
        //  Assert
        $this->assertEquals(2, $campaign->total_budget_amount);
    }
}
