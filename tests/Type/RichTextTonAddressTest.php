<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextTonAddress;

use function PHPUnit\Framework\assertSame;

final class RichTextTonAddressTest extends TestCase
{
    public function testBase(): void
    {
        $tonAddress = new RichTextTonAddress('hello', 'xxx');

        assertSame('ton_address', $tonAddress->getType());
        assertSame('hello', $tonAddress->text);
        assertSame('xxx', $tonAddress->address);
        assertSame(
            [
                'type' => 'ton_address',
                'text' => 'hello',
                'address' => 'xxx',
            ],
            $tonAddress->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $tonAddress = (new ObjectFactory())->create([
            'type' => 'ton_address',
            'text' => 'hello',
            'address' => 'xxx',
        ], null, RichTextTonAddress::class);

        assertSame('ton_address', $tonAddress->getType());
        assertSame('hello', $tonAddress->text);
        assertSame('xxx', $tonAddress->address);
    }
}
