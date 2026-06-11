<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\RichBlockValue;
use Phptg\BotApi\Type\RichBlockParagraph;

use function PHPUnit\Framework\assertInstanceOf;

final class RichBlockValueTest extends TestCase
{
    public function testParagraph(): void
    {
        $result = (new RichBlockValue())->process(
            ['type' => 'paragraph', 'text' => 'hello'],
            null,
            new ObjectFactory(),
        );

        assertInstanceOf(RichBlockParagraph::class, $result);
    }

    public function testUnknown(): void
    {
        $processor = new RichBlockValue();
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown rich block type.');
        $processor->process(['type' => 'unknown'], null, $objectFactory);
    }
}
