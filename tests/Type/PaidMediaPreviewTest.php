<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMediaPreview;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PaidMediaPreviewTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PaidMediaPreview();

        assertSame('preview', $type->getType());
        assertNull($type->width);
        assertNull($type->height);
        assertNull($type->duration);
    }

    public function testFull(): void
    {
        $type = new PaidMediaPreview(100, 200, 512);

        assertSame('preview', $type->getType());
        assertSame(100, $type->width);
        assertSame(200, $type->height);
        assertSame(512, $type->duration);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'preview',
            'width' => 100,
            'height' => 200,
            'duration' => 512,
        ], null, PaidMediaPreview::class);

        assertSame('preview', $type->getType());
        assertSame(100, $type->width);
        assertSame(200, $type->height);
        assertSame(512, $type->duration);
    }
}
