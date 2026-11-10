<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReplyParametersTest extends TestCase
{
    public function testBase(): void
    {
        $replyParameters = new ReplyParameters();

        assertNull($replyParameters->messageId);
        assertNull($replyParameters->chatId);
        assertNull($replyParameters->allowSendingWithoutReply);
        assertNull($replyParameters->quote);
        assertNull($replyParameters->quoteParseMode);
        assertNull($replyParameters->quoteEntities);
        assertNull($replyParameters->quotePosition);
        assertNull($replyParameters->checklistTaskId);
        assertNull($replyParameters->pollOptionId);
        assertNull($replyParameters->ephemeralMessageId);
        assertNull($replyParameters->quoteRichTexts);

        assertSame([], $replyParameters->toRequestArray());
    }

    public function testFull(): void
    {
        $quoteEntity = new MessageEntity('bold', 0, 4);
        $richText = new RichTextBold('quoted');
        $replyParameters = new ReplyParameters(
            99,
            102,
            true,
            'text',
            'best',
            [$quoteEntity],
            23,
            456,
            'pid1',
            789,
            [$richText, 'plain'],
        );

        assertSame(99, $replyParameters->messageId);
        assertSame(102, $replyParameters->chatId);
        assertTrue($replyParameters->allowSendingWithoutReply);
        assertSame('text', $replyParameters->quote);
        assertSame('best', $replyParameters->quoteParseMode);
        assertSame([$quoteEntity], $replyParameters->quoteEntities);
        assertSame(23, $replyParameters->quotePosition);
        assertSame(456, $replyParameters->checklistTaskId);
        assertSame('pid1', $replyParameters->pollOptionId);
        assertSame(789, $replyParameters->ephemeralMessageId);
        assertSame([$richText, 'plain'], $replyParameters->quoteRichTexts);

        assertSame(
            [
                'message_id' => 99,
                'chat_id' => 102,
                'ephemeral_message_id' => 789,
                'allow_sending_without_reply' => true,
                'quote' => 'text',
                'quote_parse_mode' => 'best',
                'quote_entities' => [$quoteEntity->toRequestArray()],
                'quote_rich_texts' => [$richText->toRequestArray(), 'plain'],
                'quote_position' => 23,
                'checklist_task_id' => 456,
                'poll_option_id' => 'pid1',
            ],
            $replyParameters->toRequestArray(),
        );
    }
}
