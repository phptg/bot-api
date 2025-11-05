<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundFillSolid;
use Phptg\BotApi\Type\BackgroundTypePattern;
use Phptg\BotApi\Type\Document;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class BackgroundTypePatternTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('f123', 'full123');
        $fill = new BackgroundFillSolid(0x000000);
        $type = new BackgroundTypePattern($document, $fill, 5);

        assertSame('pattern', $type->getType());
        assertSame($document, $type->document);
        assertSame($fill, $type->fill);
        assertSame(5, $type->intensity);
        assertNull($type->isInverted);
        assertNull($type->isMoving);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'pattern',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'full123',
            ],
            'fill' => [
                'type' => 'solid',
                'color' => 0x000000,
            ],
            'intensity' => 5,
            'is_inverted' => true,
            'is_moving' => true,
        ], null, BackgroundTypePattern::class);

        assertSame('pattern', $type->getType());

        assertInstanceOf(Document::class, $type->document);
        assertSame('f123', $type->document->fileId);
        assertSame('full123', $type->document->fileUniqueId);

        assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        assertSame(0x000000, $type->fill->color);

        assertSame(5, $type->intensity);
        assertTrue($type->isInverted);
        assertTrue($type->isMoving);
    }
}
