<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockAnchor;

use function PHPUnit\Framework\assertSame;

final class RichBlockAnchorTest extends TestCase
{
    public function testBase(): void
    {
        $anchor = new RichBlockAnchor('section1');

        assertSame('anchor', $anchor->getType());
        assertSame('section1', $anchor->name);
    }

    public function testFromTelegramResult(): void
    {
        $anchor = (new ObjectFactory())->create([
            'type' => 'anchor',
            'name' => 'section1',
        ], null, RichBlockAnchor::class);

        assertSame('anchor', $anchor->getType());
        assertSame('section1', $anchor->name);
    }
}
