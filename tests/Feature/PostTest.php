<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPost()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No Posts');
    }

    public function testSeeOneBlogPost()
    {
        $post = $this->getDummyPost();

        $response = $this->get('/posts');

        $response->assertSeeText('New blog post');
        $response->assertSeeText('No comments!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New blog post'
        ]);
    }

    public function testStoreWorks()
    {
        $params = ['title' => "New Title", 'content' => 'new content'];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Created!');

    }

    public function testStoreFail()
    {
        $params = ['title' => "New", 'content' => 'new content'];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
    }

    public function testUpdateWorks()
    {
        $post = $this->getDummyPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New blog post'
        ]);

        $params = ['title' => "New Edited Version", 'content' => 'new content version'];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New blog post'
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Edited Version'
        ]);
    }

    protected function getDummyPost(): BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New blog post';
        $post->content = 'Some content';
        $post->save();

        return $post;
    }

    public function testDeletePost()
    {
        $post = $this->getDummyPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New blog post'
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status', 'Deleted');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New blog post'
        ]);
    }

}
