<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_example(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/teams' , [
            'name'=>'Backend Team Two'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('team' , [
            'name' => 'Backend Team Two'
        ]);

    }


    public function test_can_assign_members_to_team(){
        $user = User::factory()->create();
        $team = Team::factory()->create();
        $member1 = User::factory()->create();
        $member2 = User::factory()->create();

        $response = $this->actingAs($user)->postJson("/api/teams/{$team->id}/assign-members" , [
            'user_ids' => [$member1->id , $member2->id]
        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('team_user' , [
            'team_id' => $team->id,
            'user_id' => $member1->id,
        ]);
    }
}
