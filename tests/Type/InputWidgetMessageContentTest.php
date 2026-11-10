<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputWidgetMessageContent;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputWidgetMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputWidgetMessageContent('<b>Hello</b>');

        assertSame('<b>Hello</b>', $type->html);
        assertNull($type->width);
        assertNull($type->height);
        assertNull($type->publicData);
        assertNull($type->chatData);
        assertNull($type->caption);
        assertNull($type->parseMode);
        assertNull($type->captionEntities);
        assertNull($type->showCaptionAboveMedia);
        assertNull($type->allowQueries);
        assertNull($type->isShared);
        assertSame(
            [
                'html' => '<b>Hello</b>',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $type = new InputWidgetMessageContent(
            '<b>Hello</b>',
            320,
            240,
            'publicData',
            'chatData',
            'Caption',
            'MarkdownV2',
            [$entity],
            true,
            true,
            true,
        );

        assertSame('<b>Hello</b>', $type->html);
        assertSame(320, $type->width);
        assertSame(240, $type->height);
        assertSame('publicData', $type->publicData);
        assertSame('chatData', $type->chatData);
        assertSame('Caption', $type->caption);
        assertSame('MarkdownV2', $type->parseMode);
        assertSame([$entity], $type->captionEntities);
        assertTrue($type->showCaptionAboveMedia);
        assertTrue($type->allowQueries);
        assertTrue($type->isShared);
        assertSame(
            [
                'html' => '<b>Hello</b>',
                'width' => 320,
                'height' => 240,
                'public_data' => 'publicData',
                'chat_data' => 'chatData',
                'caption' => 'Caption',
                'parse_mode' => 'MarkdownV2',
                'caption_entities' => [
                    $entity->toRequestArray(),
                ],
                'show_caption_above_media' => true,
                'allow_queries' => true,
                'is_shared' => true,
            ],
            $type->toRequestArray(),
        );
    }
}
