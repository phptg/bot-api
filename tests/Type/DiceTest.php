<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Dice;

use function PHPUnit\Framework\assertSame;

final class DiceTest extends TestCase
{
    public function testBase(): void
    {
        $dice = new Dice('🎲', 6);

        assertSame('🎲', $dice->emoji);
        assertSame(6, $dice->value);
    }

    public function testFromTelegramResult(): void
    {
        $dice = (new ObjectFactory())->create([
            'emoji' => '🎲',
            'value' => 6,
        ], null, Dice::class);

        assertSame('🎲', $dice->emoji);
        assertSame(6, $dice->value);
    }
}
