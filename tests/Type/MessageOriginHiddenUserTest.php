<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageOriginHiddenUser;

use function PHPUnit\Framework\assertSame;

final class MessageOriginHiddenUserTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $origin = new MessageOriginHiddenUser($date, 'Mike');

        assertSame('hidden_user', $origin->getType());
        assertSame($date, $origin->getDate());
        assertSame($date, $origin->date);
        assertSame('Mike', $origin->senderUserName);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'hidden_user',
            'date' => 12412512,
            'sender_user_name' => 'Mike',
        ], null, MessageOriginHiddenUser::class);

        assertSame('hidden_user', $origin->getType());
        assertSame(12412512, $origin->getDate()->getTimestamp());
        assertSame(12412512, $origin->date->getTimestamp());
        assertSame('Mike', $origin->senderUserName);
    }
}
