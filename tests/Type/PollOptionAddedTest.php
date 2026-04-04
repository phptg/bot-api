<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\PollOptionAdded;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PollOptionAddedTest extends TestCase
{
    public function testBase(): void
    {
        $pollOptionAdded = new PollOptionAdded('pid1', 'Option text');

        assertSame('pid1', $pollOptionAdded->optionPersistentId);
        assertSame('Option text', $pollOptionAdded->optionText);
        assertNull($pollOptionAdded->pollMessage);
        assertNull($pollOptionAdded->optionTextEntities);
    }

    public function testFromTelegramResult(): void
    {
        $pollOptionAdded = (new ObjectFactory())->create([
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
        ], null, PollOptionAdded::class);

        assertInstanceOf(PollOptionAdded::class, $pollOptionAdded);
        assertSame('pid1', $pollOptionAdded->optionPersistentId);
        assertSame('Option text', $pollOptionAdded->optionText);
        assertInstanceOf(Message::class, $pollOptionAdded->pollMessage);
        assertSame(1, $pollOptionAdded->pollMessage->messageId);
        assertCount(1, $pollOptionAdded->optionTextEntities);
        assertSame('bold', $pollOptionAdded->optionTextEntities[0]->type);
    }
}
