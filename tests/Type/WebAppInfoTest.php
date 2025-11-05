<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\WebAppInfo;

use function PHPUnit\Framework\assertSame;

final class WebAppInfoTest extends TestCase
{
    public function testBase(): void
    {
        $webAppInfo = new WebAppInfo('https://example.com');

        assertSame('https://example.com', $webAppInfo->url);

        assertSame(
            [
                'url' => 'https://example.com',
            ],
            $webAppInfo->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $webAppInfo = (new ObjectFactory())->create([
            'url' => 'https://example.com',
        ], null, WebAppInfo::class);

        assertSame('https://example.com', $webAppInfo->url);
    }
}
