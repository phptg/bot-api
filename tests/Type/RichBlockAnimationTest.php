<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Animation;
use Phptg\BotApi\Type\RichBlockAnimation;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new Animation('f123', 'fullF123', 640, 480, 10);
        $block = new RichBlockAnimation($animation);

        assertSame('animation', $block->getType());
        assertSame($animation, $block->animation);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $animation = new Animation('f123', 'fullF123', 640, 480, 10);
        $caption = new RichBlockCaption('animation');
        $block = new RichBlockAnimation($animation, true, $caption);

        assertSame('animation', $block->getType());
        assertTrue($block->hasSpoiler);
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'animation',
            'animation' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'width' => 640,
                'height' => 480,
                'duration' => 10,
            ],
        ], null, RichBlockAnimation::class);

        assertSame('animation', $block->getType());
        assertInstanceOf(Animation::class, $block->animation);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'animation',
            'animation' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'width' => 640,
                'height' => 480,
                'duration' => 10,
            ],
            'has_spoiler' => true,
            'caption' => ['text' => 'animation'],
        ], null, RichBlockAnimation::class);

        assertSame('animation', $block->getType());
        assertInstanceOf(Animation::class, $block->animation);
        assertTrue($block->hasSpoiler);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
    }
}
