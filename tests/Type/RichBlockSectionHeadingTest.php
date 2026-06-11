<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockSectionHeading;

use function PHPUnit\Framework\assertSame;

final class RichBlockSectionHeadingTest extends TestCase
{
    public function testBase(): void
    {
        $heading = new RichBlockSectionHeading('hello', 1);

        assertSame('heading', $heading->getType());
        assertSame('hello', $heading->text);
        assertSame(1, $heading->size);
    }

    public function testFromTelegramResult(): void
    {
        $heading = (new ObjectFactory())->create([
            'type' => 'heading',
            'text' => 'hello',
            'size' => 2,
        ], null, RichBlockSectionHeading::class);

        assertSame('heading', $heading->getType());
        assertSame('hello', $heading->text);
        assertSame(2, $heading->size);
    }
}
