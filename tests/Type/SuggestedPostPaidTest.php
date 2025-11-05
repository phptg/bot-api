<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\StarAmount;
use Phptg\BotApi\Type\SuggestedPostPaid;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostPaidTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SuggestedPostPaid('XTR');

        assertSame('XTR', $type->currency);
        assertNull($type->suggestedPostMessage);
        assertNull($type->amount);
        assertNull($type->starAmount);
    }

    public function testFull(): void
    {
        $message = new Message(999, new DateTimeImmutable(), new Chat(35, 'channel'));
        $starAmount = new StarAmount(300, 1500);
        $type = new SuggestedPostPaid('XTR', $message, 100000000, $starAmount);

        assertSame('XTR', $type->currency);
        assertSame($message, $type->suggestedPostMessage);
        assertSame(100000000, $type->amount);
        assertSame($starAmount, $type->starAmount);
    }

    public function testFromTelegramResult(): void
    {
        $paid = (new ObjectFactory())->create(
            [
                'suggested_post_message' => [
                    'message_id' => 777,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 25,
                        'type' => 'channel',
                    ],
                    'text' => 'Paid post content',
                ],
                'currency' => 'XTR',
                'amount' => 75000000,
                'star_amount' => [
                    'amount' => 250,
                    'nanostar_amount' => 1250,
                ],
            ],
            null,
            SuggestedPostPaid::class,
        );

        assertSame('XTR', $paid->currency);
        assertInstanceOf(Message::class, $paid->suggestedPostMessage);
        assertSame(777, $paid->suggestedPostMessage->messageId);
        assertSame('Paid post content', $paid->suggestedPostMessage->text);
        assertSame(75000000, $paid->amount);
        assertInstanceOf(StarAmount::class, $paid->starAmount);
        assertSame(250, $paid->starAmount->amount);
        assertSame(1250, $paid->starAmount->nanostarAmount);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $paid = (new ObjectFactory())->create(
            [
                'currency' => 'TON',
            ],
            null,
            SuggestedPostPaid::class,
        );

        assertSame('TON', $paid->currency);
        assertNull($paid->suggestedPostMessage);
        assertNull($paid->amount);
        assertNull($paid->starAmount);
    }
}
