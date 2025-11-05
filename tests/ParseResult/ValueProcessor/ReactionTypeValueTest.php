<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\ReactionTypeValue;

final class ReactionTypeValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ReactionTypeValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown reaction type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
