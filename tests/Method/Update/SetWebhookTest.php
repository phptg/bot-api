<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Method\Update\SetWebhook;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetWebhookTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetWebhook('https://example.com/hook');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setWebhook', $method->getApiMethod());
        assertSame(
            [
                'url' => 'https://example.com/hook',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetWebhook(
            'https://example.com/hook',
            '127.0.0.1',
            12,
            ['update1', 'update2'],
            true,
            'asdg23y',
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setWebhook', $method->getApiMethod());
        assertSame(
            [
                'url' => 'https://example.com/hook',
                'ip_address' => '127.0.0.1',
                'max_connections' => 12,
                'allowed_updates' => ['update1', 'update2'],
                'drop_pending_updates' => true,
                'secret_token' => 'asdg23y',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetWebhook('https://example.com/hook');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
