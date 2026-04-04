<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\PollOptionDeleted;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PollOptionDeletedTest extends TestCase
{
    public function testBase(): void
    {
        $pollOptionDeleted = new PollOptionDeleted('pid1', 'Option text');

        assertSame('pid1', $pollOptionDeleted->optionPersistentId);
        assertSame('Option text', $pollOptionDeleted->optionText);
        assertNull($pollOptionDeleted->pollMessage);
        assertNull($pollOptionDeleted->optionTextEntities);
    }

    public function testFromTelegramResult(): void
    {
        $pollOptionDeleted = (new ObjectFactory())->create([
            'option_persistent_id' => 'pid1',
            'option_text' => 'Option text',
            'poll_message' => [
                'message_id' => 1,
                'date' => 1620000000,
                'chat' => ['id' => 10, 'type' => 'private'],
            ],
            'option_text_entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 6,
                ],
            ],
        ], null, PollOptionDeleted::class);

        assertInstanceOf(PollOptionDeleted::class, $pollOptionDeleted);
        assertSame('pid1', $pollOptionDeleted->optionPersistentId);
        assertSame('Option text', $pollOptionDeleted->optionText);
        assertInstanceOf(Message::class, $pollOptionDeleted->pollMessage);
        assertSame(1, $pollOptionDeleted->pollMessage->messageId);
        assertCount(1, $pollOptionDeleted->optionTextEntities);
        assertSame('bold', $pollOptionDeleted->optionTextEntities[0]->type);
    }
}
