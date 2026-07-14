<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockSectionHeading;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockSectionHeadingTest extends TestCase
{
    public function testBase(): void
    {
        $heading = new InputRichBlockSectionHeading('hello', 2);

        assertSame('heading', $heading->getType());
        assertSame(
            ['type' => 'heading', 'text' => 'hello', 'size' => 2],
            $heading->toRequestArray(),
        );
    }
}
