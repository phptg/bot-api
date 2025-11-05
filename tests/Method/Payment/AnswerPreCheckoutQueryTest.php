<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Payment\AnswerPreCheckoutQuery;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AnswerPreCheckoutQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerPreCheckoutQuery', $method->getApiMethod());
        assertSame(
            [
                'pre_checkout_query_id' => 'qid',
                'ok' => true,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
            'error message',
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerPreCheckoutQuery', $method->getApiMethod());
        assertSame(
            [
                'pre_checkout_query_id' => 'qid',
                'ok' => true,
                'error_message' => 'error message',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
