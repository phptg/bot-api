<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\WebAppData;

use function PHPUnit\Framework\assertSame;

final class WebAppDataTest extends TestCase
{
    public function testBase(): void
    {
        $webAppData = new WebAppData('test', 'label');

        assertSame('test', $webAppData->data);
        assertSame('label', $webAppData->buttonText);
    }

    public function testFromTelegramResult(): void
    {
        $webAppData = (new ObjectFactory())->create([
            'data' => 'test',
            'button_text' => 'label',
        ], null, WebAppData::class);

        assertSame('test', $webAppData->data);
        assertSame('label', $webAppData->buttonText);
    }
}
