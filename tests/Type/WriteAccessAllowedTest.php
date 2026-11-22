<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\WriteAccessAllowed;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class WriteAccessAllowedTest extends TestCase
{
    public function testBase(): void
    {
        $writeAccessAllowed = new WriteAccessAllowed();

        assertNull($writeAccessAllowed->fromRequest);
        assertNull($writeAccessAllowed->webAppName);
        assertNull($writeAccessAllowed->fromAttachmentMenu);
        assertNull($writeAccessAllowed->inviter);
    }

    public function testFull(): void
    {
        $inviter = new User(1, true, 'Bot Owner');
        $writeAccessAllowed = new WriteAccessAllowed(true, 'test', false, $inviter);

        assertTrue($writeAccessAllowed->fromRequest);
        assertSame('test', $writeAccessAllowed->webAppName);
        assertFalse($writeAccessAllowed->fromAttachmentMenu);
        assertSame($inviter, $writeAccessAllowed->inviter);
    }

    public function testFromTelegramResult(): void
    {
        $writeAccessAllowed = (new ObjectFactory())->create([], null, WriteAccessAllowed::class);

        assertNull($writeAccessAllowed->fromRequest);
        assertNull($writeAccessAllowed->webAppName);
        assertNull($writeAccessAllowed->fromAttachmentMenu);
        assertNull($writeAccessAllowed->inviter);
    }

    public function testFromTelegramResultFull(): void
    {
        $writeAccessAllowed = (new ObjectFactory())->create([
            'from_request' => true,
            'web_app_name' => 'test',
            'from_attachment_menu' => false,
            'inviter' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'Bot Owner',
            ],
        ], null, WriteAccessAllowed::class);

        assertTrue($writeAccessAllowed->fromRequest);
        assertSame('test', $writeAccessAllowed->webAppName);
        assertFalse($writeAccessAllowed->fromAttachmentMenu);
        assertInstanceOf(User::class, $writeAccessAllowed->inviter);
        assertSame(1, $writeAccessAllowed->inviter->id);
        assertSame('Bot Owner', $writeAccessAllowed->inviter->firstName);
    }
}
