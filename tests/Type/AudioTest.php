<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Audio;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class AudioTest extends TestCase
{
    public function testAudio(): void
    {
        $audio = new Audio(
            'id12',
            'full12',
            123,
        );

        assertSame('id12', $audio->fileId);
        assertSame('full12', $audio->fileUniqueId);
        assertSame(123, $audio->duration);
        assertNull($audio->performer);
        assertNull($audio->title);
        assertNull($audio->fileName);
        assertNull($audio->mimeType);
        assertNull($audio->fileSize);
        assertNull($audio->thumbnail);
    }

    public function testFromTelegramResult(): void
    {
        $audio = (new ObjectFactory())->create([
            'file_id' => 'id12',
            'file_unique_id' => 'full12',
            'duration' => 123,
            'performer' => 'performer12',
            'title' => 'Hello',
            'file_name' => 'hello.mp3',
            'mime_type' => 'audio/mpeg',
            'file_size' => 12345,
            'thumbnail' => [
                'file_id' => 'id34',
                'file_unique_id' => 'full34',
                'width' => 320,
                'height' => 240,
            ],
        ], null, Audio::class);

        assertSame('id12', $audio->fileId);
        assertSame('full12', $audio->fileUniqueId);
        assertSame(123, $audio->duration);
        assertSame('performer12', $audio->performer);
        assertSame('Hello', $audio->title);
        assertSame('hello.mp3', $audio->fileName);
        assertSame('audio/mpeg', $audio->mimeType);
        assertSame(12345, $audio->fileSize);

        assertInstanceOf(PhotoSize::class, $audio->thumbnail);
        assertSame('id34', $audio->thumbnail->fileId);
    }
}
