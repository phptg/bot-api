<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultDocument;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultDocument(
            'id1',
            'The title',
            'https://example.com/test.pdf',
            'application/pdf',
        );

        assertSame('document', $type->getType());
        assertSame(
            [
                'type' => 'document',
                'id' => 'id1',
                'title' => 'The title',
                'document_url' => 'https://example.com/test.pdf',
                'mime_type' => 'application/pdf',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultDocument(
            'id1',
            'The title',
            'https://example.com/test.pdf',
            'application/pdf',
            'The caption',
            'HTML',
            [$entity],
            'The description',
            $replyMarkup,
            $inputMessageContent,
            'https://example.com/test.jpg',
            120,
            150,
        );

        assertSame('document', $type->getType());
        assertSame(
            [
                'type' => 'document',
                'id' => 'id1',
                'title' => 'The title',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'document_url' => 'https://example.com/test.pdf',
                'mime_type' => 'application/pdf',
                'description' => 'The description',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
                'thumbnail_url' => 'https://example.com/test.jpg',
                'thumbnail_width' => 120,
                'thumbnail_height' => 150,
            ],
            $type->toRequestArray(),
        );
    }
}
