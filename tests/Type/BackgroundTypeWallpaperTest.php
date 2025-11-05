<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundTypeWallpaper;
use Phptg\BotApi\Type\Document;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class BackgroundTypeWallpaperTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('f123', 'full123');
        $type = new BackgroundTypeWallpaper($document, 7);

        assertSame('wallpaper', $type->getType());
        assertSame($document, $type->document);
        assertSame(7, $type->darkThemeDimming);
        assertNull($type->isBlurred);
        assertNull($type->isMoving);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'wallpaper',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'full123',
            ],
            'dark_theme_dimming' => 7,
            'is_blurred' => true,
            'is_moving' => true,
        ], null, BackgroundTypeWallpaper::class);

        assertSame('wallpaper', $type->getType());

        assertInstanceOf(Document::class, $type->document);
        assertSame('f123', $type->document->fileId);
        assertSame('full123', $type->document->fileUniqueId);

        assertSame(7, $type->darkThemeDimming);
        assertTrue($type->isBlurred);
        assertTrue($type->isMoving);
    }
}
