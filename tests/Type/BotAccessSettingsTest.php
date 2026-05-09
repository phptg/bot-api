<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotAccessSettings;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class BotAccessSettingsTest extends TestCase
{
    public function testBase(): void
    {
        $settings = new BotAccessSettings(false);

        assertSame(false, $settings->isAccessRestricted);
        assertNull($settings->addedUsers);
    }

    public function testFull(): void
    {
        $user1 = new User(1, false, 'Alice');
        $user2 = new User(2, false, 'Bob');
        $settings = new BotAccessSettings(true, [$user1, $user2]);

        assertSame(true, $settings->isAccessRestricted);
        assertSame([$user1, $user2], $settings->addedUsers);
    }

    public function testFromTelegramResult(): void
    {
        $settings = (new ObjectFactory())->create([
            'is_access_restricted' => true,
            'added_users' => [
                ['id' => 1, 'is_bot' => false, 'first_name' => 'Alice'],
                ['id' => 2, 'is_bot' => false, 'first_name' => 'Bob'],
            ],
        ], null, BotAccessSettings::class);

        assertInstanceOf(BotAccessSettings::class, $settings);
        assertSame(true, $settings->isAccessRestricted);
        assertInstanceOf(User::class, $settings->addedUsers[0]);
        assertSame(1, $settings->addedUsers[0]->id);
        assertSame('Alice', $settings->addedUsers[0]->firstName);
        assertInstanceOf(User::class, $settings->addedUsers[1]);
        assertSame(2, $settings->addedUsers[1]->id);
        assertSame('Bob', $settings->addedUsers[1]->firstName);
    }
}
