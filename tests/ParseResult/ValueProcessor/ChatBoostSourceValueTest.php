<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\ChatBoostSourceValue;

final class ChatBoostSourceValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatBoostSourceValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat boost source.');
        $processor->process(['source' => 'test'], null, $objectFactory);
    }
}
