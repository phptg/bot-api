<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\BackgroundFillValue;

final class BackgroundFillValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundFillValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown background fill type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
