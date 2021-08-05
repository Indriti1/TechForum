<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testCategoriesView()
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }

    public function testTopicCreateView()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)
                        ->withSession(['foo' => 'bar'])
                        ->get('/topic/create');
        $response->assertStatus(200);
    }
    public function testProfileEditView()
    {
        $response = $this->get('/profile/edit');
        $response->assertStatus(302);
    }
    public function testSearchView()
    {
        $response = $this->get('/search');
        $response->assertStatus(302);
    }
    public function testCategoriesListView()
    {
        $response = $this->get('/categories/1');
        $response->assertStatus(200);
    }
    public function testProfileUser()
    {
        $response = $this->get('/profiles/1');
        $response->assertStatus(200);
    }

}
