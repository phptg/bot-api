<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Method\Update\GetWebhookInfo;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetWebhookInfoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetWebhookInfo();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getWebhookInfo', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetWebhookInfo();

        $preparedResult = TestHelper::createSuccessStubApi([
            'url' => 'https://example.com/',
            'has_custom_certificate' => true,
            'pending_update_count' => 12,
        ])->call($method);

        assertSame('https://example.com/', $preparedResult->url);
    }
}
