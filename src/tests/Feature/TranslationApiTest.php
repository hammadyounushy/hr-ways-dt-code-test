<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Translation;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = $user->createToken('TestToken')->plainTextToken;
    }

    public function test_can_create_translation()
    {
        $response = $this->withToken($this->token)->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello World',
            'tags' => ['web']
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['key' => 'greeting']);
    }

    public function test_can_search_translation_by_key()
    {
        Translation::factory()->create(['key' => 'welcome']);

        $response = $this->withToken($this->token)->getJson('/api/translations/search?key=welcome');
        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }

    public function test_can_export_translations()
    {
        Translation::factory()->create(['locale' => 'en', 'key' => 'test', 'content' => 'Test']);

        $response = $this->withToken($this->token)->getJson('/api/translations/export');
        $response->assertStatus(200)
            ->assertJsonFragment(['test' => 'Test']);
    }
}
