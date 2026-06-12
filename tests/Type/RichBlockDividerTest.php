<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockDivider;

use function PHPUnit\Framework\assertSame;

final class RichBlockDividerTest extends TestCase
{
    public function testBase(): void
    {
        $divider = new RichBlockDivider();

        assertSame('divider', $divider->getType());
    }

    public function testFromTelegramResult(): void
    {
        $divider = (new ObjectFactory())->create([
            'type' => 'divider',
        ], null, RichBlockDivider::class);

        assertSame('divider', $divider->getType());
    }
}
