<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\LoginUrl;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class LoginUrlTest extends TestCase
{
    public function testBase(): void
    {
        $loginUrl = new LoginUrl('https://example.com/');

        assertSame('https://example.com/', $loginUrl->url);
        assertNull($loginUrl->forwardText);
        assertNull($loginUrl->botUsername);
        assertNull($loginUrl->requestWriteAccess);

        assertSame(
            [
                'url' => 'https://example.com/',
            ],
            $loginUrl->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $loginUrl = new LoginUrl('https://example.com/', 'ft', 'bun', false);

        assertSame('https://example.com/', $loginUrl->url);
        assertSame('ft', $loginUrl->forwardText);
        assertSame('bun', $loginUrl->botUsername);
        assertFalse($loginUrl->requestWriteAccess);

        assertSame(
            [
                'url' => 'https://example.com/',
                'forward_text' => 'ft',
                'bot_username' => 'bun',
                'request_write_access' => false,
            ],
            $loginUrl->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $loginUrl = (new ObjectFactory())->create(
            [
                'url' => 'https://example.com/',
                'forward_text' => 'ft',
                'bot_username' => 'bun',
                'request_write_access' => false,
            ],
            null,
            LoginUrl::class,
        );

        assertSame('https://example.com/', $loginUrl->url);
        assertSame('ft', $loginUrl->forwardText);
        assertSame('bun', $loginUrl->botUsername);
        assertFalse($loginUrl->requestWriteAccess);
    }
}
