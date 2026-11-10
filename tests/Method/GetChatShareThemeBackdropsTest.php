<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetChatShareThemeBackdrops;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ChatShareThemeBackdrops;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetChatShareThemeBackdropsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatShareThemeBackdrops();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatShareThemeBackdrops', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatShareThemeBackdrops();

        $preparedResult = TestHelper::createSuccessStubApi([
            'backdrops' => [
                [
                    'id' => 7,
                    'name' => 'Patterned Blue',
                    'colors' => [
                        'center_color' => 1114112,
                        'edge_color' => 11206655,
                        'symbol_color' => 11316351,
                        'text_color' => 11316351,
                    ],
                ],
            ],
        ])->call($method);

        assertInstanceOf(ChatShareThemeBackdrops::class, $preparedResult);
        assertCount(1, $preparedResult->backdrops);
        assertSame(7, $preparedResult->backdrops[0]->id);
        assertSame('Patterned Blue', $preparedResult->backdrops[0]->name);
    }
}
