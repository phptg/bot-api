<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\AnswerChatJoinRequestQuery;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AnswerChatJoinRequestQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerChatJoinRequestQuery('qid1', 'approve');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerChatJoinRequestQuery', $method->getApiMethod());
        assertSame(
            [
                'chat_join_request_query_id' => 'qid1',
                'result' => 'approve',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerChatJoinRequestQuery('qid1', 'approve');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
