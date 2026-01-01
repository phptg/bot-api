<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetChatGifts;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\OwnedGifts;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetChatGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatGifts(chatId: 12345);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatGifts', $method->getApiMethod());
        assertSame(
            ['chat_id' => 12345],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetChatGifts(
            12345,
            true,
            false,
            true,
            false,
            true,
            false,
            true,
            true,
            'offset_value',
            50,
        );

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatGifts', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12345,
                'exclude_unsaved' => true,
                'exclude_saved' => false,
                'exclude_unlimited' => true,
                'exclude_limited_upgradable' => false,
                'exclude_limited_non_upgradable' => true,
                'exclude_from_blockchain' => false,
                'exclude_unique' => true,
                'sort_by_price' => true,
                'offset' => 'offset_value',
                'limit' => 50,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatGifts(chatId: 12345);

        $result = TestHelper::createSuccessStubApi([
            'total_count' => 0,
            'gifts' => [],
        ])->call($method);

        assertInstanceOf(OwnedGifts::class, $result);
        assertEmpty($result->gifts);
    }
}
