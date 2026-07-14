<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockAnchor;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockAnchorTest extends TestCase
{
    public function testBase(): void
    {
        $anchor = new InputRichBlockAnchor('section1');

        assertSame('anchor', $anchor->getType());
        assertSame(
            ['type' => 'anchor', 'name' => 'section1'],
            $anchor->toRequestArray(),
        );
    }
}
