<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Method\Update\DeleteWebhook;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteWebhookTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteWebhook();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteWebhook', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new DeleteWebhook(true);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteWebhook', $method->getApiMethod());
        assertSame(
            [
                'drop_pending_updates' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteWebhook();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
