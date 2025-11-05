<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMyDescription;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetMyDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyDescription();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyDescription', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyDescription('ru');

        assertSame(
            [
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyDescription();

        $preparedResult = TestHelper::createSuccessStubApi([
            'description' => 'test',
        ])->call($method);

        assertSame('test', $preparedResult->description);
    }
}
