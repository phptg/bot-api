<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\DirectMessagesTopic;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class DirectMessagesTopicTest extends TestCase
{
    public function testBase(): void
    {
        $topic = new DirectMessagesTopic(123);

        assertSame(123, $topic->topicId);
        assertNull($topic->user);
    }

    public function testFromTelegramResult(): void
    {
        $topic = (new ObjectFactory())->create(
            [
                'topic_id' => 456,
                'user' => [
                    'id' => 789,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
            ],
            null,
            DirectMessagesTopic::class,
        );

        assertSame(456, $topic->topicId);
        assertSame(789, $topic->user?->id);
    }
}
