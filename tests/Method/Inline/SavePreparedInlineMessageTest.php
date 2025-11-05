<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Inline\SavePreparedInlineMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Inline\InlineQueryResultGame;
use Phptg\BotApi\Type\Inline\PreparedInlineMessage;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class SavePreparedInlineMessageTest extends TestCase
{
    public function testBase(): void
    {
        $result = new InlineQueryResultGame('tid', 'Hello');
        $method = new SavePreparedInlineMessage(93, $result);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('savePreparedInlineMessage', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 93,
                'result' => $result->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $result = new InlineQueryResultGame('tid', 'Hello');
        $method = new SavePreparedInlineMessage(91, $result, true, false, true, false);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('savePreparedInlineMessage', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 91,
                'result' => $result->toRequestArray(),
                'allow_user_chats' => true,
                'allow_bot_chats' => false,
                'allow_group_chats' => true,
                'allow_channel_chats' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SavePreparedInlineMessage(93, new InlineQueryResultGame('tid', 'Hello'));

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 'testId',
            'expiration_date' => 1731917862,
        ])->call($method);

        assertInstanceOf(PreparedInlineMessage::class, $preparedResult);
        assertSame('testId', $preparedResult->id);
        assertSame(1731917862, $preparedResult->expirationDate->getTimestamp());
    }
}
