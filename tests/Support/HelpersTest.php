<?php

namespace Tests\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Routing\UrlGenerator;
use Mockery as m;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function test_b64_helper()
    {
        $image = UploadedFile::fake()->image('image.png');

        $this->assertEquals(
            'data:application/'.pathinfo($image->getRealPath(), PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents($image->getRealPath())),
            b64($image->getRealPath())
        );
    }

    /** @test */
    public function test___routes_helper()
    {
        app()->setLocale('de');

        $url = m::mock(UrlGenerator::class)->makePartial();
        app()->bind('url', fn () => $url);

        $url->shouldReceive('route')->withArgs(['de.home', [], true]);

        __route('home');
    }

    /** @test */
    public function test___routes_helper_returns_url()
    {
        app()->setLocale('de');

        $url = m::mock(UrlGenerator::class)->makePartial();
        app()->bind('url', fn () => $url);

        $url->shouldReceive('route')->andReturn('dummy-url');

        $this->assertEquals('dummy-url', __route('home'));
    }

    /** @test */
    public function test___routes_helper_passes_parameters()
    {
        app()->setLocale('de');

        $url = m::mock(UrlGenerator::class)->makePartial();
        app()->bind('url', fn () => $url);

        $url->shouldReceive('route')->withArgs(['de.home', ['params'], false]);

        __route('home', ['params'], false);
    }

    /** @test */
    public function test___routes_helper_with_locale_argument()
    {
        app()->setLocale('de');

        $url = m::mock(UrlGenerator::class)->makePartial();
        app()->bind('url', fn () => $url);

        $url->shouldReceive('route')->withArgs(['en.home', [], true]);

        __route('home', [], true, 'en');
    }
}
