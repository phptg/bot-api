<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMyShortDescription;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetMyShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyShortDescription();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyShortDescription', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyShortDescription('ru');

        assertSame(
            [
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyShortDescription();

        $preparedResult = TestHelper::createSuccessStubApi([
            'short_description' => 'test',
        ])->call($method);

        assertSame('test', $preparedResult->shortDescription);
    }
}
