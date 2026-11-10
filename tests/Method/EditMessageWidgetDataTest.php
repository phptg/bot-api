<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\EditMessageWidgetData;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditMessageWidgetDataTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageWidgetData();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageWidgetData', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new EditMessageWidgetData('@channel', 1, 'inlineId', 'publicData', 'chatData');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageWidgetData', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => '@channel',
                'message_id' => 1,
                'inline_message_id' => 'inlineId',
                'public_data' => 'publicData',
                'chat_data' => 'chatData',
            ],
            $method->getData(),
        );
    }

    public function testEmptyStringDataIsKept(): void
    {
        $method = new EditMessageWidgetData(chatId: 42, messageId: 1, publicData: '', chatData: '');

        assertSame(
            [
                'chat_id' => 42,
                'message_id' => 1,
                'public_data' => '',
                'chat_data' => '',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageWidgetData(chatId: 42, messageId: 1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
