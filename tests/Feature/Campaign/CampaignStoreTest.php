<?php

namespace Tests\Feature\Campaign;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_a_name()
    {

        $this->json('POST', 'api/campaigns', [
            'to' => now(),
            'from' => now(),
            'daily_budget' => 100,
            'total_budget' => 200
        ])
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_daily_budget()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'to' => now(),
            'from' => now(),
            'total_budget' => 100
        ])->assertJsonValidationErrors(['daily_budget']);
    }

    public function test_it_requires_a_numeric_daily_budget()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'to' => now(),
            'from' => now(),
            'daily_budget' => 'abc',
            'total_budget' => 100
        ])->assertJsonValidationErrors(['daily_budget']);
    }

    public function test_it_requires_a_total_budget()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'to' => now(),
            'from' => now(),
            'daily_budget' => 100,
        ])->assertJsonValidationErrors(['total_budget']);
    }

    public function test_it_requires_a_numeric_total_budget()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'to' => now(),
            'from' => now(),
            'daily_budget' => 100,
            'total_budget' => 'abc'
        ])->assertJsonValidationErrors(['total_budget']);
    }

    public function test_it_requires_a_start_date()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'to' => now(),
            'daily_budget' => 100,
            'total_budget' => 200
        ])->assertJsonValidationErrors(['from']);
    }
    public function test_it_requires_an_end_date()
    {
        $this->json('POST', 'api/campaigns', [
            'name' => 'test',
            'from' => now(),
            'daily_budget' => 100,
            'total_budget' => 200
        ])->assertJsonValidationErrors(['to']);
    }
}
