<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Inline\AnswerGuestQuery;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Inline\InlineQueryResultContact;

use function PHPUnit\Framework\assertSame;

final class AnswerGuestQueryTest extends TestCase
{
    public function testBase(): void
    {
        $result = new InlineQueryResultContact('1', '+79001234567', 'Vjik');
        $method = new AnswerGuestQuery('guest_id_123', $result);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerGuestQuery', $method->getApiMethod());
        assertSame(
            [
                'guest_query_id' => 'guest_id_123',
                'result' => $result->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerGuestQuery('guest_id_456', new InlineQueryResultContact('1', '+79001234567', 'Vjik'));

        $preparedResult = TestHelper::createSuccessStubApi([
            'inline_message_id' => 'guest_msg_789',
        ])->call($method);

        assertSame('guest_msg_789', $preparedResult->inlineMessageId);
    }
}
