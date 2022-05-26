<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNewBloPostDoesNotHaveComments()
    {
        $this->blogPost();

        $response = $this->actingAs($this->user(), 'api')->json('GET', 'api/v1/posts/1/comments');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function testBlogPostHas10Comments()
    {
        $this->blogPost()->each(function (BlogPost $post) {
            $post->comments()->saveMany(
                Comment::factory()->count(10)->make([
                    'user_id' => $this->user()->id
                ])
            );
        });

        $response = $this->actingAs($this->user(), 'api')->json('GET', 'api/v1/posts/2/comments');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'content',
                            'created_at',
                            'updated_at',
                            'user' => [
                                'id',
                                'name'
                            ]
                        ]
                    ],
                    'links',
                    'meta'
                ]
            )
            ->assertJsonCount(10, 'data');
    }

    public function testAddingCommentsWhenNotAuthenticated()
    {
        $this->blogPost();

        $response = $this->json('POST', 'api/v1/posts/3/comments', [
            'content' => 'Hello'
        ]);

        $response->assertStatus(401);
    }

    public function testAddingCommentsWhenAuthenticated()
    {
        $this->markTestSkipped('Issue with Redis');

        $this->blogPost();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/4/comments', [
            'content' => 'Hello'
        ]);

        $response->assertStatus(201);
    }

    public function testAddingCommentWithInvalidData()
    {
        $this->blogPost();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/4/comments', []);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "content" => [
                        "The content field is required."
                    ]
                ]
            ]);
    }

}
