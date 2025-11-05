<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedDocument;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedDocument(
            'id1',
            'The Title',
            'document_id1',
        );

        assertSame('document', $type->getType());
        assertSame(
            [
                'type' => 'document',
                'id' => 'id1',
                'title' => 'The Title',
                'document_file_id' => 'document_id1',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedDocument(
            'id1',
            'The Title',
            'document_id1',
            'The description',
            'The caption',
            'HTML',
            [$entity],
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('document', $type->getType());
        assertSame(
            [
                'type' => 'document',
                'id' => 'id1',
                'title' => 'The Title',
                'document_file_id' => 'document_id1',
                'description' => 'The description',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
