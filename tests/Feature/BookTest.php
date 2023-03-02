<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // new
        $response = $this->postJson('/api/book/', [
            "data" => [
                "name" => "Test2",
                "another" => "TestUser2",
                "price" => 120 
            ]
        ]);
        $response->assertStatus(200);
        $response-> assertJson(['success'=> true]);

        $content = $response->getContent();
        $data = json_decode($content, true); 
        $id = $data['msg']['id'];

        // // update
        $response = $this->putJson('/api/book/', [
            "data" => [
                "id" => $id,
                "name" => "Test{$id}update",
                "another" => "TestUser{$id}",
                "price" => 120 
            ]
        ]);
        $response->assertStatus(200);

        $response = $this->get("/api/book/${id}");

        $response->
            assertStatus(200) ->
            assertJson([
                'success' => true,
            ])->
            assertJson([
                'msg'=> [
                    'id' => $id
                ]
            ]);

        $response-> assertJson(fn (AssertableJson $json) =>
            $json
                ->has('success')
                ->has('msg', fn (AssertableJson $json) =>
                    $json->where('id', $id)
                         ->etc()
                 )
        );

        $response->assertJsonPath('msg.id', $id);

        // delete 

        $content = $response->getContent();
        $data = json_decode($content, true); 
        $model = $data['msg'];
        $response = $this->deleteJson('/api/book/', [
            "data" => (array)$model
        ]);
        $response->assertStatus(200);

        $response-> assertJson(['success'=> true]);
    }
}
