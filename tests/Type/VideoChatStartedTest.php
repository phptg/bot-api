<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoChatStarted;

final class VideoChatStartedTest extends TestCase
{
    public function testBase(): void
    {
        new VideoChatStarted();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, VideoChatStarted::class);
        $this->expectNotToPerformAssertions();
    }
}
