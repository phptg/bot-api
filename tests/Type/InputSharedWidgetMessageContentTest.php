<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputSharedWidgetMessageContent;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputSharedWidgetMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputSharedWidgetMessageContent('widgetId');

        assertSame('widgetId', $type->widgetId);
        assertNull($type->chatData);
        assertNull($type->caption);
        assertNull($type->parseMode);
        assertNull($type->captionEntities);
        assertNull($type->showCaptionAboveMedia);
        assertSame(
            [
                'widget_id' => 'widgetId',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $type = new InputSharedWidgetMessageContent(
            'widgetId',
            'chatData',
            'Caption',
            'MarkdownV2',
            [$entity],
            true,
        );

        assertSame('widgetId', $type->widgetId);
        assertSame('chatData', $type->chatData);
        assertSame('Caption', $type->caption);
        assertSame('MarkdownV2', $type->parseMode);
        assertSame([$entity], $type->captionEntities);
        assertTrue($type->showCaptionAboveMedia);
        assertSame(
            [
                'widget_id' => 'widgetId',
                'chat_data' => 'chatData',
                'caption' => 'Caption',
                'parse_mode' => 'MarkdownV2',
                'caption_entities' => [
                    $entity->toRequestArray(),
                ],
                'show_caption_above_media' => true,
            ],
            $type->toRequestArray(),
        );
    }
}
