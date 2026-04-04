<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\ReplaceManagedBotToken;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class ReplaceManagedBotTokenTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ReplaceManagedBotToken(123);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('replaceManagedBotToken', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ReplaceManagedBotToken(123);

        $preparedResult = TestHelper::createSuccessStubApi('789012:XYZ-abc3456defGhi-lmn78O9p2q456rs22')->call($method);

        assertSame('789012:XYZ-abc3456defGhi-lmn78O9p2q456rs22', $preparedResult);
    }
}
