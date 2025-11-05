<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\LogOut;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class LogOutTest extends TestCase
{
    public function testBase(): void
    {
        $method = new LogOut();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('logOut', $method->getApiMethod());
        assertSame([], $method->getData());
        assertTrue(TestHelper::createSuccessStubApi(true)->call($method));
    }
}
