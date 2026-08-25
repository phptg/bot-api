<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\DisabledButton;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class DisabledButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new DisabledButton();

        assertSame([], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([], null, DisabledButton::class);

        assertInstanceOf(DisabledButton::class, $button);
    }
}
