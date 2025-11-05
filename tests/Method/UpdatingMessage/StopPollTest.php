<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\StopPoll;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertSame;

final class StopPollTest extends TestCase
{
    public function testBase(): void
    {
        $method = new StopPoll(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('stopPoll', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new StopPoll(1, 2, 'bid', $replyMarkup);

        assertSame(
            [
                'business_connection_id' => 'bid',
                'chat_id' => 1,
                'message_id' => 2,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new StopPoll(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => '12',
            'question' => 'Why?',
            'options' => [
                ['text' => 'One', 'voter_count' => 12],
            ],
            'total_voter_count' => 42,
            'is_closed' => true,
            'is_anonymous' => false,
            'type' => 'regular',
            'allows_multiple_answers' => true,
        ])->call($method);

        assertSame('12', $preparedResult->id);
    }
}
