<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextDateTime;

use function PHPUnit\Framework\assertSame;

final class RichTextDateTimeTest extends TestCase
{
    public function testBase(): void
    {
        $dateTime = new RichTextDateTime('hello', 1749600000, 'Y-m-d H:i:s');

        assertSame('date_time', $dateTime->getType());
        assertSame('hello', $dateTime->text);
        assertSame(1749600000, $dateTime->unixTime);
        assertSame('Y-m-d H:i:s', $dateTime->dateTimeFormat);
    }

    public function testFromTelegramResult(): void
    {
        $dateTime = (new ObjectFactory())->create([
            'type' => 'date_time',
            'text' => 'hello',
            'unix_time' => 1749600000,
            'date_time_format' => 'Y-m-d H:i:s',
        ], null, RichTextDateTime::class);

        assertSame('date_time', $dateTime->getType());
        assertSame('hello', $dateTime->text);
        assertSame(1749600000, $dateTime->unixTime);
        assertSame('Y-m-d H:i:s', $dateTime->dateTimeFormat);
    }
}
