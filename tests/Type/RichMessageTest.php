<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichMessage;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

final class RichMessageTest extends TestCase
{
    public function testBase(): void
    {
        $message = new RichMessage([new RichBlockParagraph('hello')]);

        assertCount(1, $message->blocks);
        assertNull($message->isRtl);
    }

    public function testFull(): void
    {
        $message = new RichMessage([new RichBlockParagraph('hello')], true);

        assertCount(1, $message->blocks);
        assertTrue($message->isRtl);
    }

    public function testFromTelegramResult(): void
    {
        $message = (new ObjectFactory())->create([
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichMessage::class);

        assertCount(1, $message->blocks);
        assertInstanceOf(RichBlockParagraph::class, $message->blocks[0]);
        assertNull($message->isRtl);
    }

    public function testFromTelegramResultFull(): void
    {
        $message = (new ObjectFactory())->create([
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'is_rtl' => true,
        ], null, RichMessage::class);

        assertCount(1, $message->blocks);
        assertInstanceOf(RichBlockParagraph::class, $message->blocks[0]);
        assertTrue($message->isRtl);
    }
}
