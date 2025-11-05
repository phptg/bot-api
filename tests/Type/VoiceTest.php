<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Voice;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class VoiceTest extends TestCase
{
    public function testBase(): void
    {
        $voice = new Voice('f1', 'fu1', 23);

        assertSame('f1', $voice->fileId);
        assertSame('fu1', $voice->fileUniqueId);
        assertSame(23, $voice->duration);
        assertNull($voice->mimeType);
        assertNull($voice->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $voice = (new ObjectFactory())->create([
            'file_id' => 'f1',
            'file_unique_id' => 'fu1',
            'duration' => 23,
            'mime_type' => 'audio/mpeg',
            'file_size' => 100,
        ], null, Voice::class);

        assertSame('f1', $voice->fileId);
        assertSame('fu1', $voice->fileUniqueId);
        assertSame(23, $voice->duration);
        assertSame('audio/mpeg', $voice->mimeType);
        assertSame(100, $voice->fileSize);
    }
}
