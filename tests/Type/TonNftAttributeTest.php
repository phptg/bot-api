<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\TonNftAttribute;

use function PHPUnit\Framework\assertSame;

final class TonNftAttributeTest extends TestCase
{
    public function testBase(): void
    {
        $attribute = new TonNftAttribute('color', 'blue');

        assertSame('color', $attribute->traitType);
        assertSame('blue', $attribute->value);
    }

    public function testFromTelegramResult(): void
    {
        $attribute = (new ObjectFactory())->create([
            'trait_type' => 'color',
            'value' => 'blue',
        ], null, TonNftAttribute::class);

        assertSame('color', $attribute->traitType);
        assertSame('blue', $attribute->value);
    }
}
