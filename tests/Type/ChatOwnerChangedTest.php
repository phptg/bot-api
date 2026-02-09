<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatOwnerChanged;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatOwnerChangedTest extends TestCase
{
    public function testBase(): void
    {
        $newOwner = new User(1, false, 'Sergei');
        $chatOwnerChanged = new ChatOwnerChanged($newOwner);

        assertSame($newOwner, $chatOwnerChanged->newOwner);
    }

    public function testFromTelegramResult(): void
    {
        $chatOwnerChanged = (new ObjectFactory())->create([
            'new_owner' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ], null, ChatOwnerChanged::class);

        assertInstanceOf(User::class, $chatOwnerChanged->newOwner);
        assertSame(1, $chatOwnerChanged->newOwner->id);
    }
}
