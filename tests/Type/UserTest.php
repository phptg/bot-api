<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class UserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');

        assertSame(1, $user->id);
        assertSame(false, $user->isBot);
        assertSame('Sergei', $user->firstName);
        assertNull($user->lastName);
        assertNull($user->username);
        assertNull($user->languageCode);
        assertNull($user->isPremium);
        assertNull($user->addedToAttachmentMenu);
    }

    public function testToRequestArray(): void
    {
        $user = new User(
            1,
            false,
            'Sergei',
            'Ivanov',
            'sergei_ivanov',
            'ru-RU',
            true,
            true,
        );

        assertSame(
            [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
                'last_name' => 'Ivanov',
                'username' => 'sergei_ivanov',
                'language_code' => 'ru-RU',
                'is_premium' => true,
                'added_to_attachment_menu' => true,
            ],
            $user->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $user = (new ObjectFactory())->create([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
            'last_name' => 'Ivanov',
            'username' => 'sergei_ivanov',
            'language_code' => 'ru-RU',
            'is_premium' => true,
            'added_to_attachment_menu' => true,
        ], null, User::class);

        assertInstanceOf(User::class, $user);
        assertSame(1, $user->id);
        assertSame(false, $user->isBot);
        assertSame('Sergei', $user->firstName);
        assertSame('Ivanov', $user->lastName);
        assertSame('sergei_ivanov', $user->username);
        assertSame('ru-RU', $user->languageCode);
        assertSame(true, $user->isPremium);
        assertSame(true, $user->addedToAttachmentMenu);
    }
}
