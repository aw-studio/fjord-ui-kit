<?php

namespace Tests\Support;

use Fjord\Crud\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery as m;
use Tests\TestCase;

class ImageComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    /** @test */
    public function test_image_component()
    {
        $media = $this->getMediaMock();
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('.image-container')->withChild('img');
        $blade->assertHas('img')->withAttribute('data-sizes')->thatIs('auto');
    }

    /** @test */
    public function it_has_lazyload_class()
    {
        $media = $this->getMediaMock();
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('.image-container')->withChild('img.lazyload');
    }

    /** @test */
    public function test_disable_lazyload()
    {
        $media = $this->getMediaMock();
        $blade = $this->blade('<x-lit-image :image="$image" :lazy="false"/>', ['image' => $media]);
        $blade->assertDoesntHave('.image-container img.lazyload');
    }

    /** @test */
    public function test_it_has_title_from_custom_properties()
    {
        $media = $this->getMediaMock();
        $media->custom_properties = ['title' => 'dummy-title'];
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('title')->thatIs('dummy-title');

        // Translated title
        $media->custom_properties = [app()->getLocale() => ['title' => 'dummy-title']];
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('title')->thatIs('dummy-title');
    }

    /** @test */
    public function test_it_has_alt_from_custom_properties()
    {
        $media = $this->getMediaMock();
        $media->custom_properties = ['alt' => 'dummy-alt'];
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('alt')->thatIs('dummy-alt');

        // Translated alt
        $media->custom_properties = [app()->getLocale() => ['alt' => 'dummy-alt']];
        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('alt')->thatIs('dummy-alt');
    }

    /** @test */
    public function test_it_has_title_from_attribute()
    {
        $media = $this->getMediaMock();
        $media->custom_properties = ['title' => 'property-title'];
        $blade = $this->blade('<x-lit-image :image="$image" title="dummy-title"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('title')->thatIs('dummy-title');
    }

    /** @test */
    public function test_it_has_alt_from_attribute()
    {
        $media = $this->getMediaMock();
        $media->custom_properties = ['alt' => 'property-alt'];
        $blade = $this->blade('<x-lit-image :image="$image" alt="dummy-alt"/>', ['image' => $media]);
        $blade->assertHas('img')->withAttribute('alt')->thatIs('dummy-alt');
    }

    /** @test */
    public function test_image_has_base64_string()
    {
        $image = UploadedFile::fake()->image('image.png');

        $media = m::mock(Media::class)->makePartial();
        $media->shouldReceive('getPath')->andReturn($image->getRealPath());
        $media->shouldReceive('getFullUrl')->andReturn('abc');

        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);

        $blade->assertHas('img')
            ->withAttribute('src')
            ->thatIs(b64($image->getRealPath()));
    }

    /** @test */
    public function test_image_has_srcset_with_conversion_urls()
    {
        $image = UploadedFile::fake()->image('image.png');

        $media = m::mock(Media::class)->makePartial();
        $media->shouldReceive('getPath')->andReturn($image->getRealPath());
        $media->shouldReceive('getFullUrl')->withArgs(['sm'])->andReturn('sm.png');
        $media->shouldReceive('getFullUrl')->withArgs(['md'])->andReturn('md.png');
        $media->shouldReceive('getFullUrl')->withArgs(['lg'])->andReturn('lg.png');
        $media->shouldReceive('getFullUrl')->withArgs(['xl'])->andReturn('xl.png');

        $blade = $this->blade('<x-lit-image :image="$image"/>', ['image' => $media]);

        $attribute = $blade->assertHas('img')->withAttribute('data-srcset')->getAttribute();

        $blade->assertHas('img')->withAttribute('data-srcset')->thatIs('sm.png 300w,md.png 500w,lg.png 900w,xl.png 1400w,');
    }

    public function getMediaMock($file = 'image.png')
    {
        $image = UploadedFile::fake()->image($file);

        $media = m::mock(Media::class)->makePartial();
        $media->shouldReceive('getPath')->andReturn($image->getRealPath());
        $media->shouldReceive('getFullUrl')->andReturn('abc');

        return $media;
    }
}
