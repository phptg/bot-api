<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\SuggestedPostApproved;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostApprovedTest extends TestCase
{
    public function testBase(): void
    {
        $approved = new SuggestedPostApproved(1640995200);

        assertSame(1640995200, $approved->sendDate);
        assertNull($approved->suggestedPostMessage);
        assertNull($approved->price);
    }

    public function testFull(): void
    {
        $message = new Message(123, new DateTimeImmutable(), new Chat(1, 'private'));
        $price = new SuggestedPostPrice('XTR', 50);
        $approved = new SuggestedPostApproved(1640995200, $message, $price);

        assertSame(1640995200, $approved->sendDate);
        assertSame($message, $approved->suggestedPostMessage);
        assertSame($price, $approved->price);
    }

    public function testFromTelegramResult(): void
    {
        $approved = (new ObjectFactory())->create(
            [
                'send_date' => 1672531200,
                'suggested_post_message' => [
                    'message_id' => 456,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 2,
                        'type' => 'channel',
                    ],
                    'text' => 'Suggested post content',
                ],
                'price' => [
                    'currency' => 'TON',
                    'amount' => 10000000,
                ],
            ],
            null,
            SuggestedPostApproved::class,
        );

        assertSame(1672531200, $approved->sendDate);
        assertInstanceOf(Message::class, $approved->suggestedPostMessage);
        assertSame(456, $approved->suggestedPostMessage->messageId);
        assertSame('Suggested post content', $approved->suggestedPostMessage->text);
        assertInstanceOf(SuggestedPostPrice::class, $approved->price);
        assertSame('TON', $approved->price->currency);
        assertSame(10000000, $approved->price->amount);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $approved = (new ObjectFactory())->create(
            [
                'send_date' => 1640995200,
            ],
            null,
            SuggestedPostApproved::class,
        );

        assertSame(1640995200, $approved->sendDate);
        assertNull($approved->suggestedPostMessage);
        assertNull($approved->price);
    }
}
