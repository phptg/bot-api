<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Link;
use Phptg\BotApi\Type\PollMedia;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PollMediaTest extends TestCase
{
    public function testBase(): void
    {
        $pollMedia = new PollMedia();

        assertNull($pollMedia->animation);
        assertNull($pollMedia->audio);
        assertNull($pollMedia->document);
        assertNull($pollMedia->livePhoto);
        assertNull($pollMedia->location);
        assertNull($pollMedia->photo);
        assertNull($pollMedia->sticker);
        assertNull($pollMedia->venue);
        assertNull($pollMedia->video);
        assertNull($pollMedia->link);
    }

    public function testFromTelegramResult(): void
    {
        $pollMedia = (new ObjectFactory())->create([
            'animation' => [
                'file_id' => 'animation_file_id',
                'file_unique_id' => 'animation_unique_id',
                'width' => 1280,
                'height' => 720,
                'duration' => 10,
            ],
            'audio' => [
                'file_id' => 'audio_file_id',
                'file_unique_id' => 'audio_unique_id',
                'duration' => 180,
            ],
            'document' => [
                'file_id' => 'document_file_id',
                'file_unique_id' => 'document_unique_id',
            ],
            'live_photo' => [
                'file_id' => 'live_photo_file_id',
                'file_unique_id' => 'live_photo_unique_id',
                'width' => 1080,
                'height' => 1920,
                'duration' => 5,
            ],
            'location' => [
                'latitude' => 55.7558,
                'longitude' => 37.6173,
            ],
            'photo' => [
                [
                    'file_id' => 'photo_file_id_1',
                    'file_unique_id' => 'photo_unique_id_1',
                    'width' => 1920,
                    'height' => 1080,
                ],
                [
                    'file_id' => 'photo_file_id_2',
                    'file_unique_id' => 'photo_unique_id_2',
                    'width' => 960,
                    'height' => 540,
                ],
            ],
            'sticker' => [
                'file_id' => 'sticker_file_id',
                'file_unique_id' => 'sticker_unique_id',
                'type' => 'regular',
                'width' => 512,
                'height' => 512,
                'is_animated' => false,
                'is_video' => false,
            ],
            'venue' => [
                'location' => [
                    'latitude' => 55.7558,
                    'longitude' => 37.6173,
                ],
                'title' => 'Kremlin',
                'address' => 'Red Square, Moscow',
            ],
            'video' => [
                'file_id' => 'video_file_id',
                'file_unique_id' => 'video_unique_id',
                'width' => 1920,
                'height' => 1080,
                'duration' => 30,
            ],
            'link' => [
                'url' => 'https://example.com',
            ],
        ], null, PollMedia::class);

        assertSame('animation_file_id', $pollMedia->animation?->fileId);
        assertSame('audio_file_id', $pollMedia->audio?->fileId);
        assertSame('document_file_id', $pollMedia->document?->fileId);
        assertSame('live_photo_file_id', $pollMedia->livePhoto?->fileId);
        assertSame(55.7558, $pollMedia->location?->latitude);
        assertCount(2, $pollMedia->photo);
        assertSame('photo_file_id_1', $pollMedia->photo[0]->fileId);
        assertSame('photo_file_id_2', $pollMedia->photo[1]->fileId);
        assertSame('sticker_file_id', $pollMedia->sticker?->fileId);
        assertSame('Kremlin', $pollMedia->venue?->title);
        assertSame('video_file_id', $pollMedia->video?->fileId);
        assertInstanceOf(Link::class, $pollMedia->link);
        assertSame('https://example.com', $pollMedia->link->url);
    }
}
