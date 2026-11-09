<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\AnswerWidgetQuery;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AnswerWidgetQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerWidgetQuery('id');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerWidgetQuery', $method->getApiMethod());
        assertSame(
            [
                'widget_query_id' => 'id',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new AnswerWidgetQuery('id', 'data');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerWidgetQuery', $method->getApiMethod());
        assertSame(
            [
                'widget_query_id' => 'id',
                'data' => 'data',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerWidgetQuery('id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
