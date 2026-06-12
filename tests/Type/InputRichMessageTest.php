<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichMessage;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputRichMessageTest extends TestCase
{
    public function testBase(): void
    {
        $message = new InputRichMessage();

        assertNull($message->html);
        assertNull($message->markdown);
        assertNull($message->isRtl);
        assertNull($message->skipEntityDetection);
        assertSame([], $message->toRequestArray());
    }

    public function testFull(): void
    {
        $message = new InputRichMessage(
            html: '<b>Hello</b>',
            markdown: '**Hello**',
            isRtl: true,
            skipEntityDetection: true,
        );

        assertSame('<b>Hello</b>', $message->html);
        assertSame('**Hello**', $message->markdown);
        assertTrue($message->isRtl);
        assertTrue($message->skipEntityDetection);
        assertSame(
            [
                'html' => '<b>Hello</b>',
                'markdown' => '**Hello**',
                'is_rtl' => true,
                'skip_entity_detection' => true,
            ],
            $message->toRequestArray(),
        );
    }
}
