<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Http\Controllers\HomeController;
use App\User;

class homeTest extends TestCase
{
    /**
     * Testing home url without auth
     *
     * @return void
     */
    public function testHome() {
        
        //no user login. redirect
        $response = $this->get('/home');

        $response->assertStatus(302);
        
    }
    
    /**
     * Testing home url with auth
     *
     * @return void
     */
    public function testHomeAuth() {
        
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->get('/home');

        $response->assertStatus(200);
        
    }
    
    /**
     * Testing fetch report url json.
     *
     * @return void
     */
    public function testFetchReportAuth() {
        
        //user logged in success.
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->json('GET', '/fetchReport');

        $response->assertStatus(200)
                ->assertJson([]);
        
    }
}
