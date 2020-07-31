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
        $blade = $this->blade('<x-fj-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('.image-container')->withChild('img');
    }

    /** @test */
    public function it_has_lazyload_class()
    {
        $media = $this->getMediaMock();
        $blade = $this->blade('<x-fj-image :image="$image"/>', ['image' => $media]);
        $blade->assertHas('.image-container')->withChild('img.lazyload');
    }

    /** @test */
    public function test_disable_lazyload()
    {
        $media = $this->getMediaMock();
        $blade = $this->blade('<x-fj-image :image="$image" :lazy="false"/>', ['image' => $media]);
        $blade->assertDoesntHave('.image-container img.lazyload');
    }

    /** @test */
    public function test_image_has_base64_string()
    {
        $image = UploadedFile::fake()->image('image.png');

        $media = m::mock(Media::class)->makePartial();
        $media->shouldReceive('getPath')->andReturn($image->getRealPath());
        $media->shouldReceive('getFullUrl')->andReturn('abc');

        $blade = $this->blade('<x-fj-image :image="$image"/>', ['image' => $media]);
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
