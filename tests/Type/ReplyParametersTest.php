<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReplyParametersTest extends TestCase
{
    public function testBase(): void
    {
        $replyParameters = new ReplyParameters(99);

        assertSame(99, $replyParameters->messageId);
        assertNull($replyParameters->chatId);
        assertNull($replyParameters->allowSendingWithoutReply);
        assertNull($replyParameters->quote);
        assertNull($replyParameters->quoteParseMode);
        assertNull($replyParameters->quoteEntities);
        assertNull($replyParameters->quotePosition);
        assertNull($replyParameters->checklistTaskId);

        assertSame(
            [
                'message_id' => 99,
            ],
            $replyParameters->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $quoteEntity = new MessageEntity('bold', 0, 4);
        $replyParameters = new ReplyParameters(
            99,
            102,
            true,
            'text',
            'best',
            [$quoteEntity],
            23,
            456,
        );

        assertSame(99, $replyParameters->messageId);
        assertSame(102, $replyParameters->chatId);
        assertTrue($replyParameters->allowSendingWithoutReply);
        assertSame('text', $replyParameters->quote);
        assertSame('best', $replyParameters->quoteParseMode);
        assertSame([$quoteEntity], $replyParameters->quoteEntities);
        assertSame(23, $replyParameters->quotePosition);
        assertSame(456, $replyParameters->checklistTaskId);

        assertSame(
            [
                'message_id' => 99,
                'chat_id' => 102,
                'allow_sending_without_reply' => true,
                'quote' => 'text',
                'quote_parse_mode' => 'best',
                'quote_entities' => [$quoteEntity->toRequestArray()],
                'quote_position' => 23,
                'checklist_task_id' => 456,
            ],
            $replyParameters->toRequestArray(),
        );
    }
}
