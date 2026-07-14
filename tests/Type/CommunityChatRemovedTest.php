<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\CommunityChatRemoved;

final class CommunityChatRemovedTest extends TestCase
{
    public function testBase(): void
    {
        new CommunityChatRemoved();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, CommunityChatRemoved::class);
        $this->expectNotToPerformAssertions();
    }
}
