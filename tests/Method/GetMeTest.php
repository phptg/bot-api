<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMe;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetMeTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMe();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMe', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetMe();

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
        ])->call($method);

        assertInstanceOf(User::class, $preparedResult);
        assertSame(1, $preparedResult->id);
    }
}
