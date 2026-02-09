<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatOwnerLeft;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChatOwnerLeftTest extends TestCase
{
    public function testBase(): void
    {
        $chatOwnerLeft = new ChatOwnerLeft();

        assertNull($chatOwnerLeft->newOwner);
    }

    public function testFull(): void
    {
        $newOwner = new User(1, false, 'Sergei');
        $chatOwnerLeft = new ChatOwnerLeft($newOwner);

        assertSame($newOwner, $chatOwnerLeft->newOwner);
    }

    public function testFromTelegramResult(): void
    {
        $chatOwnerLeft = (new ObjectFactory())->create([
            'new_owner' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ], null, ChatOwnerLeft::class);

        assertInstanceOf(User::class, $chatOwnerLeft->newOwner);
        assertSame(1, $chatOwnerLeft->newOwner->id);
    }
}
