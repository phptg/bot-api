<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputTextMessageContent;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputTextMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputTextMessageContent('Hello');

        assertSame('Hello', $type->messageText);
        assertNull($type->parseMode);
        assertNull($type->entities);
        assertNull($type->linkPreviewOptions);
        assertSame(
            [
                'message_text' => 'Hello',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $linkPreviewOptions = new LinkPreviewOptions(false);
        $type = new InputTextMessageContent('Hello', 'MarkdownV2', [$entity], $linkPreviewOptions);

        assertSame('Hello', $type->messageText);
        assertSame('MarkdownV2', $type->parseMode);
        assertSame([$entity], $type->entities);
        assertSame($linkPreviewOptions, $type->linkPreviewOptions);
        assertSame(
            [
                'message_text' => 'Hello',
                'parse_mode' => 'MarkdownV2',
                'entities' => [
                    $entity->toRequestArray(),
                ],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
