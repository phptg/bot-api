<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockThinking;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockThinkingTest extends TestCase
{
    public function testBase(): void
    {
        $thinking = new InputRichBlockThinking('hello');

        assertSame('thinking', $thinking->getType());
        assertSame(
            ['type' => 'thinking', 'text' => 'hello'],
            $thinking->toRequestArray(),
        );
    }
}
