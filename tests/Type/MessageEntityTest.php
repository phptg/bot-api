<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class MessageEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);

        assertSame('bold', $messageEntity->type);
        assertSame(0, $messageEntity->offset);
        assertSame(4, $messageEntity->length);
        assertNull($messageEntity->url);
        assertNull($messageEntity->user);
        assertNull($messageEntity->language);
        assertNull($messageEntity->customEmojiId);

        assertSame(
            [
                'type' => 'bold',
                'offset' => 0,
                'length' => 4,
            ],
            $messageEntity->toRequestArray(),
        );
    }

    public function testToRequestArray(): void
    {
        $messageEntity = new MessageEntity(
            'bold',
            0,
            4,
            'https://example.com/',
            new User(1, false, 'Sergei'),
            'ru',
            'x6',
        );

        assertSame(
            [
                'type' => 'bold',
                'offset' => 0,
                'length' => 4,
                'url' => 'https://example.com/',
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
                'language' => 'ru',
                'custom_emoji_id' => 'x6',
            ],
            $messageEntity->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $messageEntity = (new ObjectFactory())->create([
            'type' => 'bold',
            'offset' => 0,
            'length' => 4,
            'url' => 'https://example.com/',
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'language' => 'ru',
            'custom_emoji_id' => 'x6',
        ], null, MessageEntity::class);

        assertSame('bold', $messageEntity->type);
        assertSame(0, $messageEntity->offset);
        assertSame(4, $messageEntity->length);
        assertSame('https://example.com/', $messageEntity->url);

        assertInstanceOf(User::class, $messageEntity->user);
        assertSame(1, $messageEntity->user->id);
        assertFalse($messageEntity->user->isBot);
        assertSame('Sergei', $messageEntity->user->firstName);

        assertSame('ru', $messageEntity->language);
        assertSame('x6', $messageEntity->customEmojiId);
    }
}
