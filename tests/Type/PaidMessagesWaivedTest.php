<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMessagesWaived;

use function PHPUnit\Framework\assertSame;

final class PaidMessagesWaivedTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new PaidMessagesWaived()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, PaidMessagesWaived::class);
        $this->expectNotToPerformAssertions();
    }
}
