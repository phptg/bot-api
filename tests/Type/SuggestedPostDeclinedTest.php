<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\SuggestedPostDeclined;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostDeclinedTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SuggestedPostDeclined();

        assertNull($type->suggestedPostMessage);
        assertNull($type->comment);
    }

    public function testFull(): void
    {
        $message = new Message(222, new DateTimeImmutable(), new Chat(9, 'supergroup'));
        $type = new SuggestedPostDeclined($message, 'Does not meet community guidelines');

        assertSame($message, $type->suggestedPostMessage);
        assertSame('Does not meet community guidelines', $type->comment);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'suggested_post_message' => [
                    'message_id' => 333,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 12,
                        'type' => 'channel',
                    ],
                    'text' => 'Declined post content',
                ],
                'comment' => 'Violates terms of service',
            ],
            null,
            SuggestedPostDeclined::class,
        );

        assertInstanceOf(Message::class, $type->suggestedPostMessage);
        assertSame(333, $type->suggestedPostMessage->messageId);
        assertSame('Declined post content', $type->suggestedPostMessage->text);
        assertSame('Violates terms of service', $type->comment);
    }

    public function testFromTelegramResultMinimal(): void
    {
        $type = (new ObjectFactory())->create(
            [],
            null,
            SuggestedPostDeclined::class,
        );

        assertNull($type->suggestedPostMessage);
        assertNull($type->comment);
    }
}
