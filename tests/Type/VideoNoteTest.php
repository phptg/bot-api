<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoNote;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class VideoNoteTest extends TestCase
{
    public function testBase(): void
    {
        $videoNote = new VideoNote('f1', 'fu1', 200, 32);

        assertSame('f1', $videoNote->fileId);
        assertSame('fu1', $videoNote->fileUniqueId);
        assertSame(200, $videoNote->length);
        assertSame(32, $videoNote->duration);
        assertNull($videoNote->thumbnail);
        assertNull($videoNote->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $videoNote = (new ObjectFactory())->create([
            'file_id' => 'f1',
            'file_unique_id' => 'fu1',
            'length' => 200,
            'duration' => 32,
            'thumbnail' => [
                'file_id' => 'f2',
                'file_unique_id' => 'fu2',
                'width' => 104,
                'height' => 205,
            ],
            'file_size' => 100,
        ], null, VideoNote::class);

        assertSame('f1', $videoNote->fileId);
        assertSame('fu1', $videoNote->fileUniqueId);
        assertSame(200, $videoNote->length);
        assertSame(32, $videoNote->duration);
        assertSame('f2', $videoNote->thumbnail?->fileId);
        assertSame(100, $videoNote->fileSize);
    }
}
