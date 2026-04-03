<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetManagedBotToken;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetManagedBotTokenTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetManagedBotToken(123);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('getManagedBotToken', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetManagedBotToken(123);

        $preparedResult = TestHelper::createSuccessStubApi('123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11')->call($method);

        assertSame('123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', $preparedResult);
    }
}
