<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\SuggestedPostRefunded;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostRefundedTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SuggestedPostRefunded('post_deleted');

        assertSame('post_deleted', $type->reason);
        assertNull($type->suggestedPostMessage);
    }

    public function testFull(): void
    {
        $message = new Message(123, new DateTimeImmutable(), new Chat(456, 'channel'));
        $type = new SuggestedPostRefunded('payment_refunded', $message);

        assertSame('payment_refunded', $type->reason);
        assertSame($message, $type->suggestedPostMessage);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'reason' => 'post_deleted',
                'suggested_post_message' => [
                    'message_id' => 789,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 101,
                        'type' => 'channel',
                    ],
                    'text' => 'Refunded post content',
                ],
            ],
            null,
            SuggestedPostRefunded::class,
        );

        assertSame('post_deleted', $type->reason);
        assertInstanceOf(Message::class, $type->suggestedPostMessage);
        assertSame(789, $type->suggestedPostMessage->messageId);
        assertSame('Refunded post content', $type->suggestedPostMessage->text);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'reason' => 'payment_refunded',
            ],
            null,
            SuggestedPostRefunded::class,
        );

        assertSame('payment_refunded', $type->reason);
        assertNull($type->suggestedPostMessage);
    }
}
