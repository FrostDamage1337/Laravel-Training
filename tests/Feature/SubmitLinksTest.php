<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmitLinksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    function guest_can_submit_a_new_link() {
        $response = $this->post('/submit', [
            'title' => 'Example Title',
            'url' => 'http://example.com',
            'description' => 'Example description',
        ]);

        $this->assertDatabaseHas('links', [
            'title' => 'Example Title',
        ]);

        $response
            ->assertStatus(302)
            ->assertHeader('Location', url('/'));

        $this
            ->get('/')
            ->assertSee('Example Title');
    }

    /** @test */
    function link_is_not_created_if_validation_fails() {
        $response = $this->post('/submit');

        $response->assertSessionHasErrors([ 'title', 'url', 'description' ]);
    }
}
