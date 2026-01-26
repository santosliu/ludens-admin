<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsRequestUrlValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @dataProvider allowedUrlsProvider
     */
    public function test_allowed_urls_pass_validation(string $url): void
    {
        $response = $this->actingAs($this->user, 'backpack')
            ->post(config('backpack.base.route_prefix').'/news-request', [
                'url' => $url,
                'status' => 0,
            ]);

        $response->assertSessionDoesntHaveErrors('url');
    }

    /**
     * @dataProvider disallowedUrlsProvider
     */
    public function test_disallowed_urls_fail_validation(string $url): void
    {
        $response = $this->actingAs($this->user, 'backpack')
            ->post(config('backpack.base.route_prefix').'/news-request', [
                'url' => $url,
                'status' => 0,
            ]);

        $response->assertSessionHasErrors('url');
    }

    public function test_validation_error_message_lists_allowed_sources(): void
    {
        $response = $this->actingAs($this->user, 'backpack')
            ->post(config('backpack.base.route_prefix').'/news-request', [
                'url' => 'https://example.com/article/123',
                'status' => 0,
            ]);

        $response->assertSessionHasErrors('url');

        $errors = session('errors')->get('url');
        $errorMessage = $errors[0] ?? '';

        $this->assertStringContainsString('https://www.inven.co.kr/board/', $errorMessage);
        $this->assertStringContainsString('https://www.inven.co.kr/webzine/', $errorMessage);
        $this->assertStringContainsString('https://www.gamespot.com/articles/', $errorMessage);
        $this->assertStringContainsString('https://www.gamespot.com/gallery/', $errorMessage);
        $this->assertStringContainsString('https://mp.weixin.qq.com/', $errorMessage);
    }

    /**
     * @return array<string, array<string>>
     */
    public static function allowedUrlsProvider(): array
    {
        return [
            'inven board' => ['https://www.inven.co.kr/board/lostark/5355/123456'],
            'inven webzine' => ['https://www.inven.co.kr/webzine/news/?news=123456'],
            'gamespot articles' => ['https://www.gamespot.com/articles/some-article-title/1100-123456/'],
            'gamespot gallery' => ['https://www.gamespot.com/gallery/some-gallery/2900-123456/'],
            'weixin' => ['https://mp.weixin.qq.com/s/abcdefghijk123456'],
        ];
    }

    /**
     * @return array<string, array<string>>
     */
    public static function disallowedUrlsProvider(): array
    {
        return [
            'generic url' => ['https://example.com/article/123'],
            'inven main page' => ['https://www.inven.co.kr/'],
            'inven other section' => ['https://www.inven.co.kr/member/login'],
            'gamespot main' => ['https://www.gamespot.com/'],
            'gamespot reviews' => ['https://www.gamespot.com/reviews/some-review/1900-123/'],
            'other news site' => ['https://www.ign.com/articles/some-article'],
            'http instead of https' => ['http://www.inven.co.kr/board/123'],
        ];
    }
}
