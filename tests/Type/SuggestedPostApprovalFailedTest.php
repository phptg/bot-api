<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\SuggestedPostApprovalFailed;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostApprovalFailedTest extends TestCase
{
    public function testBase(): void
    {
        $price = new SuggestedPostPrice('XTR', 150);
        $type = new SuggestedPostApprovalFailed($price);

        assertSame($price, $type->price);
        assertNull($type->suggestedPostMessage);
    }

    public function testFull(): void
    {
        $message = new Message(789, new DateTimeImmutable(), new Chat(5, 'channel'));
        $price = new SuggestedPostPrice('TON', 25000000);
        $type = new SuggestedPostApprovalFailed($price, $message);

        assertSame($price, $type->price);
        assertSame($message, $type->suggestedPostMessage);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'price' => [
                    'currency' => 'USD',
                    'amount' => 500,
                ],
                'suggested_post_message' => [
                    'message_id' => 654,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 8,
                        'type' => 'supergroup',
                    ],
                    'text' => 'Failed approval post content',
                ],
            ],
            null,
            SuggestedPostApprovalFailed::class,
        );

        assertInstanceOf(SuggestedPostPrice::class, $type->price);
        assertSame('USD', $type->price->currency);
        assertSame(500, $type->price->amount);
        assertInstanceOf(Message::class, $type->suggestedPostMessage);
        assertSame(654, $type->suggestedPostMessage->messageId);
        assertSame('Failed approval post content', $type->suggestedPostMessage->text);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'price' => [
                    'currency' => 'EUR',
                    'amount' => 1000,
                ],
            ],
            null,
            SuggestedPostApprovalFailed::class,
        );

        assertInstanceOf(SuggestedPostPrice::class, $type->price);
        assertSame('EUR', $type->price->currency);
        assertSame(1000, $type->price->amount);
        assertNull($type->suggestedPostMessage);
    }
}
