<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextCashtag;

use function PHPUnit\Framework\assertSame;

final class RichTextCashtagTest extends TestCase
{
    public function testBase(): void
    {
        $cashtag = new RichTextCashtag('hello', '$AAPL');

        assertSame('cashtag', $cashtag->getType());
        assertSame('hello', $cashtag->text);
        assertSame('$AAPL', $cashtag->cashtag);
    }

    public function testFromTelegramResult(): void
    {
        $cashtag = (new ObjectFactory())->create([
            'type' => 'cashtag',
            'text' => 'hello',
            'cashtag' => '$AAPL',
        ], null, RichTextCashtag::class);

        assertSame('cashtag', $cashtag->getType());
        assertSame('hello', $cashtag->text);
        assertSame('$AAPL', $cashtag->cashtag);
    }
}
